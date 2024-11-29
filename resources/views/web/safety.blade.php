<x-web.layout id="safetypage">

    @push('meta')
        <meta name="keywords" content="{{  __("cryptocurrency, fund, safety, blockchain, cyber security, Fireblocks, compliance, AFM, storage, regulation") }}">
        <meta name="description" content="{{  __("Thanks to the security measures of BlockchainTraders, you invest in crypto as safely as possible, and your investments comply with all laws and regulations.") }}">
    @endpush

    <x-slot:title>
        {{  __("Safety | BlockchainTraders") }}
    </x-slot>
    
    <x-slot:heading>
        <h1>{{ __("Safety") }}</h1>
    </x-slot>

    <section id="safety_intro">
        <div class="block">
            <p>{{ __("The market for cryptocurrencies is developing at lightning speed, with new innovations following in rapid succession. This strong growth offers investors interesting investment opportunities, but it also creates challenges and risks. Due to the digital and programmable nature of blockchain technologies, there are risks of cyber attacks and hacks.") }}</p>

            <p>{{ __("Thanks to the security measures of BlockchainTraders, you invest in crypto as safely as possible, and your investments always comply with all regular laws and regulations.") }}</p>
        </div>

        <div class="block image_block">
            <img alt="BlockchainTraders Fireblocks logo" src="/assets/images/safety/blockchaintraders_fireblocks_hr.jpg" width="360" height="280">
        </div>
    </section>

    <section id="our_safety_measures">
        <h2>{{ __("Our security measures") }}</h2>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_storage.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Storage/security of cryptocurrencies") }}</h3>
                <p>{{ __("For the security of the crypto assets, BlockchainTraders uses the most advanced Cyber Security technology available. The technology used is the Multi-Party Computation (MPC) structure of Fireblocks. Similar to a multi-signature (multi-sig) configuration, a private key within an MPC-based solution is never created or stored in a single place. MPC technology protects the key(s) against theft by cybercriminals as well as internal fraud preventing employee(s) from stealing cryptocurrency. Thanks to the collaboration with Fireblocks, you can safely invest in crypto with BlockchainTraders.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_checkmark.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Compliance") }}</h3>
                <p>{{ __("BlockchainTraders is registered with the Netherlands Authority for the Financial Markets (AFM). In addition, BlockchainTraders ensures that it adheres to laws and regulations by conducting a thorough compliance policy based on the Dutch Financial Supervision Act (WFT) and the Money Laundering and Terrorist Financing Prevention Act (WWFT). BlockchainTraders uses software from ComplianceWise for her compliance activities. The Amsterdam-based accounting firm Endymion is the Internal Auditor of the compliance policy and as such carries out independent audits.") }}</p>
            </div>
        </div>

        <div class="safetyMeasure">
            <img class="icon" src="/assets/images/safety/icon_arrows.svg" alt="icon">
            <div class="content">
                <h3>{{ __("Separate funds") }}</h3>
                <p>{{ __("To ensure the availability and security of client funds, the balances of the BlockchainTraders funds are stored in Stichting Toezicht BlockchainTraders. As a result, the funds are not involved in day-to-day operational matters and are available for withdrawal by the participant. Thanks to this legal structure, participants' funds are protected.") }}</p>
                <p>{{ __("Jeroen Cremer, the independent director of Stichting Toezicht BlockchainTraders, supervises the management of the funds. The fund administration of the funds is also subject to an independent audit every quarter.") }}</p>
            </div>
        </div>
    </section>

    <x-web.get-to-know-more />

</x-web.layout>