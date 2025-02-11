<div>
    <div class="chart-container-2 my-3" wire:ignore.self>
        <div wire:ignore id="anomalyStatus"></div>
        {{-- <canvas id="sampleSchart"></canvas> --}}
    </div>
    @push('scripts')

        <script>
            var options = {
                series: [
                    @foreach ($anomaly_status as $value)
                        {{ $value->audit_count }},
                    @endforeach
                ],
                chart: {
                    width: '100%',
                    type: 'pie',
                },
                labels: [
                    @foreach ($anomaly_status as $value)
                        "{{ $value->status }}",
                    @endforeach
                ],

                plotOptions: {
                    pie: {
                        dataLabels: {
                            offset: -5
                        },

                        fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'light',
                        type: "vertical",
                        shadeIntensity: 0.5,
                        gradientToColors: ["#A7E7AE", "#ff6a00"],
                        inverseColors: true,
                        opacityFrom: 1,
                        opacityTo: 1,
                        //stops: [0, 50, 100],
                        //colorStops: []
                    }
                },
                    }
                },
                dataLabels: {
                    formatter(val, opts) {
                        const name = opts.w.globals.labels[opts.seriesIndex]
                        return [name, val.toFixed(1) + '%']
                    }
                },
                legend: {
                    show: false
                }
            };

            var chart = new ApexCharts(document.querySelector("#anomalyStatus"), options);
            chart.render();
        </script>
        
    @endpush
</div>
