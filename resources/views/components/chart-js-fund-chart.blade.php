@pushOnce("foot")
<script src="https://cdn.jsdelivr.net/npm/chart.js@^3" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/luxon@^2" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@^1" type="text/javascript"></script>

<script type="text/javascript">
    function getNewChart(element, label, labels, dataset, afterContextCallack)
    {
        return new Chart(element, {
            type: 'line',
            data: {
                labels: labels,
                datasets: dataset
            },
            options: {
                aspectRatio: 1.5,
                locale: "nl",
                interaction: {
                    mode: "nearest",
                    intersect: false,
                    axis: "x"
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    crosshair: {
                        line: {
                            color: '#FFFFFF',  // crosshair line color
                            width: 1,        // crosshair line width
                            dashPattern: [2, 2],
                        },
                        sync: {
                            enabled: false,            // enable trace line syncing with other charts
                        },
                        zoom: {
                            enabled: false,                                      // enable zooming
                        },
                    },
                    tooltip: {
                        position: 'nearest',
                        displayColors: false,
                        spacing: 5,
                        format: { maximumFractionDigits: 2, minimumFractionDigits: 2 },
                        titleColor: '#FFFFFFAA',
                        bodyColor: '#FFFFFFAA',
                        titleFont : {
                            size: 10
                        },
                        bodyFont : {
                            size: 10
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';

                                if (context.parsed.y !== null) {
                                    label += context.parsed.y.toFixed(2);
                                }
                                return label;
                            },
                            afterBody: afterContextCallack
                        }
                    }
                },
                elements: {
                    point:{
                        radius: 0
                    }
                },
                scales: {
                    x: {
                        type: 'time',
                        time: {
                            parser: 'yyyy-MM-dd HH:mm',
                            unit: 'day',
                            tooltipFormat: 'yyyy-MM-dd HH:mm'
                        },
                        // grid:{
                        //     color: 'red'
                        // },
                        ticks: {
                            // font: {
                            //     size: 11
                            // },
                            color: "#FFFFFFAA",
                        }
                    },
                    y: {
                        grace: 20,
                        grid:{
                            color: '#FFFFFF33'
                        },
                        position: 'right',
                        ticks: {
                            // font: {
                            //     size: 11
                            // },
                            color: "#FFFFFFAA",
                            format: { maximumFractionDigits: 0, minimumFractionDigits: 0 }
                        },
                    }
                }
            }
        });
    }
</script>
@endPushOnce

<div class="jschartFundChart">
    @if($displayStatistics)
    <div class="chartValueItemsContainer">
        <div class="chartValueItem">
            <p class="key">{{ __("YTD") }}</p>
            <p class="value" id="returnYtd">{{ $returnYtd }}</p>
        </div>
        <div class="chartValueItem">
            <p class="key">{{ __("MONTHLY") }}</p>
            <p class="value" id="returnMonthly">{{ $returnMonthly }}</p>
        </div>
        <div class="chartValueItem">
            <p class="key">{{ __("SINCE START") }}</p>
            <p class="value" id="returnSinceStart">{{ $returnSinceStart }}</p>
        </div>
        <div class="chartValueItem">
            <p class="key">{{ __("CURRENT VALUE") }}</p>
            <p class="value" id="currentValue">{{ $currentValue }}</p>
        </div>
    </div>
    @endif

    <livewire:chart-js-fund-chart :fund-identifier="$fundIdentifier" :time-scale="$timeScale" :euro-line-color="$euroLineColor" :multi-currency="$multiCurrency" :start-date="$startDate" :wire:key="$fundIdentifier" />

    <div class="jschartFundChartChartContainer">
        <canvas id="myChart_{{ $fundIdentifier }}" class="jschartFundChartCanvas" style="max-height: 500px;"></canvas>
    </div>
</div>

