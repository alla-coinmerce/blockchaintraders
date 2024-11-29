<?php
 
namespace App\Listeners;

use App\Enums\Role;
use App\Models\User;
use App\Notifications\AdminErrorNotification;
use App\Notifications\NewSubscriberNotification;
use App\Notifications\OrderPaymentFailedNotification;
use App\Notifications\SubscriptionNotification;
use App\Notifications\SubscriptionWelcomeUserNotification;
use Illuminate\Auth\Events\Verified;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Events\BalanceTurnedStale;
use Laravel\Cashier\Events\ChargebackReceived;
use Laravel\Cashier\Events\CouponApplied;
use Laravel\Cashier\Events\FirstPaymentFailed;
use Laravel\Cashier\Events\FirstPaymentPaid;
use Laravel\Cashier\Events\MandateClearedFromBillable;
use Laravel\Cashier\Events\MandateUpdated;
use Laravel\Cashier\Events\OrderCreated;
use Laravel\Cashier\Events\OrderInvoiceAvailable;
use Laravel\Cashier\Events\OrderPaymentFailed;
use Laravel\Cashier\Events\OrderPaymentFailedDueToInvalidMandate;
use Laravel\Cashier\Events\OrderPaymentPaid;
use Laravel\Cashier\Events\OrderProcessed;
use Laravel\Cashier\Events\RefundFailed;
use Laravel\Cashier\Events\RefundInitiated;
use Laravel\Cashier\Events\RefundProcessed;
use Laravel\Cashier\Events\SubscriptionCancelled;
use Laravel\Cashier\Events\SubscriptionPlanSwapped;
use Laravel\Cashier\Events\SubscriptionQuantityUpdated;
use Laravel\Cashier\Events\SubscriptionResumed;
use Laravel\Cashier\Events\SubscriptionStarted;

class CashierEventSubscriber
{
    /**
     * Handle BalanceTurnedStale events.
     * 
     * The user has a positive account balance, but no active subscriptions. Consider a refund.
     */
    public function handleBalanceTurnedStale(BalanceTurnedStale $event): void
    {
        Log::info('BalanceTurnedStale');
    }

    /**
     * Handle CouponApplied events.
     * 
     * A coupon was applied to an OrderItem. Note the distinction between redeeming a coupon and applying a coupon. A redeemed coupon can be applied to multiple orders. I.e.  * applying a 6 month discount on a monthly subscription using a single (redeemed) coupon.
     */
    public function handleCouponApplied(CouponApplied $event): void
    {
        Log::info('CouponApplied');
    }

    /**
     * Handle FirstPaymentFailed events.
     * 
     * The first payment (used for obtaining a mandate) has failed.
     */
    public function handleFirstPaymentFailed(FirstPaymentFailed $event): void
    {
        Log::info('FirstPaymentFailed');
        Log::info('Payment '.$event->payment->id);
    }

    /**
     * Handle FirstPaymentPaid events.
     * 
     * The first payment (used for obtaining a mandate) was successful.
     */
    public function handleFirstPaymentPaid(FirstPaymentPaid $event): void
    {
        $order = $event->order;

        /** @var \Mollie\Api\Resources\Payment */
        $payment = $event->payment;

        Log::info('FirstPaymentPaid payment: '.$payment->id.' for order: '.$order->id);
        Log::info($payment->amount->value.' paid at '.$payment->paidAt);
    }

    /**
     * Handle MandateClearedFromBillable events.
     * 
     * The mollie_mandate_id was cleared on the billable model. This happens when a payment has failed because of a invalid mandate.
     */
    public function handleMandateClearedFromBillable(MandateClearedFromBillable $event): void
    {
        Log::info('MandateClearedFromBillable user: '.$event->owner->id.' oldMandateId: '.$event->oldMandateId);
    }

    /**
     * Handle MandateUpdated events.
     * 
     * The billable model's mandate was updated. This usually means a new payment card was registered.
     */
    public function handleMandateUpdated(MandateUpdated $event): void
    {
        Log::info('MandateUpdated');
        Log::info('Owner '.$event->owner->id);
        Log::info('Payment '.$event->payment->id);

        /** @var \App\Models\User */
        $user = $event->owner;

        $orders = $user->orders()->paymentStatus('failed')->get();

        foreach($orders as $order)
        {
            Log::info(('Retrying order '.$order->id));
            $order->retryNow();
        }
    }

    /**
     * Handle OrderCreated events.
     * 
     * An Order was created.
     */
    public function handleOrderCreated(OrderCreated $event): void
    {
        Log::info('OrderCreated '.$event->order);
    }

