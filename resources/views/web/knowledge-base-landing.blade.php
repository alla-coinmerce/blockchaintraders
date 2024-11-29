<x-web.layout id="knowledge_base_landing_page" class="website_knowledge_base" :darkMode='false'>

    @push('meta')
        <meta name="keywords" content="{{  __("crypto, investment fund, Bitcoin, Ethereum, DeFi, blockchain, cryptocurrency, fund") }}">
        <meta name="description" content="{{  __("AFM registered cryptocurrency fund. Safely invest in Blockchain ✓ Bitcoin ✓ Ethereum ✓ and DeFi ✓ according to our established strategy.") }}">
    @endpush

    <x-slot:title>
        {{ __("The leading crypto investment fund | BlockchainTraders") }}
    </x-slot>

    <x-slot:heading>
        <section id="heading_knowledge_base_register">
            <div class="inner">
                <div id="header_headline_block" class="block">
                    <h1>BlockchainTraders<br>{{ __("knowledge base") }}</h1>

                    <p>{{  __("Invest successfully in crypto yourself with the knowledge of the experts at BlockchainTraders") }}</p>

                    <ul class="no_bullets custom_bullet_icons">
                        <li><img src="/assets/images/knowledge_base_landing/icon-solid.svg" alt="icon">{{ __("Everything about solid investing in crypto") }}</li>
                        <li><img src="/assets/images/knowledge_base_landing/icon-news.svg" alt="icon">{{ __("The latest crypto news every week") }}</li>
                        <li><img src="/assets/images/knowledge_base_landing/icon-percentage.svg" alt="icon">{{ __("Earn interest on your cryptos through DeFi and staking") }}</li>
                        <li><img src="/assets/images/knowledge_base_landing/icon-lock.svg" alt="icon">{{ __("Only :monthlyPrice per month", ['monthlyPrice' => '€39,95']) }}</li>
                    </ul>
                </div>

                <div id="registration_form_block" class="block request_info_form_block">
                    <div id="request_info_form_top" class="header_form">
                        <x-special-offer-sticker/>
                        <h2>{{ __("Register direct") }}</h2>

                        <form method="POST" action="{{ route('knowledgebase.register') }}">
                            @csrf
   
                            <input class="@error('subscription_firstname') alert alert-danger @enderror" 
                                type="text" 
                                id="kb_register_form_firstname" 
                                name="subscription_firstname" 
                                placeholder="@error('subscription_firstname'){{ $message }}@else{{ __("First name") }}@enderror"
                                value="@error('subscription_firstname')@else{{ old('subscription_firstname') }}@enderror">
                        
                            <input class="@error('subscription_lastname') alert alert-danger @enderror" 
                                type="text" 
                                id="kb_register_form_lastname" 
                                name="subscription_lastname" 
                                placeholder="@error('subscription_lastname'){{ $message }}@else{{ __("Last name") }}@enderror"
                                value="@error('subscription_lastname')@else{{ old('subscription_lastname') }}@enderror">
                        
                            <input class="@error('subscription_email') alert alert-danger @enderror" 
                                type="text" 
                                id="kb_register_form_email" 
                                name="subscription_email" 
                                placeholder="@error('subscription_email'){{ $message }}@else{{ __("Email address") }} @enderror"
                                value="@error('subscription_email')@else{{ old('subscription_email') }}@enderror">
                            
                            <div id="kb_register_form_subscription_type_radio_buttons">
                                <p>{{ __("Type of subscription") }}</p>

                                <div>
                                    <input type="radio" name="subscription_subscription_type" id="subscription_monthly" value="monthly" @checked(old('subscription_subscription_type', 'monthly') === 'monthly')>
                                    <label for="subscription_monthly">{{ __("Monthly") }} (€39,95 p/m)</label>
                                </div>
                                <div>
                                    <input type="radio" name="subscription_subscription_type" id="subscription_annual" value="annual" @checked(old('subscription_subscription_type', '') === 'annual')>
                                    <label for="subscription_annual">{{ __("Annual") }} (<s>€479,40</s> €399 {{ __("p/y") }})</label>
                                </div>
                            </div>

                            <input class="@error('subscription_coupon') alert alert-danger @enderror" 
                                type="text" 
                                id="kb_register_form_coupon" 
                                name="subscription_coupon" 
                                placeholder="@error('subscription_coupon'){{ $message }}@else{{ __("Coupon") }} @enderror"
                                value="@error('subscription_coupon')@else{{ old('subscription_coupon') }}@enderror">
                        
                            <x-honeypot />
                        
                            <button id="kb_register_form_submit" type="submit">{{ __("Continue") }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </x-slot>

    <section id="about">
        <div class="block">
            <h2>{{ __("ABOUT US") }}</h2>

            <p class="subtitle">{{ __("Optimally respond to trends and developments") }}</p>

            <p>{{ __("BlockchainTraders was founded by Michiel van der Steeg and Justin Kool. Justin bought his first Bitcoin in 2014. In 2017, Justin and Michiel gained a lot of cryptocurrency experience together. They have outperformed the market by more than 30% this year and started BlockchainTraders with their cryptocurrency returns.") }}</p>
        
            <a href="{{ route('about') }}">{{ __("Read more") }}<i class="fa fa-arrow-right fa-fw"></i></a>
        </div>
  
        <div class="block image_block">
            <img alt="{{ __("Justin and Michiel") }}" src="/assets/images/knowledge_base_landing/justin_and_michiel.jpg" width="360px" height="280px">
        </div>
    </section>

    <section id="subscriptions">
        <h2>{{  __("Subscriptions") }}</h2>

        <div class="block">
            <h3>{{ __("Monthly") }}</h3>
            <p>€39,95 p/m</p>

            <ul>
                <li>{{ __("Access to the entire knowledge base") }}</li>
                <li>{{ __("Access to all blog articles") }}</li>
                <li>{{ __("Monthly terminable") }}</li>
            </ul>

            <a onclick="open_modal('subscriptionModalMonthly')" class="button">{{ __("Start immediately") }} <i class="fa fa-arrow-right fa-fw"></i></a>
        </div>

        <div class="block">
            <h3>{{ __("Annual") }}</h3>
            <p><s>€479,40</s> €399</p>

            <ul>
                <li>{{ __("Access to the entire knowledge base") }}</li>
                <li>{{ __("Access to all blog articles") }}</li>
                <li>{{ __("Discount for annual subscription") }}</li>
            </ul>

            <a onclick="open_modal('subscriptionModalAnnual')" class="button">{{ __("Start immediately") }} <i class="fa fa-arrow-right fa-fw"></i></a>
        </div>
    </section>

    <section id="reviews">
        <h2>Reviews</h2>

        <div class="reviewContainer">
            <x-web.review :stars="4" :addHalfStar="true" title="{{ __('Useful articles') }}" avatarUrl="/assets/images/knowledge_base_landing/dummy_avatar.jpg" name="Peter">
                {{ __("BlockchainTraders' articles helped me immensely to get started with investing.") }}
            </x-web.review>

            <x-web.review :stars="4" title="{{ __('Useful articles') }}" avatarUrl="/assets/images/knowledge_base_landing/dummy_avatar.jpg" name="Peter">
                {{ __("BlockchainTraders' articles helped me immensely to get started with investing.") }}
            </x-web.review>

            <x-web.review :stars="5" title="{{ __('Useful articles') }}" avatarUrl="/assets/images/knowledge_base_landing/dummy_avatar.jpg" name="Peter">
                {{ __("BlockchainTraders' articles helped me immensely to get started with investing.") }}
            </x-web.review>
        </div>
    </section>

    <section id="get_to_know_more">
        <div class="block">
            <h2>{{ __("REQUEST INFORMATION") }}</h2>
        
            <p class="subtitle">{{ __("Invest in a professional manner in cryptocurrencies") }}</p>

            <p>{{ __("Receive more information about our funds without obligation. We will contact you as soon as possible.") }}</p>
        </div>
    
        <div class="block">
            <livewire:web.contact-form-k-b :submitButtonText="__('Request information')" submitButtonIcon=" <i class='fa fa-arrow-right fa-fw'></i>"  formTag="Bottom contact form" />
        </div>
    </section>

    <x-modal id="subscriptionModalMonthly">
        <livewire:web.subscription-form-modal modal_id="subscriptionModalMonthly" subscription_subscription_type="monthly" />
    </x-modal>

    <x-modal id="subscriptionModalAnnual">
        <livewire:web.subscription-form-modal modal_id="subscriptionModalAnnually" subscription_subscription_type="annual" />
    </x-modal>

</x-web.layout>