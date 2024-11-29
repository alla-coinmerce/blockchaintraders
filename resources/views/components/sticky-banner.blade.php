<div id="sticky-banner">
    <div class="banner-content">
        <div>De volgende stap vooruit: <strong>BlockchainTraders</strong> sluit zich aan bij <strong>Coinmerce Capital</strong>. <a href="https://blockchaintraders.nl" target="_blank">Klik hier</a> voor meer informatie.</div>
        <div class="logos">
            <img src="{{ asset('assets/images/logo_with_black_name.svg') }}" alt="Coinmerce Capital Logo"  height="40">
            <img src="{{ asset('assets/images/logo_with_black_name.svg') }}" alt="BlockchainTraders Logo"  height="40">
        </div>
        <span class="close" onclick="closeBanner()">×</span>
    </div>
</div>

<script>
    function closeBanner() {
        document.getElementById('sticky-banner').style.display = 'none';
    }
</script>