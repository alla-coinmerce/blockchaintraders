<div class="funds-button-wrapper">
    <div class="fund-timeunit-wrapper">
        <button @class(['timeunit-btn', 'active' => $timeScale === '1w']) wire:click="onTimeScaleChange('1w')">1W</button>
        <button @class(['timeunit-btn', 'active' => $timeScale === '1m']) wire:click="onTimeScaleChange('1m')">1M</button>
        <button @class(['timeunit-btn', 'active' => $timeScale === '1y']) wire:click="onTimeScaleChange('1y')">1Y</button>
        <button @class(['timeunit-btn', 'active' => $timeScale === 'ytd']) wire:click="onTimeScaleChange('ytd')">YTD</button>
        <button @class(['timeunit-btn', 'active' => $timeScale === 'all']) wire:click="onTimeScaleChange('all')">{{ __("ALL") }}</button>
    </div>
</div>