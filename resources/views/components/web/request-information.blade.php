<section id="request information">
    <div class="block">
        <h2>{{ __("REQUEST INFORMATION") }}</h2>
        
        <p class="subtitle">{{ __("Invest in a professional manner in cryptocurrencies") }}</p>

        <p>{{ __("Receive more information about our funds without obligation. We will contact you as soon as possible.") }}</p>
    </div>

    <div class="block">
        <livewire:web.contact-form :submitButtonText="__('Request information')" submitButtonIcon=" <i class='fa fa-arrow-right fa-fw'></i>"  formTag="Bottom contact form" />
    </div>
</section>