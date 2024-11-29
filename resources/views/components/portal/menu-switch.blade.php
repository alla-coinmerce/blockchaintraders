@if ($showSwitch)
    <div class="dropdown">
        <div class="dropdown_button">{{ $environment }} <i class="fa-solid fa-chevron-down fa-xs"></i></div>
        <div class="dropdown_content">
            <a href="/?choice=portfolio">Portfolio</a>
            <a href="/?choice=knowledge_base">Kennisbank</a>
        </div>
    </div>
@endif