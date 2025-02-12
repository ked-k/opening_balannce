<div>

    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h3 class="text-themecolor">Dashboard</h3>
        </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </div>
        <div>
            <button
                class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i
                    class="ti-settings text-white"></i></button>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="card-group">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="m-b-0"><i class="fa fa-sitemap text-info"></i></h2>
                            <h3 class="">{{ $projects->count() }}</h3>
                            <h6 class="card-subtitle">Total Project Entries</h6>
                        </div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 85%; height: 6px;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card">
                <div class="card-body">
                    <table width="100%" class="table-hover align-items-center mt-1" style="font-size: 15px">
                        <thead class="table-light">
                            <tr>
                                <th>MOU</th>
                                <th class="text-right">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-certificate  font-12" style="color:#107C41 "></i>Total MOUs</td>
                                <td class="text-right bold">
                                    {{ $mous->count() }}</td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-certificate  font-12" style="color:#107C41 "></i>Expired MOUs</td>
                                <td class="text-right">{{ $mous->where('end_date', '<', date('Y-m-d'))->count() }}
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-certificate font-12" style="color:#107C41 "></i>Running MOUs</td>
                                <td class="text-right">{{ $mous->where('end_date', '>', date('Y-m-d'))->count() }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 90%; height: 6px;"
                                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-lg-8 col-xl-8 d-flex">
                <div class="card radius-10 w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0"> {{ __('Total Project Income Expenses') }}</h6>
                            </div>
                            <div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
                            </div>
                        </div>
                        <div class="apex-charts" wire:ignore id="transactions_report"></div>

                        {{-- <livewire:management.admin.anomalychart-component /> --}}


                    </div>
                    <br>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4 d-flex">
                <div class="card radius-10 overflow-hidden w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <h6 class="mb-0"> {{ __('Project Status') }}</h6>
                            </div>
                            <div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
                            </div>
                        </div>
                        <div class="apex-charts" wire:ignore id="project_status"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


</div>
@push('scripts')
    <script>
        var options = {
            stroke: {
                show: !0,
                width: 2,
                colors: ["transparent"]
            },
            legend: {
                show: !1,
                position: "bottom",
                horizontalAlign: "center",
                verticalAlign: "middle",
                floating: !1,
                fontSize: "14px",
                offsetX: 0,
                offsetY: 5
            },
            series: [
                @foreach ($project_data as $value)
                    {{ $value->inv_count }},
                @endforeach
            ],
            colors: ["#097A3A", "#2a76f4", "#67c8ff"],
            chart: {
                width: '80%',
                type: 'pie',
            },
            labels: [
                @foreach ($project_data as $value)
                    "{{ $value->progress_status }}",
                @endforeach
            ],

            plotOptions: {
                pie: {
                    dataLabels: {
                        offset: -5
                    },

                    fill: {
                        type: 'gradient',
                    },
                }
            },
            dataLabels: {
                formatter(val, opts) {
                    const name = opts.w.globals.labels[opts.seriesIndex]
                    return [name, val.toFixed(1) + '%']
                }
            },
            responsive: [{
                breakpoint: 600,
                options: {
                    plotOptions: {
                        donut: {
                            customScale: .2
                        }
                    },
                    chart: {
                        height: 200
                    },
                    legend: {
                        show: !1
                    }
                }
            }],
        };

        var chart = new ApexCharts(document.querySelector("#project_status"), options);
        chart.render();

        var options2 = {
            series: [{
                    name: 'Total Incomes',
                    data: [
                        @foreach ($transactions_chart as $data)
                            // {{ $data->total_expense }},
                            "{{ sprintf('%.2f', $data->total_income) }}",
                        @endforeach
                    ]
                },
                {
                    name: 'Total Expenses',
                    data: [
                        @foreach ($transactions_chart as $data)
                            // {{ $data->total_expense }},
                            "{{ sprintf('%.2f', $data->total_expense) }}",
                        @endforeach
                    ]
                }

            ],
            colors: ['#2A76F4', '#67C8FF', '#951F39', '#33C481'],
            chart: {
                height: 350,
                type: 'bar'
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            xaxis: {
                categories: [
                    @foreach ($transactions_chart as $data)
                        '{{ $data->display_date }}',
                    @endforeach
                ]
            },

        };

        var chart2 = new ApexCharts(document.querySelector("#transactions_report"), options2);
        chart2.render();
    </script>
@endpush

</div>