    /**
     * Handle OrderInvoiceAvailable events.
     * 
     * An Invoice is available on the Order. Access it using $event->order->invoice().
     */
    public function handleOrderInvoiceAvailable(OrderInvoiceAvailable $event): void
    {
        Log::info('OrderInvoiceAvailable for order: '.$event->order->id);
    }

    /**
     * Handle OrderPaymentFailed events.
     * 
     * The payment for an order has failed.
     */
    public function handleOrderPaymentFailed(OrderPaymentFailed $event): void
    {
        Log::info('OrderPaymentFailed');
        Log::info('Order '.$event->order);
        Log::info('Payment '.$event->payment);

        /** @var \App\Models\User */
        $user = $event->order->owner;

        $user->notify(new OrderPaymentFailedNotification($event->order));

        // Inform admins.
        $admins = User::where('role', Role::ADMIN->value)
                        ->get();

        foreach($admins as $admin)
        {
            $admin->notify(new AdminErrorNotification('Order payment failed for user '.$user->firstname.' '.$user->lastname).'. (Order '.$event->order->id.')');
        }
    }

    /**
     * Handle OrderPaymentFailedDueToInvalidMandate events.
     * 
     * The payment for an order has failed due to an invalid payment mandate. This happens for example when the customer's credit card has expired.
     */
    public function handleOrderPaymentFailedDueToInvalidMandate(OrderPaymentFailedDueToInvalidMandate $event): void
    {
        Log::info('OrderPaymentFailedDueToInvalidMandate');
        Log::info('Order '.$event->order);

        /** @var \App\Models\User */
        $user = $event->order->owner;

        $user->notify(new OrderPaymentFailedNotification($event->order));

        // Inform admins.
        $admins = User::where('role', Role::ADMIN->value)
                        ->get();

        foreach($admins as $admin)
        {
            $admin->notify(new AdminErrorNotification('Order payment failed for user '.$user->firstname.' '.$user->lastname).'. (Order '.$event->order->id.')');
        }
    }
 
    /**
     * Handle OrderPaymentPaid events.
     * 
     * The payment for an order was successful.
     */
    public function handleOrderPaymentPaid(OrderPaymentPaid $event): void
    {
        Log::info('OrderPaymentPaid order: '.$event->order->id);
    }

    /**
     * Handle OrderProcessed events.
     * 
     * The order has been fully processed.
     */
    public function handleOrderProcessed(OrderProcessed $event): void
    {
        Log::info('OrderProcessed order: '.$event->order->id);
    }

    /**
     * Handle SubscriptionStarted events.
     * 
     * A new subscription was started.
     */
    public function handleSubscriptionStarted(SubscriptionStarted $event): void
    {
        $subscription = $event->subscription;

        Log::info('SubscriptionStarted subscription: '.$subscription->id);

        /** @var \App\Models\User */
        $user = $subscription->owner;

        $plan = __($subscription->plan);

        if(!$user->hasVerifiedEmail())
        {
            Log::debug('Mark subscriber email verified');

            $user->markEmailAsVerified();

            event(new Verified($user));
        }

        if(!$user->active)
        {
            $user->update([
                'active' => true
            ]);

            // For a new user send a mail with info and set password link.
            $user->notify(new SubscriptionWelcomeUserNotification($plan));
        }
        else
        {
            if($user->role === Role::PARTICPANT->value)
            {
                $user->update([
                    'role' => Role::BOTH->value
                ]);
            }

            // For an existing user send a mail with info.
            $user->notify(new SubscriptionNotification($plan));
        }

        Log::debug("User notified");

        // Inform admins.
        $admins = User::where('role', Role::ADMIN->value)
                        ->get();

        foreach($admins as $admin)
        {
            $admin->notify(new NewSubscriberNotification($user, $plan));
        }

        Log::debug("Admins notified");
    }

    /**
     * Handle SubscriptionCancelled events.
     * 
     * The subscription was cancelled.
     */
    public function handleSubscriptionCancelled(SubscriptionCancelled $event): void
    {
        Log::info('SubscriptionCancelled subscription: '.$event->subscription);
        Log::info('SubscriptionCancelled for reason: '.$event->reason);
    }

    /**
     * Handle SubscriptionResumed events.
     * 
     * The subscription was resumed.
     */
    public function handleSubscriptionResumed(SubscriptionResumed $event): void
    {
        Log::info('SubscriptionResumed subscription: '.$event->subscription->id);
    }

    /**
     * Handle SubscriptionPlanSwapped events.
     * 
     * The subscription plan was swapped.
     */
    public function handleSubscriptionPlanSwapped(SubscriptionPlanSwapped $event): void
    {
        Log::info('SubscriptionPlanSwapped');
        Log::info('Subscription '.$event->subscription);
        Log::info('PreviousPlan '.$event->previousPlan);
    }

