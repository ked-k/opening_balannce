<div>
    <div class="card">
        <div class="card-header">
            
            <h6>{{ __('Meters Visited Months') }}</h6>
        </div>
        <div class="card-body">                    
            <div wire:ignore id="mainChart"></div>
        </div>
    </div>
   @push('scripts')
   <script>
    var optionsb = {
        series: [{
                        name: 'Total Audits',
                        data: [
                            @foreach ($main_chart as $data)
                                {{ $data->total_audits }},
                            @endforeach
                        ]
                    }, {
                        name: 'Total Abandoned meters',
                        data: [
                            @foreach ($main_chart as $data)
                                {{ $data->abandoned }},
                            @endforeach
                        ]
                    },
                    {
                        name: 'Total Tampered meters',
                        data: [
                            @foreach ($main_chart as $data)
                                {{ $data->tampered }},
                            @endforeach
                        ]
                    },{
                        name: 'Total Faulty',
                        data: [
                            @foreach ($main_chart as $data)
                                {{ $data->faulty }},
                            @endforeach
                        ]
                    },
                    {
                        name: 'Total Meter Bypass',
                        data: [
                            @foreach ($main_chart as $data)
                                {{ $data->meter_bypass }},
                            @endforeach
                        ]
                    },
                    {
                        name: 'Total Meter Ok',
                        data: [
                            @foreach ($main_chart as $data)
                                {{ $data->meter_ok }},
                            @endforeach
                        ]
                    },
                    {
                        name: 'Total Stolen',
                        data: [
                            @foreach ($main_chart as $data)
                                {{ $data->stolen }},
                            @endforeach
                        ]
                    }
    ],
        colors: ['#119A48', '#B2BE36','#007ACC','#DC1023','#FFB22B','#B2BE36','#142351'],
        chart: {
            height: 450,
            // width:1080,
            type: 'bar',
            stacked: false,
        },
        stroke: {
            width: [0, 2, 5],
            curve: 'smooth'
        },
        plotOptions: {
            bar: {
                columnWidth: '50%'
            }
        },

        fill: {
            type: 'gradient',
        gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.07,
            gradientToColors: undefined,
            inverseColors: true,
            opacityFrom: 0.85,
            opacityTo: 0.85,
            stops: [50, 0, 100]
            
        }
    },
        labels: [
            @foreach ($main_chart as $data)
                            '{{ $data->display_date }}',
            @endforeach
        ],
        markers: {
            size: 0
        },
        yaxis: {
            title: {
                text: 'Meters',
            },
            min: 0
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function(y) {
                    if (typeof y !== "undefined") {
                        return y.toFixed(0) + " Meters";
                    }
                    return y;

                }
            }
        }
    };

    var chartb = new ApexCharts(document.querySelector("#mainChart"), optionsb);
    chartb.render();
</script>
   @endpush
</div>
