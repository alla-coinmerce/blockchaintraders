<x-layout {{ $attributes }} class="portal">
    @push('vite')
        @vite(['resources/js/portal.js'])
    @endpush

    <x-slot:title>
        {{ $title ?? 'Mijn BlockchainTraders' }}
    </x-slot>

    <header>
        <nav>
            <div id="header-nav-left">
                <a href="/"><img src="/assets/images/Logo.svg" alt="Logo BlockchainTraders" width="56" height="46"></a>

                <x-portal.menu-switch :environment="$environment" />
            </div>

            <div id="header-nav-right">
                <span id="dark_mode_switch">
                    <img src="/assets/images/NightMode.svg" alt="icon dark mode">
                    <span>Dark mode</span>
                </span>

                <span id="menu">
                    {{ $menu }}
                </span>

                <i id="hamburger" class="fa fa-bars fa-fw" onclick="open_modal('mobile_menu')"></i>

                <x-modal id="mobile_menu">
                    {{  $mobileMenu }}
                </x-modal>

                <x-logout-form/>
            </div>
        </nav>

        {{ $heading ?? '' }}
    </header>

    {{ $slot }}
    
</x-layout>