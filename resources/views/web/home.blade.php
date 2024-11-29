<x-web.layout id="homepage">

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund") }}">
        <meta name="description" content="{{  __("AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.") }}">
    @endpush

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.js"></script>
    @endpush

    <x-slot:title>
        {{ __("The leading crypto investment fund | BlockchainTraders") }}
    </x-slot>
    
    <x-slot:heading>
        <video playsinline autoplay muted loop>
            <source src="/assets/videos/header_bg.mp4" type="video/mp4">
        </video>

        <div class="video_overlay"></div>

        <section id="invest_with_blockchaintraders">
            <div class="inner">
                <div id="header_headline_block" class="block">
                    <h1 id="homepage_title">{!! __("Invest with <br>BlockchainTraders") !!}</h1>

                    <ul>
                        <li>{{ __("Annualized return of") }} 27%</li>
                        <li>{{ __("Active and profitable since 2018") }}</li>
                    </ul>

                    <div class="references">
                        <a id="ref_cashcow" class="reference" href="https://www.cashcowawards.nl/#winnaars" target="_blank" rel="noopener noreferrer">
                            <img alt="Logo CashCow Awards" src="/assets/images/cashcow_hr.png" width="33" height="33">
                            <div>
                                <h4>{{ __("Best Dutch Cryptofund") }}</h4>
                                <p>CashCow Awards 2022 & 2023</p>
                            </div>
                        </a>

                        <a id="ref_afm" class="reference" href="https://www.afm.nl/~/profmedia/files/registers/register-aifmd-light.xls?la=en" target="_blank" rel="noopener noreferrer">
                            <img alt="Logo {{ __("Authority of the Financial Markets (AFM)") }}" src="/assets/images/logo_afm_hr.png" width="33" height="33">
                            <div>
                                <h4>{{ __("Registered investment fund") }}</h4>
                                <p>{{ __("Authority of the Financial Markets (AFM)") }}</p>
                            </div>
                        </a>

                    </div>
                </div>

                <div class="block request_info_form_block">
                    <div id="request_info_form_top">
                        <h2>{{ __("Request information") }}</h2>

                        <livewire:web.contact-form-k-b :submitButtonText="__('Receive immediately')" formTag="Header contact form" />

                        <div class="privacy_declaration">
                            <img alt="Logo privacy" src="/assets/images/shield.svg">
                            <span class="privacy_declaration_text">
                                {{ __("We respect your") }}
                                <a href="{{ route('privacy') }}">
                                    privacy
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
        
                <div id="featured_images">
                    <a href="https://www.quotenet.nl/financien/cryptocurrency/a43600883/bij-blockchaintraders-belegt-u-rendabel-en-met-minimaal-risico/" target="_blank" rel="noopener noreferrer">
                        <img alt="Logo Quotenet" src="/assets/images/featured/quote_20230921.png">
                    </a>
                    <a href="https://www.deondernemer.nl/financien/blockchaintraders-cryptocurrency-investeringsfonds~3729081" target="_blank" rel="noopener noreferrer">
                        <img alt="Logo de ondernemer" src="/assets/images/featured/de_ondernemer_20230921.png">
                    </a>
                    <a href="https://vimeo.com/617905027?share=copy" target="_blank" rel="noopener noreferrer">
                        <img alt="Logo RLT Z" src="/assets/images/featured/rtlz_20230921.png">
                    </a>
                    <a href="https://www.destentor.nl/home/blockchain-in-jip-en-janneketaal-interessant-voor-investeerders~adaedd6c/" target="_blank" rel="noopener noreferrer">
                        <img alt="Logo de Stentor" src="/assets/images/featured/de_stentor_20230921.png">
                    </a>
                    <a class="hide_on_mobile" href="https://www.business-class.nl/uitzendingen/2022-2023/33/blockchain-traders" target="_blank" rel="noopener noreferrer">
                        <img alt="Logo Business Class" src="/assets/images/featured/business_class_20230921.png">
                    </a>
                </div>
            </div>
        </section>
    </x-slot>

    <section id="get_to_know_more_with_video">
        <div class="block">
            <h2>{{ __("INVEST FUTURE FOCUSSED") }}</h2>

            <p class="subtitle">{{ __("The added value of investing with BlockchainTraders") }}</p>

            <p>{{ __("At the beginning of June, Justin Kool sat down with Harry Mens on behalf of BlockchainTraders to discuss why the BlockchainTraders Growth Fund is a valuable addition to your investment portfolio.") }}</p>
        
            <button onclick="openBrochureRequestModal()" class="link">Download Brochure <i class="fa fa-arrow-down fa-fw"></i></button>

        </div>
       
        <div class="block">
            <iframe src="https://player.vimeo.com/video/953080936?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" width="100%" height="300" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
        </div>


        
        
    </section>

    <section id="our_funds">
        <h2>{{ __("Our funds") }}</h2>

        <x-web.funds-shortlist />
    </section>

    <section id="invest_future_oriented">
        <div class="animation">
            <dotlottie-player
                id="secondLottie" 
                class="lottie_animation" 
                src="/assets/animations/invest_future_oriented_1.json" 
                background="transparent" 
                speed="1" 
                >
            </lottie-player>
        </div>
    
        <div class="block">
            <h2>{{ __("INVEST IN A FUTURE-ORIENTED WAY") }}</h2>

            <p class="subtitle">{{ __("Reduce dependence on traditional assets and increase your returns") }}</p>

            <p>{{ __("Add an investment with BlockchainTraders to your traditional investment portfolio with stocks and bonds. This has the added value that it can significantly increase the return of the total portfolio and reduce dependence on traditional assets.") }}</p>
        </div>


    </section>

    <section id="about">
        <div class="block">
            <h2>{{ __("ABOUT US") }}</h2>

            <p class="subtitle">{{ __("Combined 20+ years of industry experience and a proven track record.") }}</p>

            <p>{{ __("BlockchainTraders was founded by Michiel van der Steeg and Justin Kool. Justin bought his first Bitcoin in 2014. In 2017, Justin and Michiel gained a lot of cryptocurrency experience. They outperformed the market by over 30% that year and established BlockchainTraders using their cryptocurrency proceeds.") }}</p>
        
            <a href="{{ route('about') }}">{{ __("Read more") }}<i class="fa fa-arrow-right fa-fw"></i></a>
        </div>
  
        <div class="block image_block">
            <img alt="{{ __("Justin and Michiel") }}" src="/assets/images/justin_and_michiel_highres.jpg" width="100%" max-height="240px">
        </div>
    </section>

    <section id="we_are_still_early">
        <div id="we_are_still_early_lottie" class="bct_lottie_container block">
            <dotlottie-player
                id="firstLottie" 
                class="lottie_animation" 
                src="/assets/animations/we_are_still_early.json"
                background="transparent" 
                speed="1" 
                >
            </lottie-player>
        </div>

        <div id="we_are_still_early_titles" class="block">
            <h2>{{ __("INVEST IN A FUTURE-ORIENTED WAY") }}</h2>

            <p class="subtitle">We are still early</p>
        </div>

        <p id="we_are_still_early_text" class="block">{{  __("The S-Curve analysis follows the adoption path of new technologies, divided into phases such as Innovators, Early Adopters, Early Majority, Late Majority and Laggards. This helps with investment decisions. Typically, adoption grows fastest in the Early and Late Majority phases. With 12 years of history, we believe Bitcoin is currently in the Early Majority stage, as assessed by global investors and total digital asset investments.") }}</p>
    </section>

    <section id="how_can_i_invest">
        <div class="block">
            <p class="subtitle">{{ __("How can I invest?") }}</p>
        </div>
        
        <div class="swiper block">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="/assets/images/how_can_i_invest/appointment.svg" alt="icon appointment" width="40" height="40">
                    <h3>1. {{ __("Appointment") }}</h3>
                    <p>{{ __("Schedule an appointment to get acquainted") }}</p>
                </div>

                <div class="swiper-slide">
                    <img src="/assets/images/how_can_i_invest/enroll.svg" alt="icon enroll" width="40" height="40">
                    <h3>2. {{ __("Enroll") }}</h3>
                    <p>{{ __("We will send you a digital registration form") }}</p>
                </div>

                <div class="swiper-slide">
                    <img src="/assets/images/how_can_i_invest/invoice.svg" alt="icon invoice" width="40" height="40">
                    <h3>3. {{ __("Invoice") }}</h3>
                    <p>{{ __("You will receive a participation invoice") }}</p>
                </div>

                <div class="swiper-slide">
                    <img src="/assets/images/how_can_i_invest/access.svg" alt="icon access" width="40" height="40">
                    <h3>4. {{ __("Access") }}</h3>
                    <p>{{ __("After payment you will get access to your dashboard") }}</p>
                </div>

                <div class="swiper-slide">
                    <img src="/assets/images/how_can_i_invest/efficiency.svg" alt="icon efficiency" width="40" height="40">
                    <h3>5. {{ __("Efficiency") }}</h3>
                    <p>{{ __("We will work to make your investment profitable") }}</p>
                </div>
            </div>
        </div>

        <div>
            <!-- Calendly link widget begin -->
            <a href="" class="button button_blue" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/justin-blockchaintraders'});return false;">{!!  __("Start now") !!}</a>
            <!-- Calendly link widget end -->
        </div>
        
    </section>

    <section id="get_to_know_more_with_video">
        <div class="rtlz">
            <iframe src="https://player.vimeo.com/video/617905027?h=65a81b3655" width="100%" height="300" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
        </div>
    
        <div class="block">
            <h2>{{ __("GET TO KNOW MORE") }}</h2>
    
            <p class="subtitle">{{ __("Optimal anticipation of trends and developments") }}</p>
    
            <p>{{ __("With a combination of blockchain expertise and actively managed cryptocurrency investment portfolios, BlockchainTraders now offers investors an opportunity to achieve high returns on these revolutionary technologies") }}</p>
    
            <button onclick="openBrochureRequestModal()" class="link">Download Brochure <i class="fa fa-arrow-down fa-fw"></i></button>
    
        </div>
    </section>

    <x-web.get-to-know-more />

</x-web.layout>