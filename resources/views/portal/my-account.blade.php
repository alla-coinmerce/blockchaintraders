<x-portal.portfolio-layout  id="my-account-page" :firstname="$user->firstname" :email="$user->email">

    <h1>Mijn account</h1>

    <livewire:my-account.details :user="$user" />

    <livewire:my-account.password-update :user="$user" />

    <livewire:my-account.two-factor :user="$user" />

    <livewire:my-account.browser-sessions />

    <section>
        <h2>Kennisbank abonnement</h2>

        @if ($subscription)
            <p>
                Abonnement: {{ __($subscription->plan) }}
                @if ( $subscription->cancelled())
                    (beëindigd)
                @endif
            </p>

            @if ( !$subscription->cancelled())
                <p>Vernieuwd op: {{ $subscription->cycle_ends_at->format('d-m-Y') }}</p>
            @endif

            <a href="{{ route('subscription.updatePaymentMethod') }}">Update betaalmethode</a>
        @else
            <p>Geen abonnement</p>
        @endif

        @foreach($user->orders as $order)
            @if ($loop->first)
                <h3>Facturen</h3>
                <ul class="list-unstyled">
            @endif
                <li>
                    <a href="/download-invoice/{{ $order->id }}">
                        {{ $order->invoice()->id() }} -  {{ $order->invoice()->date() }}
                    </a>
                </li>
            @if ($loop->last)
                </ul>
            @endif
        @endforeach   
    </section>

</x-portal.portfolio-layout>