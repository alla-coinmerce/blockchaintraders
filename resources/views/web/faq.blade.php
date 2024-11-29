<x-web.layout id="faqpage">

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund") }}">
        <meta name="description" content="{{  __("AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.") }}">
    @endpush

    <x-slot:title>
        {{ __("The leading crypto investment fund | BlockchainTraders") }}
    </x-slot>
    
    <x-slot:heading>
        <h1>FAQ</h1>
    </x-slot>

    <section id="faqs">
        <div id="faq_1" class="faq">
            <button onclick="toggleFaqAnswer('#faq_1')"><span class="question">{{ __("What are cryptocurrencies?") }}</span><i class="fa-solid fa-chevron-down fa-fw"></i></button>
            <p class="answer">{{ __("Cryptocurrencies are digital forms of value that are supported by a network of computers. All transactions within the network are stored in a ledger, also known as the blockchain. With the advent of blockchain technology, it is possible to transfer value without the intervention of a trusted third party such as a bank. It is often thought that cryptocurrencies are only digital forms of money, while nowadays, due to the rise of smart contracts, there are many more applications for cryptocurrencies. Cryptocurrencies can represent multiple forms of property such as shares, savings points or even your vote in elections. The latest popular development within cryptocurrencies is Decentralized Finance (DeFi). DeFi makes it possible to use the blockchain to convert traditional financial products into trust-free and transparent protocols which work without intermediaries. This makes it possible, for example, to conclude financing reliably and transparently without the need for a bank.") }}</p>
        </div>
        <div id="faq_9" class="faq">
            <button onclick="toggleFaqAnswer('#faq_9')"><span class="question">{{ __("Why include cryptocurrencies in your investment portfolio?") }}</span><i class="fa-solid fa-chevron-down fa-fw"></i></button>
            <p class="answer">{{ __("The market for cryptocurrencies is still young and it has large potential. Therefore, the cryptocurrencies asset class has a high return potential. Over the past few years, the BlockchainTraders Growth Fund has delivered a return that is significantly higher than that of traditional asset classes, such as stocks and bonds. In addition, there is as yet no demonstrated correlation between traditional asset classes and cryptocurrencies, so cryptocurrencies have the potential to move in the opposite direction to declining traditional assets.") }}</p>
            <p class="answer">{{ __("Inclusion of cryptocurrencies in a traditional portfolio through an investment in a BlockchainTraders fund has the added value that it can significantly increase the return of the total portfolio and decrease the reliance on traditional assets.") }}</p>
        </div>
        <div id="faq_2" class="faq">
            <button onclick="toggleFaqAnswer('#faq_2')"><span class="question">{{ __("How is BlockchainTraders regulated?") }}</span><i class="fa-solid fa-chevron-down fa-fw"></i></button>
            <p class="answer">{{ __("BlockchainTraders is registered with the Dutch FinancialMarkets Authority (AFM). In addition, BlockchainTraders ensures that it adheres to laws and regulations by maintaining a sound compliance policy based on the Dutch Financial Supervision Act (wft) and the Dutch Money Laundering and Terrorist Financing (Prevention) Act (wwft).") }}</p>
        </div>
        <div id="faq_3" class="faq">
            <button onclick="toggleFaqAnswer('#faq_3')"><span class="question">{{ __("What are the risks of investing in cryptocurrencies?") }}</span><i class="fa-solid fa-chevron-down fa-fw"></i></button>
            <p class="answer">{!! __("The cryptocurrency market is still relatively new and a lot smaller than traditional markets such as the stock market, which means that the cryptocurrency market is very volatile. This volatility enables high returns to be achieved but also increases the risk of loss compared to traditional markets. Please refer to our fund documentation, which can be downloaded on the :growth_fund & the :liquidity_fund page to find out more about the risks.", [
                'growth_fund' => '<a href="'.route('growth-fund').'">BlockchainTraders Growth Fund</a>',
                'liquidity_fund' => '<a href="'.route('liquidity-fund').'">BlockchainTraders Liquidity Fund</a>'
            ]) !!}</p>
        </div>
        <div id="faq_4" class="faq">
            <button onclick="toggleFaqAnswer('#faq_4')"><span class="question">{{ __("Why is it interesting to invest in cryptocurrencies through BlockchainTraders?") }}</span><i class="fa-solid fa-chevron-down fa-fw"></i></button>
            <p class="answer">{{ __("The team behind BlockchainTraders is experienced and has a proven track record in cryptocurrency investments. Due to BlockchainTraders' experience in the market, they know how to reduce the risks for you, allowing you to quickly anticipate developments in the rapidly growing cryptocurrency market without needing technical know-how.") }}</p>
        </div>
        <div id="faq_5" class="faq">
            <button onclick="toggleFaqAnswer('#faq_5')"><span class="question">{{ __("What fees does BlockchainTraders charge for its services?") }}</span><i class="fa-solid fa-chevron-down fa-fw"></i></button>
            <p class="answer">{!! __("The costs of our funds can be found on the information pages: :growth_fund :liquidity_fund", [
                'growth_fund' => '<br><a href="'.route('growth-fund').'">BlockchainTraders Growth Fund</a>',
                'liquidity_fund' => '<br><a href="'.route('liquidity-fund').'">BlockchainTraders Liquidity Fund</a>'
            ]) !!}</p>
        </div>
        <div id="faq_6" class="faq">
            <button onclick="toggleFaqAnswer('#faq_6')"><span class="question">{{ __("How can I see the value of my investments?") }}</span><i class="fa-solid fa-chevron-down fa-fw"></i></button>
            <p class="answer">{{ __("Every two weeks you will receive an extensive factsheet detailing the value of your investment and your investment returns. In addition, you can also view the value of your participations in BlockchainTraders' online portal and app.") }}</p>
        </div>
        <div id="faq_7" class="faq">
            <button onclick="toggleFaqAnswer('#faq_7')"><span class="question">{{ __("How can I schedule an appointment with BlockchainTraders?") }}</span><i class="fa-solid fa-chevron-down fa-fw"></i></button>
            <p class="answer">{!! __("You can immediately schedule an appointment with us via the Calendly button at the bottom right. You can also contact us via the <a onclick=\"open_modal('contact')\">contact form</a>.") !!}</p>
        </div>
        <div id="faq_8" class="faq">
            <button onclick="toggleFaqAnswer('#faq_8')"><span class="question">{{ __("How can I invest with BlockchainTraders?") }}</span><i class="fa-solid fa-chevron-down fa-fw"></i></button>
            <p class="answer">{!! __("You can indicate that you are interested in investing through BlockchainTraders by entering your details <a onclick=\"open_modal('invest')\">here</a>. We will then contact you as soon as possible.") !!}</p>
        </div>
    </section>

</x-web.layout>