<x-portal.layout {{ $attributes }} environment="Kennisbank">
    @push('meta')
        <meta name="description" content="Beheer uw crypto portefeuille."> 
    @endpush

    <x-slot:heading>
        {{ $heading ?? '' }}
    </x-slot>

    <x-slot:menu>
        <a href="{{ route('kb.contact') }}">Contact</a>
        <a href="{{ route('my-account') }}">Mijn account</a>
        <x-logout-menu-item/>
    </x-slot>

    <x-slot:mobileMenu>
        <div id="mobile_menu_group">
            <a href="{{ route('kb.contact') }}">Contact</a>
            <a href="{{ route('my-account') }}">Mijn account</a>
            <x-logout-menu-item/>
        </div>
    </x-slot>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <x-portal.footer-logo-grey/>
    </footer>
</x-portal.layout>