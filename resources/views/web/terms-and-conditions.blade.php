<x-web.layout id="termspage">

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund") }}">
        <meta name="description" content="{{  __("AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.") }}">
    @endpush

    <x-slot:title>
        {{ __("The leading crypto investment fund | BlockchainTraders") }}
    </x-slot>

    <x-slot:heading>
        <h1>{{  __("Terms and conditions") }}</h1>
    </x-slot>
    
    <section>
        <h2>{{ __("Consent") }}</h2>

        <p>{{  __("Prior to accessing the website of BlockchainTraders B.V., please carefully read the following legal notice and terms of use (\"Terms of Use\"). By visiting the website, you confirm that you have read and understood the Terms of Use, and that you agree to all the terms and conditions included herein. If you do not understand or agree to the terms in the Terms of Use, we advise you not to proceed or enter into any agreement with BlockchainTraders B.V.") }}</p>
       
        <h2>{{ __("Limited Access") }}</h2>

        <p>{{  __("Please note that the website of BlockchainTraders B.V. may not be accessed by persons subject to a jurisdiction where the publication of the website's content or access thereto is prohibited for any reason (e.g., due to nationality or place of residence). Such persons are not authorized to access this website.") }}</p>

        <h2>{{ __("No Warranty ") }}</h2>

        <p>{{  __("BlockchainTraders B.V. has taken great care in compiling the information on this website. The information on this website is continuously updated and checked for accuracy. However, neither BlockchainTraders B.V. nor its contractual partners make any representation or warranty (explicit or implicit) that the information published on the website of BlockchainTraders B.V. is accurate, reliable, up-to-date, or complete. In particular, BlockchainTraders B.V. has no obligation to update or remove outdated information or opinions from this website or to designate them as outdated. The information and opinions on this website may be changed at any time without notice.") }}</p>

        <p>{{  __("Furthermore, no warranty is given that this website will function without errors or interruptions, that any errors will be corrected, or that this website and servers from which information is accessible will be free from viruses, trojan horses, worms, software bombs, or other harmful components and programs, and BlockchainTraders B.V. accepts no liability for this.") }}</p>

        <h2>{{ __("Risk Disclosure") }}</h2>

        <p>{{  __("Investing in cryptocurrencies is inherently risky and may result in total loss of the invested amount. Cryptocurrencies are highly volatile and can fluctuate significantly in a short period of time. If you are not familiar with the risks involved, we kindly request that you leave this website. By continuing to use this website, you confirm that you understand the risks and are capable of taking them.") }}</p>

        <h2>{{ __("No Liability") }}</h2>

        <p>{{  __("The information provided on this website by BlockchainTraders B.V. may not be current, accurate, or complete, and the company accepts no liability for it. Any direct or indirect damage, including loss of profits, resulting from the use of this website or its information is not the responsibility of BlockchainTraders B.V. Liability for consequential damage and loss of profits are excluded.") }}</p>

        <h2>{{ __("No Offer") }}</h2>

        <p>{{  __("The information and opinions published on this website are provided for informational purposes only and should not be construed as any form of promotion, recommendation, encouragement, offer, or solicitation to (i) buy or sell cryptocurrencies, (ii) engage in any other business activities, or (iii) enter into any other legal transactions. The described services may not be suitable for you, or may not be available in your jurisdiction.") }}</p>

        <h2>{{ __("No Advice") }}</h2>

        <p>{{  __("The information and opinions published on this website do not constitute investment advice, and are not intended to provide legal, tax, financial, or any other advice or to be relied upon as such. Such information and opinions should not be used as a basis for decision-making. We strongly recommend that you consult with an expert in the relevant field before deciding to take any specific action. No information on or access to the website of BlockchainTraders B.V. should be construed as a contractual relationship between the providers of such information and the users of the website.") }}</p>

        <h2>{{ __("Intellectual Property, Copyright, and Trademark Rights:") }}</h2>

        <p>{{  __("All components of the BlockchainTraders B.V. website are protected by intellectual property rights and are the property of BlockchainTraders B.V. or third parties. Users may not acquire any rights to software, trademarks, or components of the website by downloading or printing material from this website. Copyright notices and trademarks may not be changed or removed. Components of this website may not be reproduced in any manner or form (including electronic or printed form) without the prior written permission of BlockchainTraders B.V. and full attribution. Users are not permitted to create hyperlinks or text links from other websites to the website of BlockchainTraders B.V. without the prior written permission of BlockchainTraders B.V.") }}</p>

        <h2>{{ __("Possible Conflicts of Interest:") }}</h2>

        <p>{{  __("BlockchainTraders B.V., its directors, or employees may have invested, currently invest, or may invest in the future in cryptocurrencies about which information or opinions are provided on the website of BlockchainTraders B.V. It is also possible that BlockchainTraders B.V. has previously provided, currently provides, or will provide services to the issuers of such cryptocurrencies. Furthermore, it is possible that employees or directors of BlockchainTraders B.V. have previously performed, currently perform, or will perform certain functions on behalf of the issuers of such cryptocurrencies.") }}</p>

        <p>{{  __("Blockchain Traders B.V. reserves the right to change the Terms of Use from time to time. To ensure that you agree to the terms of any modified version, you should read the Terms of Use simultaneously when using the BlockchainTraders B.V. website. If you do not understand or agree to the terms of the present Terms of Use, you should not visit BlockchainTraders B.V.'s website.") }}</p>

        <h2>{{ __("Applicable Law and Venue:") }}</h2>

        <p>{{  __("Access to and use of the website and the Terms of Use are governed by and interpreted in accordance with Dutch law, with Apeldoorn as the venue.") }}</p>

        <h2>{{ __("Privacy Policy:") }}</h2>

        <p>{!!  __("Please read our <a href=\":privacyPageUrl\">Privacy Policy</a>, which explains how personal information you provide to us is used.", ['privacyPageUrl' => route('privacy')]) !!}</p>
    </section>

</x-web.layout>