@push("foot")
<script type="text/javascript">
    const element_{{ $fundIdentifier }} = document.getElementById("myChart_{{ $fundIdentifier }}");

    function afterContextCallack_{{ $fundIdentifier }}(context) {
        let afterBody = '';

        index = context[0].dataIndex;

        let first = {{ $startValue }};
        let current = context[0].dataset.data[index].y;

        let fundreturn = ( (current - first) / first) * 100;
        afterBody += fundreturn.toFixed(2) + '%';

        // console.log('first' + first);
        // console.log('current' + current);
        // console.log('index' + index);
        // console.log('fundreturn' + fundreturn);
        // console.log(context);

        return afterBody;
    }

    let chart_{{ $fundIdentifier }} = getNewChart(element_{{ $fundIdentifier }}, 'fundLabel', @json($labels), @json($datasets), afterContextCallack_{{ $fundIdentifier }});

    Livewire.on('updateChart_{{ $fundIdentifier }}', data => {
        // alert('updateChart');
        chart_{{ $fundIdentifier }}.options.scales.x.time.unit = data['unit'];

        chart_{{ $fundIdentifier }}.update();

        chart_{{ $fundIdentifier }}.data = data['data'];

        chart_{{ $fundIdentifier }}.update();
    });
</script>
@endpush

@pushOnce('foot')
<script>
    var darkmodeSwitch = document.getElementById("dark_mode_switch");
    if(darkmodeSwitch)
    {
        darkmodeSwitch.addEventListener(
            "lightMode",
            (e) => {
                var chartCanvasses = document.getElementsByClassName('jschartFundChartCanvas');

                for (var i = 0; i < chartCanvasses.length; i++)
                {
                    let chart = Chart.getChart(chartCanvasses[i]);
                    chart.options.scales.x.ticks.color = '#212121AA';
                    chart.options.scales.y.ticks.color = '#212121AA';
                    chart.options.scales.x.grid.color = '#2121210A';
                    chart.options.scales.y.grid.color = '#21212133';
                    chart.update();
                }
            },
            false,
        );

        darkmodeSwitch.addEventListener(
            "darkMode",
            (e) => {
                var chartCanvasses = document.getElementsByClassName('jschartFundChartCanvas');

                for (var i = 0; i < chartCanvasses.length; i++)
                {
                    let chart = Chart.getChart(chartCanvasses[i]);
                    chart.options.scales.x.ticks.color = '#FFFFFFAA';
                    chart.options.scales.y.ticks.color = '#FFFFFFAA';
                    chart.options.scales.x.grid.color = Chart.defaults.borderColor;
                    chart.options.scales.y.grid.color = '#FFFFFF33';
                    chart.update();
                }
            },
            false,
        );
    }

    var isDarkMode = document.getElementsByClassName('dark-mode');
    if (isDarkMode.length > 0) 
    {
        var chartCanvasses = document.getElementsByClassName('jschartFundChartCanvas');

        for (var i = 0; i < chartCanvasses.length; i++)
        {
            let chart = Chart.getChart(chartCanvasses[i]);
            if(chart)
            {
                chart.options.scales.x.ticks.color = '#FFFFFFAA';
                chart.options.scales.y.ticks.color = '#FFFFFFAA';
                chart.options.scales.x.grid.color = Chart.defaults.borderColor;
                chart.options.scales.y.grid.color = '#FFFFFF33';
                chart.update();
            }
        }
    }
    else
    {
        var chartCanvasses = document.getElementsByClassName('jschartFundChartCanvas');

        for (var i = 0; i < chartCanvasses.length; i++)
        {
            let chart = Chart.getChart(chartCanvasses[i]);
            if(chart)
            {
                chart.options.scales.x.ticks.color = '#212121AA';
                chart.options.scales.y.ticks.color = '#212121AA';
                chart.options.scales.x.grid.color = '#2121210A';
                chart.options.scales.y.grid.color = '#21212133';
                chart.update();
            }
        }
    }
</script>
@endPushOnce