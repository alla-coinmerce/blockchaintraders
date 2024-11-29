<div>
    <div id="fundPlot_{{ $fund->id }}" class="fundplot"></div>
    <script defer>
        var x_data_euro = [{!! implode(', ', $xDataEuro) !!}];
        var y_data_euro = [{!! implode(', ', $yDataEuro) !!}];
        var x_data_dollar = [{!! implode(', ', $xDataDollar) !!}];
        var y_data_dollar = [{!! implode(', ', $yDataDollar) !!}];

        var eurolabels = [];

        y_data_euro_subset = y_data_euro.slice({{ $startIndex }}, y_data_euro.length);
        y_data_dollar_subset = y_data_dollar.slice({{ $startIndex }}, y_data_dollar.length);

        var y_min_euro = Math.min(...y_data_euro_subset);
        var y_max_euro = Math.max(...y_data_euro_subset);
        var y_min_dollar = Math.min(...y_data_dollar_subset);
        var y_max_dollar = Math.max(...y_data_dollar_subset);

        var y_min = y_min_euro < y_min_dollar ? y_min_euro : y_min_dollar;
        var y_max = y_max_euro > y_max_dollar ? y_max_euro : y_max_dollar;
        
        @if(!empty($yDataEuro))
            y_data_euro.forEach(function(element) {
                var fundreturn = ( (element - {!! $yDataEuro[0] !!}) / {!! $yDataEuro[0] !!}) * 100;
                eurolabels.push(fundreturn.toFixed(2));
            });
        @endif

        var dollarlabels = [];
        
        @if(!empty($yDataDollar))
            y_data_dollar.forEach(function(element) {
                var fundreturn = ( (element - {!! $yDataDollar[0] !!}) / {!! $yDataDollar[0] !!}) * 100;
                dollarlabels.push(fundreturn.toFixed(2));
            });
        @endif

        // console.log(labels);

        var eurotrace = {
            x: x_data_euro,
            y: y_data_euro,
            name: 'Euro',
            mode: 'lines',
            line: {
                color: '#2c82be'
            },
            hovertemplate: " %{x} <br> €%{y:.2f} <br> %{text}% ",
            hoverlabel: {
                namelength: 0,
                bgcolor: '#fefefe',
                bordercolor: '#2c82be',
                font: {
                    family: 'Graphik',
                    size: 12,
                    color: "#000000"
                }
            },
            text: eurolabels
        };

        var dollartrace = {
            x: x_data_dollar,
            y: y_data_dollar,
            name: 'Dollar',
            mode: 'lines',
            line: {
                color: '#66bd51'
            },
            hovertemplate: " %{x} <br> $%{y:.2f} <br> %{text}% ",
            hoverlabel: {
                namelength: 0,
                bgcolor: '#fefefe',
                bordercolor: '#66bd51',
                font: {
                    family: 'Graphik',
                    size: 12,
                    color: "#000000"
                }
            },
            text: dollarlabels
        };
        
        // Define Data
        var data = [eurotrace, dollartrace];
        
        // Define Layout
        var layout = {
            hovermode: 'closest', 
            xaxis: {
                // autorange: true,
                range: [x_data_euro[{{ $startIndex }}], x_data_euro[x_data_euro.length - 1]],
                showgrid: false,
                showline: true,
                linewidth: 1,
                tickformat: '%d-%m-%Y',
                tickangle: 45,
                tickfont: {
                    family: 'Graphik',
                    size: {{ $fontSize }},
                    color: "#212121"
                },
                ticks: 'outside',
                ticklen: 4,
                tickwidth: 1,
                tickcolor: '#212121'
            },
            yaxis: {
                title: {
                    text: "Participatie waarde",
                    font: {
                        family: 'Graphik',
                        size: {{ $fontSize }},
                        color: "#212121"
                    },
                },
                // autorange: true,
                range: [y_min - 10, y_max + 10],
                // tickformat: ".2f",
                tickprefix: "{{ $tickPrefix }}",
                ticksuffix: "  ",
                tickfont: {
                    family: 'Graphik',
                    size: {{ $fontSize }},
                    color: "#212121"
                }
            },
            // autosize: true,
            automargin: true,
            // width: 1000,
            // height: 500,
            margin: {
                l: {{  $marginLeft }},
                r: 20,
                b: 0,
                t: 40,
                // pad: 10
            },
            // paper_bgcolor: '#7f7f7f',
            // plot_bgcolor: '#c7c7c7'
            showlegend: true,
            legend: {
                x: 0.5,
                xanchor: 'center',
                y: -0.25,
                // yanchor: 'bottom',
                "orientation": "h",
                font: {
                    size: {{ $fontSize }},
                },
            }
        };

        var config = {responsive: true}
        
        // Display using Plotly
        Plotly.newPlot(
            "fundPlot_{{ $fund->id }}", 
            data, 
            layout, 
            {
                modeBarButtonsToRemove: ['toImage', 'zoom2d', 'resetScale2d', 'toggleSpikelines', 'hoverClosestCartesian', 'hoverCompareCartesian'],
                displaylogo: false,
            },
            config
        );
    </script>
</div>