<x-guest.layout>

    <h1>{{ __('Verifieer e-mail') }}</h1>

    <section>
        <p>{{ __('Klik op de link in de e-mail die u heeft gekregen om uw e-mailadres te verifiëren.') }}</p>

        <button>
            <a href="/email/verification-notification" onclick="event.preventDefault(); document.getElementById('verify-email-form').submit();">
                {{ __('Stuur nieuwe link') }}
            </a>
        </button>

        <form id="verify-email-form" action="/email/verification-notification" method="POST">
            @csrf
        </form>

        <x-logout-menu-item/>
        <x-logout-form/>
        
        @if (session('status') == 'verification-link-sent')
            <div class="message">
                Er is een e-mail met verificatielink naar je gestuurd!
            </div>
        @endif

    </section>

</x-guest.layout>