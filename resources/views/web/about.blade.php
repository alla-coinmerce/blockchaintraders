<x-web.layout id="aboutpage">

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, blockchain, cryptocurrency, Justin Kool, Michiel van der Steeg, Jeroen Cremer") }}">
        <meta name="description" content="{{  __("The founders of BlockchainTraders are highly regarded crypto specialists and they regularly speak at national and international blockchain events.") }}">
    @endpush

    <x-slot:title>
        {{  __("About us | BlockchainTraders") }}
    </x-slot>
    
    <x-slot:heading>
        <h1>{{ __("About us") }}</h1>
    </x-slot>

    <section id="about_intro">
        <div class="block">
            <p>{{ __("BlockchainTraders was founded by Michiel van der Steeg and Justin Kool. Justin bought his first Bitcoin in 2014. In 2017, Justin and Michiel gained a lot of cryptocurrency experience. They outperformed the market by over 30% that year and established BlockchainTraders using their cryptocurrency proceeds.") }}</p>

            <p>{{ __("Today, the founders of BlockchainTraders are highly regarded cryptocurrency specialists and regularly speak at national and international blockchain events.") }}</p>

            <p>{{ __("The team behind BlockchainTraders expects blockchain to have a greater impact on today's society than the internet has had to date.") }}</p>
        </div>

        <div class="block image_block">
            <img alt="{{ __("Justin and Michiel") }}" src="/assets/images/justin_and_michiel_highres.jpg" width="360px" height="240px">
        </div>
    </section>

    <section id="the_team">
        <h2>{{ __("The team") }}</h2>

        <div class="team_member">
            <img src="/assets/images/team/justin_kool.jpeg" alt="Justin Kool" width="200px" height="200px">
            <div class="team_member_details">
                <h3>Justin Kool</h3>
                <p>Founder & Portfolio Manager</p>
                <ul>
                    <li>{{ __("Experience: Portfolio Manager/Trader, Miner en Consultant in Cryptocurrencies") }}</li>
                    <li>{{ __("Education: Universidad Rey Juan Carlos, Hanzehogeschool Groningen") }}</li>
                    <li>Contact: 
                        <span style="white-space: nowrap;"><i class="fa-solid fa-mobile-screen"></i> <a href="tel:+31628255795">+31 6 28 25 57 95</a></span> | 
                        <span style="white-space: nowrap;"><i class="fa-regular fa-envelope"></i> <a href="mailto:j.kool@blockchaintraders.nl">j.kool@blockchaintraders.nl</a></span> | 
                        <span style="white-space: nowrap;"><a href="https://www.linkedin.com/in/justin-kool-1a2a3bb1/"><i class="fa-brands fa-linkedin-in"></i></a></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="team_member">
            <img src="/assets/images/team/michiel_van_der_steeg.jpg" alt="Michiel van der Steeg" width="200px" height="200px">
            <div class="team_member_details">
                <h3>Michiel van der Steeg</h3>
                <p>Founder & Co-Portfolio Manager</p>
                <ul>
                    <li>{{ __("Experience: Crypto Consultant, KnoWork (Price for bests Startup), ComplianceWise") }}</li>
                    <li>{{ __("Education: Universiteit Leiden/Utrecht, UvA, Rijksuniversiteit Groningen") }}</li>
                    <li>Contact: 
                        <span style="white-space: nowrap;"><i class="fa-solid fa-mobile-screen"></i> <a href="tel:+31621971738">+31 6 21 97 17 38</a></span> | 
                        <span style="white-space: nowrap;"><i class="fa-regular fa-envelope"></i> <a href="mailto:m.vandersteeg@blockchaintraders.nl">m.vandersteeg@blockchaintraders.nl</a></span> | 
                        <span style="white-space: nowrap;"><a href="https://www.linkedin.com/in/michiel-van-der-steeg-46b166a2/"><i class="fa-brands fa-linkedin-in"></i></a></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="team_member">
            <img src="/assets/images/team/jeroen_cremer.jpeg" alt="Jeroen Cremer" width="200px" height="200px">
            <div class="team_member_details">
                <h3>Jeroen Cremer</h3>
                <p>{{ __("Director of the BlockchainTraders Supervision Foundation") }}</p>
                <ul>
                    <li>{{ __("Experience: Commercial Director ComplianceWise, Director judicial owner") }}</li>
                    <li>{{ __("Education: Nijenrode Business University, Hogeschool van Utrecht") }}</li>
                    <li>Contact: 
                        <span style="white-space: nowrap;"><i class="fa-solid fa-mobile-screen"></i> <a href="tel:+31620117908">+31 6 20 11 79 08</a></span> | 
                        <span style="white-space: nowrap;"><i class="fa-regular fa-envelope"></i> <a href="mailto:j.cremer@blockchaintraders.nl">j.cremer@blockchaintraders.nl</a></span> | 
                        <span style="white-space: nowrap;"><a href="https://www.linkedin.com/in/jeroen-cremer-3a3a449/"><i class="fa-brands fa-linkedin-in"></i></a></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="team_member">
            <img src="/assets/images/team/michiel_van_eersel.jpeg" alt="Michiel van Eersel" width="200px" height="200px">
            <div class="team_member_details">
                <h3>Michiel van Eersel</h3>
                <p>{{ __("Legal Advisor") }}</p>
                <ul>
                    <li>{{ __("Experience: Lawyer specialized in alternative finance, impact investing, cryptocurrencies and smart contracts") }}</li>
                    <li>{{ __("Education") }}: Universiteit Utrecht</li>
                </ul>
            </div>
        </div>

        <div class="team_member">
            <img src="/assets/images/team/leon_lieffijn.jpg" alt="Leon Lieffijn" width="200px" height="200px">
            <div class="team_member_details">
                <h3>Leon Lieffijn</h3>
                <p>Product Designer</p>
                <ul>
                    <li>{{ __("Experience") }}: bol.com, Soda Studio, MessageBird</li>
                    <li>{{ __("Education") }}: Hogeschool van Amsterdam, Vrije Universiteit Amsterdam</li>
                </ul>
            </div>
        </div>
    </section>

    <section id="partners">
        <h2>Partners</h2>

        <div id="partners_images">
            <a href="https://verseput.nl/"><img alt="Logo Verseput" src="/assets/images/partners/Verseput.png"></a>
            <a href="https://www.fireblocks.com/"><img alt="Logo Fireblocks" src="/assets/images/partners/Fireblocks.png"></a>
            <a href="https://compliance-wise.com/"><img alt="Logo ComplianceWise" src="/assets/images/partners/ComplianceWise.png"></a>
            <a href="https://www.endymion.amsterdam/"><img alt="Logo Endymion" src="/assets/images/partners/Endymion.png"></a>
            <a href="https://birkway.com/"><img alt="Logo Birkway" src="/assets/images/partners/Birkway.png"></a>
        </div>
    </section>


</x-web.layout>