    /**
     * Handle SubscriptionQuantityUpdated events.
     * 
     * The subscription quantity was updated.
     */
    public function handleSubscriptionQuantityUpdated(SubscriptionQuantityUpdated $event): void
    {
        Log::info('SubscriptionQuantityUpdated');
        Log::info('Subscription '.$event->subscription);
        Log::info('OldQuantity '.$event->oldQuantity);
    }

    /**
     * Handle ChargebackReceived events.
     * 
     * Chargeback was received.
     */
    public function handleChargebackReceived(ChargebackReceived $event): void
    {
        Log::info('ChargebackReceived');
        Log::info('Payment '.$event->payment->id);
        Log::info('AmountChargedBack '.$event->amountChargedBack);
    }

    /**
     * Handle RefundInitiated events.
     * 
     * A refund was initiated.
     */
    public function handleRefundInitiated(RefundInitiated $event): void
    {
        Log::info('RefundInitiated');
        Log::info('Refund '.$event->refund->id);
    }

    /**
     * Handle RefundProcessed events.
     * 
     * The refund was processed.
     */
    public function handleRefundProcessed(RefundProcessed $event): void
    {
        Log::info('RefundProcessed');
        Log::info('Refund '.$event->refund->id);
    }
    /**
     * Handle RefundFailed events.
     * 
     * The refund has failed.
     */
    public function handleRefundFailed(RefundFailed $event): void
    {
        Log::info('RefundFailed');
        Log::info('Refund '.$event->refund->id);
    }

    /**
     * Register the listeners for the subscriber.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            BalanceTurnedStale::class,
            [CashierEventSubscriber::class, 'handleBalanceTurnedStale']
        );

        $events->listen(
            CouponApplied::class,
            [CashierEventSubscriber::class, 'handleCouponApplied']
        );
    
        $events->listen(
            FirstPaymentFailed::class,
            [CashierEventSubscriber::class, 'handleFirstPaymentFailed']
        );
    
        $events->listen(
            FirstPaymentPaid::class,
            [CashierEventSubscriber::class, 'handleFirstPaymentPaid']
        );
    
        $events->listen(
            MandateClearedFromBillable::class,
            [CashierEventSubscriber::class, 'handleMandateClearedFromBillable']
        );
    
        $events->listen(
            MandateUpdated::class,
            [CashierEventSubscriber::class, 'handleMandateUpdated']
        );
    
        $events->listen(
            OrderCreated::class,
            [CashierEventSubscriber::class, 'handleOrderCreated']
        );
    
        $events->listen(
            OrderInvoiceAvailable::class,
            [CashierEventSubscriber::class, 'handleOrderInvoiceAvailable']
        );
    
        $events->listen(
            OrderPaymentFailed::class,
            [CashierEventSubscriber::class, 'handleOrderPaymentFailed']
        );
    
        $events->listen(
            OrderPaymentFailedDueToInvalidMandate::class,
            [CashierEventSubscriber::class, 'handleOrderPaymentFailedDueToInvalidMandate']
        );
    
        $events->listen(
            OrderPaymentPaid::class,
            [CashierEventSubscriber::class, 'handleOrderPaymentPaid']
        );
    
        $events->listen(
            OrderProcessed::class,
            [CashierEventSubscriber::class, 'handleOrderProcessed']
        );
    
        $events->listen(
            SubscriptionStarted::class,
            [CashierEventSubscriber::class, 'handleSubscriptionStarted']
        );
    
        $events->listen(
            SubscriptionCancelled::class,
            [CashierEventSubscriber::class, 'handleSubscriptionCancelled']
        );
    
        $events->listen(
            SubscriptionResumed::class,
            [CashierEventSubscriber::class, 'handleSubscriptionResumed']
        );
        
        $events->listen(
            SubscriptionPlanSwapped::class,
            [CashierEventSubscriber::class, 'handleSubscriptionPlanSwapped']
        );
         
        $events->listen(
            SubscriptionQuantityUpdated::class,
            [CashierEventSubscriber::class, 'handleSubscriptionQuantityUpdated']
        );
        
        $events->listen(
            ChargebackReceived::class,
            [CashierEventSubscriber::class, 'handleChargebackReceived']
        );
        
        $events->listen(
            RefundInitiated::class,
            [CashierEventSubscriber::class, 'handleRefundInitiated']
        );
        
        $events->listen(
            RefundProcessed::class,
            [CashierEventSubscriber::class, 'handleRefundProcessed']
        );
         
        $events->listen(
            RefundFailed::class,
            [CashierEventSubscriber::class, 'handleRefundFailed']
        );
    }
}