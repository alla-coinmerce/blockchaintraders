<x-web.layout id="whatiscryptoassetmanagement">

    @push('meta')
        <meta name="keywords" content="{{  __("cryptocurrency, fund, safety, blockchain, cyber security, Fireblocks, compliance, AFM, storage, regulation") }}">
        <meta name="description" content="{{  __("Learn everything about crypto asset management and discover what the benefits can be for you. Customized step-by-step explanation.") }}">
    @endpush

    <x-slot:title>
        {{  __("Crypto asset management | All information about managed investing") }}
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.js"></script>
    @endpush
    
    <x-slot:heading>
        <h1>{{ __("Crypto asset management") }}</h1>
    </x-slot>

   <section id="investing_intro">
     
    <div class="block">

        <p>{{ __("The cryptocurrency market is growing rapidly. More and more applications are emerging and the number of different cryptocurrencies and the applications of these cryptocurrencies are also increasing rapidly. The cryptocurrency market is becoming increasingly complex and it is therefore increasingly difficult and time-consuming to respond to opportunities in the market. This is why crypto asset management may be interesting for you. A professional crypto asset manager has the resources to minimize your risks and maximize your returns.") }}</p>
    
        <button onclick="openBrochureRequestModal()" class="link">Download Brochure <i class="fa fa-arrow-down fa-fw"></i></button>

    </div>

        <div class="iphone-frame">
            <iframe src="https://player.vimeo.com/video/869051201?" width="250px" height="445px"  frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
          </div>

        
    </section>

    <section id="our_safety_measures">
        <h2>{{ __("What are the benefits of crypto asset management?") }}</h2>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_diversificatie.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Diversification") }}</h3>
                <p>{{ __("One of the fundamental principles of asset management is diversification. By spreading your investments across different cryptocurrencies, you reduce the risk of big losses due to price volatility.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_checkmark.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Risk assessment") }}</h3>
                <p>{{ __("A professional crypto asset management company conducts comprehensive risk assessments to understand and manage your exposure to market fluctuations.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_portefeuille.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Portfolio optimization") }}</h3>
                <p>{{ __("Experts in crypto asset management can continuously optimize your portfolio to ensure you take advantage of the best opportunities in the market.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_beveiliging.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Security") }}</h3>
                <p>{{ __("Safely storing your crypto assets is of utmost importance. Crypto asset managers use state-of-the-art security measures and cold storage solutions to protect your assets from hackers and theft.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_rendement.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Return maximization") }}</h3>
                <p>{{ __("By actively trading and using strategies such as staking and yield farming, crypto asset managers can maximize your returns.") }}</p>
            </div>
        </div>

    </section>

    <section id="added_value">
        <div class="animation">
            <dotlottie-player
                id="forthLottie" 
                class="lottie_animation" 
                src="/assets/animations/invest_future_oriented_1.json" 
                background="transparent" 
                speed="1" 
                >
            </dotlottie-player>
        </div>
    
            <div class="block">
                <p class="subtitle">{{ __("Asset management at BlockchainTraders") }}</p>
    
                <p>{{ __("At BlockchainTraders you can invest in actively managed investment funds. We understand the unique challenges and opportunities of the crypto market and adapt our strategies accordingly. By adding an investment with BlockchainTraders to your traditional investment portfolio, you can significantly increase the return on the total portfolio and reduce dependence on traditional assets.") }}</p>
            
                <button onclick="openBrochureRequestModal()" class="link">Download Brochure <i class="fa fa-arrow-down fa-fw"></i></button>
    
            </div>
        </section>

        <section id="about">
        <div class="block">
            <p class="subtitle">{{ __("Why you should invest in crypto in a managed manner and not by yourself") }}</p>

            <p>{{ __("Managed investing in crypto is essential for those who want to invest in the fast-paced world of cryptocurrencies, but do not have the time to follow the market themselves. Managed investing reduces the complexity and risks compared to independent investing by building a portfolio in a diversified manner according to a fixed strategy, which reduces the risk of major losses. In addition, advanced security techniques from asset managers ensure the safest storage of your crypto.") }}</p>
        </div>
  
        <div class="block image_block">
            <img src="/assets/images/BlockchainTraders-25.jpg" alt="crypto vermogensbeheer" width="100%" max-height="240px">
        </div>
    </section>
        
        <section id="our_funds">
            <h2>{{ __("Our funds") }}</h2>
        
                <x-web.funds-shortlist />
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
    
        <x-web.download-brochure />
    
    
    </x-web.layout>