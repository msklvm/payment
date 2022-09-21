<?php

namespace App\Models;

use App\Models\Acquiring\AcquiringPaymentCustom;
use App\User;
use Avlyalin\SberbankAcquiring\Client\ApiClient;
use Avlyalin\SberbankAcquiring\Client\Client;
use Avlyalin\SberbankAcquiring\Factories\PaymentsFactory;
use Avlyalin\SberbankAcquiring\Models\AcquiringPaymentStatus;
use Avlyalin\SberbankAcquiring\Repositories\AcquiringPaymentRepository;
use Avlyalin\SberbankAcquiring\Repositories\AcquiringPaymentStatusRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop extends Model
{
    use SoftDeletes;

    protected $table = 'sv_shop';
    protected $fillable = [
        'title',
        'description',
        'view',
        'emails_notification',
        'logo',
        'user_id',
        'token',

        'test_mode',
        'api_login',
        'api_password',

        'api_login_test',
        'api_password_test',

        'api_token',

        'fail_url',
        'return_url',

        'api_login_test',
        'api_password_test',
        'is_active',

        'deleted_at',
    ];

    private $completeStatusId = 4;

    public function products()
    {
        return $this->hasMany(Product::class, 'shop_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getLogo()
    {
        return route('shop.logo', ['id' => $this->id]);
    }

    public function purchase()
    {
        return $this->hasMany(Purchases::class);
    }

    public function setPurchase(int $payment_id)
    {
        $purchase = new Purchases();
        $purchase->shop_id = $this->id;
        $purchase->payment_id = $payment_id;
        $purchase->save();
    }

    public function scopePayments($query)
    {
        return $query->with(['purchase' => function ($query) {
            return $query->with(['payment' => function ($q) {
                return $q->with('payment', 'status');
            }])->orderBy('id', 'desc');
        }]);
    }

    public function scopeAllowed($query)
    {
        $user = auth()->user();

        $shop_ids = $user->getIdAllowedShops();

        if ($user->hasRole('Super admin') || $user->hasRole('Admin')) {
            return $query;
        }

        if (isset($shop_ids[0]) && $shop_ids[0] == '*') {
            return $query;
        } else {
            return $query->whereIn('id', $shop_ids);
        }
    }

    public function getViewForm()
    {
        $path = 'outside.pay.template.' . $this->view;

        if (!view()->exists($path)) {
            $this->createViewForm();
        }

        return view($path);
    }

    private function createViewForm()
    {
        $path = 'outside.pay.template.' . $this->view;

        $ds = DIRECTORY_SEPARATOR;
        $p = base_path() . $ds . 'resources' . $ds . 'views' . $ds . str_replace('.', $ds, $path) . '.blade.php';

        return file_put_contents($p, '');
    }

    public function getModeAttribute()
    {
        if (is_null($this->test_mode)) {
            $result = 0;
        } else {
            $result = $this->test_mode;
        }

        return $result;
    }

    public function getEmailForTagifyAttribute(): string
    {
        $result = '';
        if (!empty($this->emails_notification) && !is_null($this->emails_notification)) {
            $items = explode(',', $this->emails_notification);
            foreach ($items as $item) {
                $result .= "'$item',";
            }
        }

        return $result;
    }

    public function getTotalRevenueAttribute(): int
    {
        $result = 0;
        foreach ($this->purchase as $item) {
            $payment = $item->payment;

            if ($payment->status_id == $this->completeStatusId) {
                $result += $payment->payment->amount / 100;
            }
        }

        return $result;
    }

    public function getOrderCompleteAttribute(): int
    {
        $result = 0;

        foreach ($this->purchase as $item) {
            $payment = $item->payment;

            if ($payment->status_id == $this->completeStatusId)
                $result++;
        }

        return $result;
    }

    public function getApiLogin()
    {
        $login = !$this->mode ? $this->api_login_test : $this->api_login;

        if (is_null($login))
            throw new \RuntimeException('API Login null');

        return $login;
    }

    public function getApiPassword()
    {
        $password = !$this->mode ? $this->api_password_test : $this->api_password;

        if (is_null($password))
            throw new \RuntimeException('API Password null');

        return $password;
    }

    public function getToken()
    {
        return $this->api_token;
    }

    public function apiClient()
    {
        $baseUri = !$this->mode ? ApiClient::URI_TEST : ApiClient::URI_PROD;

        // TODO :: сделать проверку на правильность адреса
        /*if (!$this->mode) {
            if ($baseUri != ApiClient::URI_TEST) {
                throw new \RuntimeException('Ошибка получения адреса оплаты');
            }
        }*/

        if (!empty($this->api_token)) {
            $apiClient = new ApiClient([
                'token' => $this->api_token,
                'baseUri' => $baseUri,
            ]);
        } else {
            $apiClient = new ApiClient([
                'userName' => $this->getApiLogin(),
                'password' => $this->getApiPassword(),
                'baseUri' => $baseUri,
            ]);
        }

        return $apiClient;
    }

    public function createClient(): Client
    {
        $client = null;

        try {
            $apiClient = $this->apiClient();

            $paymentsFactory = new PaymentsFactory();
            $acquiringPaymentRepository = new AcquiringPaymentRepository(new AcquiringPaymentCustom());
            $acquiringPaymentStatusRepository = new AcquiringPaymentStatusRepository(new AcquiringPaymentStatus);

            $client = new Client($apiClient, $paymentsFactory, $acquiringPaymentRepository, $acquiringPaymentStatusRepository);
        } catch (\Exception $e) {
            abort(404, 'API Client error: ' . $e->getMessage());
        }

        return $client;
    }

    public function checkMerchant()
    {
        if ((empty($this->getApiLogin()) || empty($this->getApiPassword())) && empty($this->getToken())) {
            abort(404, "Unknown merchant.");
        }
    }

    public function scopeFilter($builder, $filters)
    {
        return $filters->apply($builder);
    }

    public function setReturnUrlAttribute($val)
    {
        $this->attributes['return_url'] = is_null($val) ? env('SBERBANK_RETURN_URL') : $val;
    }

    public function getReturnUrlAttribute($val): string
    {
        return is_null($val) ? env('SBERBANK_RETURN_URL') : $val;
    }

    public function setFailUrlAttribute($val)
    {
        $this->attributes['fail_url'] = is_null($val) ? env('SBERBANK_FAIL_URL') : $val;
    }

    public function getFailUrlAttribute($val): string
    {
        return is_null($val) ? env('SBERBANK_FAIL_URL') : $val;
    }
}
