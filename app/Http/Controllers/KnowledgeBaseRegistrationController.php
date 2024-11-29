<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Services\Subscribe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Mollie\Contracts\GetMolliePayment;
use Mollie\Api\Types\PaymentStatus;

class KnowledgeBaseRegistrationController extends Controller
{
    public function knowledgeBaseLandingPage()
    {
        return view('web.knowledge-base-landing');
    }

    public function knowledgeBaseRegister(StoreSubscriptionRequest $request, Subscribe $subscribeService)
    {
        Log::debug("Starting knowledge base registration from page form");

        try
        {
            $coupon = $request->subscription_coupon ? $request->subscription_coupon : '';
            return $subscribeService->subscribe($request->subscription_email, $request->subscription_firstname, $request->subscription_lastname, $request->subscription_subscription_type, $coupon);
        }
        catch( \Exception $e)
        {
            return back()->withErrors([
                'subscription_email' => $e->getMessage()
            ]);
        }
    }

    public function knowledgeBaseAfterPayment(Request $request, GetMolliePayment $getMolliePayment)
    {
        $payment_id = $request->payment_id;

        // $payment = Payment::findByPaymentId($payment_id);
        $payment = $getMolliePayment->execute($payment_id);

        if(!$payment)
        {
            Log::error('Payment with ID '.$payment_id.' not found.');
            abort(404);
        }

        // $status = $payment->mollie_payment_status;
        $status = $payment->status;

        Log::info('Payment with ID '.$payment_id.' has status '.$status.'.');

        $response = redirect(route('knowledgebase.subscription.thankyou'));

        /* Check the payment.
           On success redirect to thank you.
           On fail redirect to error page and log details. */
        switch($status)
        {
            case PaymentStatus::STATUS_OPEN:
            case PaymentStatus::STATUS_PENDING:
            case PaymentStatus::STATUS_AUTHORIZED:
            case PaymentStatus::STATUS_PAID:
                break;
            case PaymentStatus::STATUS_CANCELED:
            case PaymentStatus::STATUS_EXPIRED:
            case PaymentStatus::STATUS_FAILED:
                $response = redirect(route('knowledgebase.subscription.payment.error'));
                break;
        }

        return $response;
    }

    public function knowledgeBaseThankYou()
    {
        return view('web.knowledge-base-registration-confirm', [
            'previousPage' => route('knowledgebase.landing')
        ]);
    }

    public function knowledgeBasePaymentError(Request $request)
    {
        return view('web.knowledge-base-registration-error', [
            'previousPage' => route('knowledgebase.landing')
        ]);
    }
}