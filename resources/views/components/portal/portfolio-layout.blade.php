<x-portal.layout {{ $attributes }} :environment="$environment">
    @push('meta')
        <meta name="description" content="Beheer uw crypto portefeuille."> 
    @endpush

    @push('scripts')
        <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
    @endpush

    <x-slot:menu>
        <a onclick="open_modal('contact')">Contact</a>
        <a href="{{ route('my-account') }}">Mijn account</a>
        <x-logout-menu-item/>
    </x-slot>

    <x-slot:mobileMenu>
        <div id="mobile_menu_group">
            <a onclick="open_modal('contact')">Contact</a>
            <a href="{{ route('my-account') }}">Mijn account</a>
            <x-logout-menu-item/>
        </div>

        <button id="mobile_menu_button" onclick="open_modal('bijstorten')">Bijstorten</button>
    </x-slot>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <x-portal.footer-details/>

        <x-portal.footer-logo/>
    </footer>

    <x-modal id="bijstorten">
        <livewire:portal.deposit-form modal_id="bijstorten" :name="$firstname" :email="$email" />
    </x-modal>

    <x-modal id="contact">
        <livewire:portal.contact-form modal_id="contact" :name="$firstname" :email="$email" />
    </x-modal>
</x-portal.layout>