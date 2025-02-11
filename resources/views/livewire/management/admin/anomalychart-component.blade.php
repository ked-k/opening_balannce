<div>
    <div class="chart-container-1" wire:ignore.self>
        <div wire:ignore id="anomalyCounts"></div>
    </div>
    @push('scripts')
        <script>


            
            // Monthly samples line chart
            var options2 = {
                series: [{
                        name: 'Total Counts',
                        data: [
                            @foreach ($anomaly_counts as $data)
                                        {{ $data->audit_count }},
                            @endforeach
                        ]
                        
                    },
                    
                ],
                chart: {
                    foreColor: '#9a9797',
                    type: "area",
                    //width: 130,
                    height: 360,
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !1
                    },
                    dropShadow: {
                        enabled: 0,
                        top: 3,
                        left: 14,
                        blur: 4,
                        opacity: .12,
                        color: "#3461ff"
                    },
                    sparkline: {
                        enabled: !1
                    }
                },
                markers: {
                    size: 0,
                    colors: ["#3461ff", "#12bf24"],
                    strokeColors: "#fff",
                    strokeWidth: 2,
                    hover: {
                        size: 7
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "35%",
                        endingShape: "rounded"
                    }
                },
                legend: {
                    show: false,
                    position: 'top',
                    horizontalAlign: 'left',
                    offsetX: -20
                },
                dataLabels: {
                    enabled: !1
                },
                grid: {
                    show: true,
                    // borderColor: '#eee',
                    // strokeDashArray: 4,
                },
                stroke: {
                    show: !0,
                    width: 3,
                    curve: "smooth"
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        shadeIntensity: 0.9,
                        gradientToColors: ["#B2BE36", "#CDD380"],
                        inverseColors: true,
                        opacityFrom: 0.8,
                        opacityTo: 0.2,
                        //stops: [0, 50, 100],
                        //colorStops: []
                    }
                },
                colors: ["#B2BE36", "#CDD380"],
                xaxis: {
                    categories: [
                        @foreach ($anomaly_counts as $data)
                                    '{{ $data->anomaly }}',
                    @endforeach
                    ]

                },
                tooltip: {
                    theme: 'dark',
                    y: {
                        formatter: function(val) {
                            return "" + val + ""
                        }
                    }
                }
            };

            var tests_chart = new ApexCharts(document.querySelector("#anomalyCounts"), options2);
            tests_chart.render();


        
        </script>
    
    @endpush
</div>
