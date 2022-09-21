<?php

namespace App\Console\Commands;

use App\Models\Acquiring\AcquiringPaymentCustom;
use App\Models\Shop;
use Avlyalin\SberbankAcquiring\Client\Client;
use Avlyalin\SberbankAcquiring\Commands\UpdateStatusCommand;
use Avlyalin\SberbankAcquiring\Factories\PaymentsFactory;
use Avlyalin\SberbankAcquiring\Models\AcquiringPaymentStatus;
use Avlyalin\SberbankAcquiring\Repositories\AcquiringPaymentRepository;
use Avlyalin\SberbankAcquiring\Repositories\AcquiringPaymentStatusRepository;

class SberUpdateStatusCommand extends UpdateStatusCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sber:update-status {--id=* : Only payments with specified status id will be updated}';


    /**
     * UpdateStatusCommand constructor.
     *
     * @param Client $client
     * @param AcquiringPaymentRepository $paymentRepository
     * @throws \Exception
     */
    public function __construct(Client $client, AcquiringPaymentRepository $paymentRepository)
    {
        // TODO:: сделеать управляемое поле is_active
        foreach (Shop::where('is_active', 1)->get() as $shop) {
            $apiClient = $shop->apiClient();
            $paymentsFactory = new PaymentsFactory();
            $acquiringPaymentRepository = new AcquiringPaymentRepository(new AcquiringPaymentCustom());
            $acquiringPaymentStatusRepository = new AcquiringPaymentStatusRepository(new AcquiringPaymentStatus);

            $client = new Client($apiClient, $paymentsFactory, $acquiringPaymentRepository, $acquiringPaymentStatusRepository);

            parent::__construct($client , $paymentRepository);
        }

    }


}
