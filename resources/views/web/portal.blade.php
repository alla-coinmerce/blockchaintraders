<x-web.layout id="portalpage">

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund") }}">
        <meta name="description" content="{{  __("AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.") }}">
    @endpush

    <x-slot:title>
        {{ __("Portal | BlockchainTraders") }}
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.js"></script>
    @endpush


    <x-slot:heading>
        <h1>{{ __("BlockchainTraders Portal") }}</h1>
    </x-slot>

    <section id="about">
        <div class="block">
            <h2>{{ __("INFORMED INVESTING") }}</h2>

            <p class="subtitle">{{ __("Discover our portal through this video") }}</p>

            <p>{{ __("By investing with BlockchainTraders, you gain exclusive access to our user-friendly portal. It is designed to keep you closely connected with your investment's performance, ensuring you have the insights you need to watch your investments grow.") }}</p>
        
            <button onclick="open_modal('invest')" class="link">{{ __("Register") }} <i class="fa fa-arrow-down fa-fw"></i></button>

        </div>
       
        <div class="block">
            <iframe src="https://player.vimeo.com/video/911495730?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479" width="100%" height="400" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
        </div>

        
    </section>

    <section id="about">
    <div class="block image_block">
            <img alt="{{ __("BlockchainTraders Factsheet") }}" src="/assets/images/portaal_view.png" width="100%" height="240px">
        </div>
    
        <div class="block">
    
            <p class="subtitle">{{ __("Real Time Portfolio Insights") }}</p>
    
            <p>{{ __("Our portal provides instant access to the latest information on your investments, from current valuations to historical performance data. It's our commitment to offer you a transparent view of your investments, anytime and anywhere, so you can feel secure and informed at every step of your investment journey.") }}</p>
    
    
        </div>
    </section>

    <section id="about">
        <div class="block">

            <p class="subtitle">{{ __("Bi-Weekly Factsheets") }}</p>

            <p>{{ __("Every two weeks, we upload a curated factsheet directly in the portal, filled with essential data on the performance of the fund.") }}</p>
        </div>
  
        <div class="block image_block">
            <img alt="{{ __("BlockchainTraders Factsheet") }}" src="/assets/images/factsheet_view.png" width="85%" height="240px">
        </div>
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

    <x-web.get-to-know-more />

</x-web.layout>