<?php

namespace App\Observers;

use App\Mail\OrderPay;
use App\Models\Acquiring\AcquiringPaymentCustom;
use Avlyalin\SberbankAcquiring\Models\AcquiringPaymentStatus;
use Illuminate\Support\Facades\Mail;

class AcquiringPaymentObserver
{
    /**
     * Handle the acquiring payment "created" event.
     *
     * @param AcquiringPaymentCustom $acquiringPayment
     * @return void
     */
    public function created(AcquiringPaymentCustom $acquiringPayment)
    {
        //
    }

    /**
     * Handle the acquiring payment "updating" event.
     *
     * @param AcquiringPaymentCustom $acquiringPayment
     * @return void
     */
    public function updating(AcquiringPaymentCustom $acquiringPayment)
    {
        if ($acquiringPayment->isDirty('notification')) {
            // status_id has changed
//            $new_status = $acquiringPayment->status_id;

            if ($acquiringPayment->getOriginal('notification') == '0' && $acquiringPayment->status_id == AcquiringPaymentStatus::REGISTERED) {
                $paydata = $acquiringPayment::with(['shop'])->latest()->first();

                if (!is_null($paydata->shop) && !is_null($paydata->shop->emails_notification)) {
                    $emails = explode(',', $paydata->shop->emails_notification);
                    Mail::to($emails)->send(new OrderPay($acquiringPayment));
                }
            }
        }
    }

    /**
     * Handle the acquiring payment "deleted" event.
     *
     * @param AcquiringPaymentCustom $acquiringPayment
     * @return void
     */
    public function deleted(AcquiringPaymentCustom $acquiringPayment)
    {
        //
    }

    /**
     * Handle the acquiring payment "restored" event.
     *
     * @param AcquiringPaymentCustom $acquiringPayment
     * @return void
     */
    public function restored(AcquiringPaymentCustom $acquiringPayment)
    {
        //
    }

    /**
     * Handle the acquiring payment "force deleted" event.
     *
     * @param AcquiringPaymentCustom $acquiringPayment
     * @return void
     */
    public function forceDeleted(AcquiringPaymentCustom $acquiringPayment)
    {
        //
    }
}
