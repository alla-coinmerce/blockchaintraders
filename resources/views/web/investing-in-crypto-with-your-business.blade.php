<x-web.layout id="investingincryptowithyourbusiness">

    @push('meta')
        <meta name="keywords" content="{{  __("cryptocurrency, fund, safety, blockchain, cyber security, Fireblocks, compliance, AFM, storage, regulation") }}">
        <meta name="description" content="{{  __("Explore the world of crypto business investing with comprehensive insights and strategies. Customized step-by-step explanation.") }}">
    @endpush

    <x-slot:title>
      {{  __("How does investing in crypto with your business work in 2023? Step-by-step explanation [+VIDEO]") }}
    </x-slot>

    @push('styles')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css"/>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
        <script src="https://unpkg.com/@dotlottie/player-component@latest/dist/dotlottie-player.js"></script>
    @endpush
    
    <x-slot:heading>
        <h1>{{ __("Investing in crypto with your business") }}</h1>
    </x-slot>

   <section id="investing_intro">
        
        <div class="block">
        <p class="subtitle">{{ __() }}</p>

        <p>{{ __("Many entrepreneurs have liquid equity in their company. It is possible for businesses to invest in cryptocurrencies such as Bitcoin or Ethereum or in a crypto investment fund such as BlockchainTraders. You can invest in crypto with various business forms, for example as an independent entrepreneur, such as a self-employed person or freelancer with a sole proprietorship of V.O.F. (Partnership Partnership), or with a BV (Private Company), CV (Limited Partnership) of NV (Public Limited Company) as shareholder and/or director.") }}</p>
        
        <button onclick="openBrochureRequestModal()" class="link">Download Brochure <i class="fa fa-arrow-down fa-fw"></i></button>

        </div> 


        <div class="iphone-frame">
            <iframe src="https://player.vimeo.com/video/868690132" width="250px" height="445px"  frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
        </div>

    </section>

    <section id="our_safety_measures">
        <h2>{{ __("Tax consequences of business investing in crypto") }}</h2>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_eenmanszaak.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Sole proprietorship or V.O.F.") }}</h3>
                <p>{{ __("When you invest with a sole proprietorship or V.O.F. you will have to pay tax in Box 3. Box 3 is the tax category where savings and investments are taxed. As the owner of a sole proprietorship, you are the legal entity within the company. This means that no distinction is made between private and business.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_vennootschap.svg" alt="icon">
            <div class="content">
                <h3>{{ __("A company (BV, NV or CV)") }}</h3>
                <p>{{ __("For a BV, NV and CV, corporate tax applies on the profit achieved. The corporate tax rate can vary depending on the amount of profit and other factors. If you decide to consider cryptocurrency as an investment used for business purposes, you may be able to apply depreciation. The rules for depreciation can be complex and may depend on factors such as the nature of the investment and its sustainability. When investing in cryptocurrency, you must assign a value to your assets for the company's annual accounts. Value can fluctuate, and it is important to use a consistent and reasonable valuation method. This may affect the company's annual results and tax liabilities.") }}</p>
            </div>
        </div>

    </section>

    <section id="added_value">
    <div class="block image_block">
            <img alt="{{ __("Justin and Michiel") }}" src="/assets/images/BlockchainTraders-25.jpg" width="100%" max-height="240px">
        </div>

        <div class="block">
            <p class="subtitle">{{ __("Business investing with BlockchainTraders") }}</p>

            <p>{{ __("Although private investing seems at first glance to be the most attractive with expected profits, investing through a private company (BV) is now also an interesting choice, because of the new regulation in which the RC ratio is limited to 700,000 euros. About 40% of the participants at BlockchainTraders invest commercially, mainly with a BV or a CV. At BlockchainTraders you do not buy cryptocurrencies directly, but you buy participations in an AFM registered investment fund with underlying investments in cryptocurrencies. This fund structuring means that you as a participant are assured that your investment is viewed as a business investment.") }}</p>
        
            <button onclick="openBrochureRequestModal()" class="link">Download Brochure <i class="fa fa-arrow-down fa-fw"></i></button>

        </div>
    </section>

    <section id="invest_future_oriented_business">
        <div class="block">
            <h2>{{ __("INVEST IN A FUTURE-ORIENTED WAY") }}</h2>

            <p class="subtitle">{{ __("Reduce dependence on traditional assets and increase your returns") }}</p>

            <p>{{ __("Add an investment with BlockchainTraders to your traditional investment portfolio with stocks and bonds. This has the added value that it can significantly increase the return of the total portfolio and reduce dependence on traditional assets.") }}</p>
        </div>

        <div class="block">
            <dotlottie-player
                id="thirdLottie" 
                class="lottie_animation" 
                src="/assets/animations/invest_future_oriented_1.json" 
                background="transparent" 
                speed="1" 
                >
            </dotlottie-player>
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