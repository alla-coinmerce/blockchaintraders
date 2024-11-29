<x-web.layout id="privacypage">

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund") }}">
        <meta name="description" content="{{  __("AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.") }}">
    @endpush

    <x-slot:title>
        {{ __("The leading crypto investment fund | BlockchainTraders") }}
    </x-slot>

    <x-slot:heading>
        <h1>Privacy</h1>
    </x-slot>
    
    <section>
        <p>{{ __("BlockchainTraders BV owns the BlockchainTraders.nl website and is responsible for processing personal data, as indicated in this statement. Through this, BlockchainTraders complies with the AVG (GDPR) in force as of 25 May 2018.") }}</p>

        <h2>{{ __("Contact details") }}</h2>

        <p>
            {{ __("Company name") }}: BlockchainTraders BV<br>
            <a href="https://blockchaintraders.nl/">https://blockchaintraders.nl/</a><br>
            Deventerstraat 101c, 7322 JM Apeldoorn<br>
            {{ __("Phone") }}: 055-302010<br>
            E-mail: info@blockchaintraders.nl<br>
            {{ __("CoC") }}: 70864640
        </p>

        <p>{{ __("Justin Kool is the data protection officer for BlockchainTraders. He can be reached at j.kool@blockchaintraders.nl.") }}</p>

        <h2>{{ __("Personal data that we process") }}</h2>

        <p>{{ __("We process your personal data because you employ our services and/or because you provide us with these data yourself. Below is an overview of the personal data we may process when you contact us, respond via a form on the website, or register for a master class:") }}</p>

        <ol>
            <li>{{ __("First and last name") }}</li>
            <li>{{ __("E-mail address") }}</li>
            <li>{{ __("IP address") }}</li>
            <li>{{ __("Phone number") }}</li>
            <li>{{ __("Address details") }}</li>
        </ol>

        <h2>{{ __("Special and/or sensitive personal data that we process") }}</h2>

        <p>{{ __("We do not intend to collect data with our website and/or service about website visitors younger than 16 years old unless they have permission from their parents or guardian. However, we cannot verify whether a visitor is over 16 years of age. Therefore, we recommend that parents be involved in their children’s online activities to prevent data from being collected from children without parental permission. If you are convinced that we have collected personal data on a minor without such consent, please contact us via the e-mail address provided in the contact details of this statement, and we will delete this information.") }}</p>

        <h2>{{ __("For what purpose and based on what grounds do we process personal data?") }}</h2>

        <p>{{ __("We process your personal data for the following purposes:") }}</p>

        <ul>
            <li>{{ __("To process your payment") }}</li>
            <li>{{ __("To send you our newsletter and/or advertising brochure") }}</li>
            <li>{{ __("To be able to call you or send you an e-mail if this is necessary to be able to provide our services") }}</li>
            <li>{{ __("To inform you about changes to our services and products") }}</li>
            <li>{{ __("To offer you the possibility of creating an account") }}</li>
            <li>{{ __("To deliver goods and services to you") }}</li>
            <li>{{ __("To comply with tax obligations and additional administrative duties") }}</li>
            <li>{{ __("To analyse website behaviour to better tailor the website, products and services to customer preferences.") }}</li>
        </ul>

        <h2>{{ __("The duration that we retain personal data") }}</h2>

        <p>{{ __("We will not retain your personal data any longer than is strictly necessary to fulfil the purposes for which it was collected.") }}</p>

        <h2>{{ __("Automated decision-making") }}</h2>

        <p>{{ __("We do not apply any automated decision-making regarding matters that could (significantly) affect individuals.") }}</p>

        <h2>{{ __("Sharing personal data with third parties") }}</h2>

        <p>{{ __("We share your personal data with various third parties via our website if this is deemed necessary for the execution of the agreement and to comply with a possible legal obligation. We will enter into a processing agreement with companies that process your data on our behalf to ensure the same level of security and confidentiality of your data. We remain responsible for these processes. We may also provide your personal data to other third parties. We will only do so with your express permission.") }}</p>

        <h2>{{ __("Cookies or similar technologies that we use") }}</h2>

        <p>{{ __("Our website uses functional, analytical and tracking cookies. A cookie is a small text file stored in the browser of your computer, tablet or smartphone when you first visit this website. We use functional session cookies and third-party cookies. These ensure that the website works properly and that, for example, your preferences are remembered. These cookies are also used to ensure that the website works properly and to optimise it, and we use cookies to track your surfing behaviour so that we can offer you customised content. When you first visited our website, we informed you about these cookies and asked your permission to place them. You can unsubscribe from cookies by configuring your internet browser so that it does not store cookies anymore. In addition, you can delete all information that has previously been stored via your browser settings.") }}</p>

        <p>{{ __("You can find more information about cookies on the following websites:") }}</p>

        <ul>
            <li>ICTRecht: <a href="https://web.archive.org/web/20221129004146/https:/ictrecht.nl/juridisch-advies/achtergrond-cookiewet/">
                {{ __("Background on cookie law") }}
            </a></li>
            <li>Consumentenbond: <a href="https://web.archive.org/web/20221129004146/http:/www.consumentenbond.nl/test/elektronica-communicatie/veilig-online/privacy-op-internet/extra/wat-zijn-cookies/">
                {{ __("What are cookies?") }}
            </a></li>
            <li>Consumentenbond: <a href="https://web.archive.org/web/20221129004146/https:/web.archive.org/web/20160702001240/http:/www.consumentenbond.nl/test/elektronica-communicatie/veilig-online/privacy-op-internet/extra/waarvoor-dienen-cookies/">
                {{ __("What are cookies for?") }}
            </a></li>
            <li>Consumentenbond: <a href="https://web.archive.org/web/20221129004146/http:/www.consumentenbond.nl/test/elektronica-communicatie/veilig-online/privacy-op-internet/extra/cookies-verwijderen/">
                {{ __("Delete cookies") }}
            </a></li>
            <li>Consumentenbond: <a href="https://web.archive.org/web/20221129004146/http:/www.consumentenbond.nl/internet-privacy/cookies-verwijderen/">
                {{ __("Disable cookies") }}
            </a></li>
        </ul>

        <h2>{{ __("Sharing personal data with Google via Google Analytics") }}</h2>

        <p>{{ __("Our website uses Google Analytics, a service provided by the American company Google, to collect personal data from visitors. The information collected is transferred to and stored by Google on servers in the United States. Information is not actively shared with others, but through Google Analytics, this does happen. To protect privacy as much as possible, we have a processing agreement with Google and have disabled data sharing. Furthermore, the IP address is anonymised so that it cannot be traced back to a person. Google states that it adheres to the Privacy Shield principles and is affiliated with the Privacy Shield programme of the American Department of Commerce. This means that there is an adequate level of protection for the processing of any personal data.") }}</p>

        <h2>{{ __("Sharing personal data on social media channels, such as Facebook, Twitter, LinkedIn and Google+") }}</h2>

        <p>{{ __("We do not use social media cookies. We have provided links to our LinkedIn and Twitter page only, which function without cookies.") }}</p>

        <h2>{{ __("Accessing, modifying or erasing data") }}</h2>

        <p>{{ __("You have the right to access, correct or erase your personal data. In addition, you have the right to withdraw your consent for data processing or object to the processing of your personal data by us, and you have the right to data portability. This means that you can submit a request to us to send the personal data we have on you in a computer file to you or another organisation named by you. You can send a request for access, correction, erasure, data portability or a request to withdraw your permission or objection to the processing of your personal data to the e-mail address provided in the Contact details section of this statement. To make sure that you are the person making the request, we ask you to include a copy of your identity document. Please make sure that your passport photo, MRZ (machine readable zone), passport number and Citizen Service Number (BSN) are blackened in this copy. This is to protect your privacy. We will respond to your request as quickly as possible but within four weeks. We would also like to point out that you have the option of submitting a complaint to the national supervisory authority, the Dutch Data Protection Authority (AP). You can do so via the following link:") }} <a href="https://autoriteitpersoonsgegevens.nl/nl/contact-met-de-autoriteit-persoonsgegevens/tip-ons">https://autoriteitpersoonsgegevens.nl/nl/contact-met-de-autoriteit-persoonsgegevens/tip-ons</a></p>

        <h2>{{ __("How we secure personal data") }}</h2>

        <p>{{ __("We are serious about protecting your data and take appropriate measures to prevent misuse, loss, unauthorised access, unwanted disclosure and unauthorised changes. If you feel that your information is not adequately protected or there are indications of misuse, please contact us at the e-mail address given in the Contact details in this statement. We have taken the following measures to protect your personal data:") }}</p>

        <ul>
            <li>{{ __("Security software, such as a virus scanner and firewall.") }}</li>
            <li>{{ __("TLS (formerly SSL). We send your data via a secure internet connection. You can tell this by the ‘https’ and the padlock icon in the address bar.") }}</li>
            <li>{{ __("DNSSEC is an additional security feature (in addition to DNS) for converting a domain name to the associated IP address; it is provided with a digital signature. You can have this signature checked automatically. This way, we prevent you from being redirected to a false IP address.") }}</li>
        </ul>

        <h2>{{ __("Questions?") }}</h2>

        <p>{{ __("If you have any questions about the privacy statement, please e-mail us at the e-mail address provided in the Contact details of this statement.") }}</p>
    </section>

</x-web.layout>