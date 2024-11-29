@props([
    'darkMode' => true
])

<x-layout {{ $attributes }} @class([
    'website',
    'dark-mode' => $darkMode
])>

    @push('scripts')
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-126234361-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'UA-126234361-1');
        </script>

        <!-- Calendly link widget begin -->
        <link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
        <script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
        <!-- Calendly link widget end -->
    @endpush

    @push('vite')
        @vite(['resources/js/web.js'])
    @endpush

    <x-slot:title>
        {{ $title ?? 'BlockchainTraders' }}
    </x-slot>
    <x-sticky-banner />
    <header>
        <nav id="webheader">
        
            <div id="menubar">
                @if ($darkMode)
                    <a href="/"><img src="/assets/images/Logo_darkmode.svg" alt="Logo BlockchainTraders" width="56" height="46"></a>
                @else
                    <a href="/"><img src="/assets/images/Logo.svg" alt="Logo BlockchainTraders" width="56" height="46"></a>
                @endif

                <div id="menu">
                    <a href="{{ route('about') }}">{{ __("About us") }}</a>
                    <div class="dropdown">
                        <div class="dropdown_button"><a href="{{ route('funds') }}">{{  __("Funds") }} <i class="fa-solid fa-chevron-down fa-xs"></i></a></div>
                        <div class="dropdown_content">
                            <a href="{{ route('growth-fund') }}">Growth Fund</a>
                            <a href="{{ route('liquidity-fund') }}">Liquidity Fund</a>
                        </div>
                    </div>
                    <a href="{{ route('safety') }}">{{ __("Safety") }}</a>
                    <div class="dropdown">
                        <div class="dropdown_button"><a href="{{ route('faq') }}">{{  __("More") }} <i class="fa-solid fa-chevron-down fa-xs"></i></a></div>
                        <div class="dropdown_content">
                            <a href="{{ route('faq') }}">FAQ</a>
                            <a href="{{ route('blog') }}">Blog</a>
                            <a href="{{ route('portal') }}">{{ __("Portal") }}</a>
                        </div>
                    </div>
                    {{-- <a href="{{ route('knowledgebase.landing') }}">{{ __("Knowledge base") }}</a> --}}
                    <a onclick="open_modal('contact')">Contact</a>
                    <div class="languages">
                        @foreach($available_locales as $locale_name => $available_locale)
                            @if($available_locale !== $current_locale)
                                <a href="/language/{{ $available_locale }}"><img src="/assets/images/flags/{{ $available_locale }}.png" alt="{{ $locale_name }}" width="20"> {{ strtoupper($available_locale) }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div id="header-nav-right">
                    <div class="header_buttons">
                        <button id="menu_invest_button" onclick="open_modal('invest')">{{ __("Register") }}</button>

                        <a class="button alt" href="{{ route('login') }}">{{ __("Login") }}</a>
                    </div>

                    <i id="hamburger" class="fa fa-bars fa-fw" onclick="open_modal('mobile_menu')"></i>

                </div>
            </div>

            <x-modal id="mobile_menu">
                <div id="mobile_menu_group">
                    <a href="{{ route('about') }}">{{ __("About us") }}</a>
                    <a href="{{ route('funds') }}">{{  __("Funds") }}</a>
                    <a href="{{ route('safety') }}">{{ __("Safety") }}</a>
                    {{-- <a href="{{ route('knowledgebase.landing') }}">{{ __("Knowledge base") }}</a> --}}
                    <a href="{{ route('faq') }}">FAQ</a>
                    <a href="{{ route('blog') }}">Blog</a>
                    <a onclick="open_modal('contact')">Contact</a>
                    
                    @foreach($available_locales as $locale_name => $available_locale)
                        @if($available_locale !== $current_locale)
                            <a href="/language/{{ $available_locale }}">{{ $locale_name }}</a>
                        @endif
                    @endforeach
                </div>

                <div class="header_buttons">
                    <button onclick="open_modal('invest')">{{ __("Register") }}</button>

                    <a class="button alt" href="{{ route('login') }}">{{ __("Login") }}</a>
                </div>
            </x-modal>
        </nav>

        {{ $heading ?? '' }}
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer>
        <div class="inner">
            <div id="footer_details">
               
                <div id="directly_to">
                    <h3>{{  __("Directly to") }}</h3>
                    <p>       
                        <a href="{{ route('investing-in-crypto-with-your-business') }}">{{  __("Investing in crypto with your business >") }}</a><br>
                        <a href="{{ route('what-is-cryto-asset-management') }}">{{  __("Crypto asset management >") }}</a><br>
                        <a href="{{ route('what-is-a-bitcoin-fund') }}">{{  __("What is a Bitcoin fund? >") }}</a><br>
                    </p>
                </div>
            
                <div id="footer_fund_manager_details">
                    <h3>{{  __("Custodian Fund Assets") }}</h3>
                    <p>
                        Stichting Toezicht<br>
                        BlockchainTraders<br>
                        KVK: 71065547
                    </p>
                    
                    <h3>{{  __("Fund manager") }}</h3>
                    <p>
                        BlockchainTraders B.V.<br>
                        KVK: 70864640
                    </p>   
                </div>

                <div id="footer_address">
                    <div id="footer_address_branch_office_desktop">
                        <h3>{{  __("Office") }}</h3>
                        <p>
                            Groenmarktkade 12HB<br>
                            1016 TA Amsterdam
                        </p>
                    </div>
                </div>

                <div id="footer_phone">
                    <div id="footer_address_branch_office_mobile">
                        <h3>{{  __("Office") }}</h3>
                        <p>
                            Groenmarktkade 12HB<br>
                            1016 TA Amsterdam
                        </p>
                    </div>

                    <h3>{{  __("Phone number") }}</h3>
                    <p>
                        055-3020102
                    </p>

                    <h3>{{  __("E-mailadres") }}</h3>
                    <p>
                        info@blockchaintraders.nl
                    </p>
                </div>
            </div>

            <div id="footer_logo">
                <img src="/assets/images/LogoFooter.svg" alt="Logo BlockchainTraders" width="106" height="57">
            </div>

            <nav id="footer_menu">
                Copyright &copy; {{ now()->year }} BlockchainTraders B.V. | <a href="{{ route('privacy') }}">{{  __("Privacy policy") }}</a> | <a href="{{ route('terms_and_conditions') }}">{{  __("Terms and conditions") }}</a> | <a href="/assets/documents/SFDR_Disclosure_BCT_2024.pdf" target="_blank">{{  __("SFDR policy") }}</a>
            </nav>
        </div>
    </footer>

    <!-- Calendly link widget begin -->
    <script type="text/javascript">window.onload = function() { Calendly.initBadgeWidget({ url: 'https://calendly.com/justin-blockchaintraders', text: ' {!!  __("Schedule an appointment") !!}', color: '#2C82BE', textColor: '#ffffff', branding: false }); }</script>
    <!-- Calendly link widget end -->

    <x-modal id="contact">
        <livewire:web.contact-form-modal modal_id="contact" />
    </x-modal>

    <x-modal id="invest">
        <livewire:web.invest-form-modal modal_id="invest" />
    </x-modal>

    <x-modal id="information_request">
        <livewire:web.information-request-form modal_id="information_request" />
    </x-modal>

    <x-modal id="brochure_request">
        <livewire:web.brochure-request-form modal_id="brochure_request" />
    </x-modal>

</x-layout>