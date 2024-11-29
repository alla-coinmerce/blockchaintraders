<x-web.layout id="whatisabitcoinfund">

    @push('meta')
        <meta name="keywords" content="{{  __("cryptocurrency, fund, safety, blockchain, cyber security, Fireblocks, compliance, AFM, storage, regulation") }}">
        <meta name="description" content="{{  __("Discover what a Bitcoin fund entails and gain clear insights into its operation and benefits in one informative source.") }}">
    @endpush

    <x-slot:title>
    {{ __("What is a Bitcoin fund? All the information to get started [+VIDEO]") }}
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.js"></script>
    @endpush


    
    <x-slot:heading>
        <h1>{{ __("What is a Bitcoin fund?") }}</h1>
    </x-slot>

    <section id="investing_intro">

          <div class="block">
            <p class="subtitle">{{ __() }}</p>

            <p>{{ __("A crypto investment fund is a managed fund that invests in various cryptocurrencies and digital assets on behalf of its investors. The aim of these funds is to maximize the potential returns of crypto investments while managing risks. If you choose to participate in a crypto investment fund, you will benefit from the expertise and experience of our team. Our professionals closely monitor the crypto markets and continuously analyze the potential investment opportunities. They take the complexity and technical aspects of crypto investments off your hands, so you can focus on other important things in your life.") }}</p>
        
            <button onclick="openBrochureRequestModal()" class="link">Download Brochure <i class="fa fa-arrow-down fa-fw"></i></button>

        </div>

        <div class="iphone-frame">
            <iframe src="https://player.vimeo.com/video/869075776" width="250px" height="445px"  frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
          </div>

    </section>

    <section id="our_safety_measures">
        <h2>{{ __("What are the benefits of a Bitcoin Fund?") }}</h2>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_diversificatie.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Diversify your portfolio") }}</h3>
                <p>{{ __("By investing in a crypto fund, you usually invest not only in Bitcoin but also in other cryptocurrencies. This spreads the risk and increases the chance of positive returns.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_toegang.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Access to professional strategies") }}</h3>
                <p>{{ __("By investing in a crypto fund you can gain access to advanced investment techniques and strategies that are normally only available to large institutional investors.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_veiligeopslag.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Secure storage of Bitcoin") }}</h3>
                <p>{{ __("By investing with a crypto fund such as BlockchainTraders, you can be assured that all Bitcoin and other cryptocurrencies in the portfolio are stored as securely as possible. See also our page:") }} <a href="https://blockchaintraders.nl/veiligheid">{{ __("Safety") }}</a>.</p>
            </div>
        </div>

    </section>

    <section id="invest_future_oriented">
        <div class="block">
            <h2>{{ __("INVEST IN A FUTURE-ORIENTED WAY") }}</h2>

            <p class="subtitle">{{ __("Reduce dependence on traditional assets and increase your returns") }}</p>

            <p>{{ __("Add an investment with BlockchainTraders to your traditional investment portfolio with stocks and bonds. This has the added value that it can significantly increase the return of the total portfolio and reduce dependence on traditional assets.") }}</p>
        </div>

        <div class="animation">
            <dotlottie-player
                id="fifthLottie" 
                class="lottie_animation" 
                src="/assets/animations/invest_future_oriented_1.json" 
                background="transparent" 
                speed="1" 
                >
            </lottie-player>
        </div>
    </section>

    <section id="our_safety_measures">
        <h2>{{ __("Bitcoin Fund variants") }}</h2>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_eenmanszaak.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Actively managed funds") }}</h3>
                <p>{{ __("These funds are managed by a team of experts who actively make decisions about which cryptocurrencies and digital assets to buy and sell. They aim to generate returns through trading strategies, market analysis and research. Actively managed funds can follow different strategies, such as arbitrage, market timing or portfolio diversification. Our BlockchainTraders Growth Fund is an example of a fund that is actively managed.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_passive.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Passive index funds") }}</h3>
                <p>{{ __("This type of fund follows a passive investment strategy and aims to match the returns of a specific benchmark index. These funds invest in a wide range of cryptocurrencies that make up the selected index, and attempt to mimic the performance of the market rather than actively trading.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_sector.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Sector or theme funds") }}</h3>
                <p>{{ __("These funds focus on specific sectors or themes within the crypto industry. For example, they can invest in DeFi (Decentralized Finance), NFTs (Non-Fungible Tokens), Privacycoins or other emerging trends and technologies within the crypto world. By focusing on a particular sector or theme, these funds aim to capitalize on the growth potential and opportunities within that specific area.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_hedge.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Cryptocurrency hedge funds") }}</h3>
                <p>{{ __("Hedge funds often have a more flexible investment strategy and can use complex trading strategies such as short selling, derivatives trading and leverage. They aim for positive returns even in down markets by using various investment strategies and risk management techniques. Our BlockchainTraders Liquidity Fund is an example of a cryptocurrency hedge fund.") }}</p>
            </div>
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
    
            
                <!-- Calendly link widget begin -->
                <a href="" class="button button_blue" onclick="Calendly.initPopupWidget({url: 'https://calendly.com/justin-blockchaintraders'});return false;">{!!  __("Start now") !!}</a>
                <!-- Calendly link widget end -->
            
            
        </section>

    <x-web.download-brochure />


</x-web.layout>