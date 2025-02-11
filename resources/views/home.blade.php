<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MERP') }}</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/png" />
    <!-- loader-->
    <link href="{{ asset('assets/css/pace.min.css') }}" rel="stylesheet" />
    <script src="{{ asset('assets/js/pace.min.js') }}"></script>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

    @livewireStyles
</head>

<body>
    <!-- wrapper -->
    <div class="wrapper">
        <nav class="navbar navbar-expand-lg navbar-light bg-white rounded fixed-top rounded-0 shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/images/merp-logo.png') }}" width="140" alt="" />
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1"
                    aria-expanded="false" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent1">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"> <a class="nav-link active" aria-current="page"
                                href="{{ route('home') }}"><i class='bx bx-home-alt me-1'></i>Home</a>
                        </li>

                        @if (Auth::user()->hasPermission(['access_user_management_module']))
                            <li class="nav-item"> <a class="nav-link" href="{{ route('admin-dashboard') }}"><i
                                        class='bx bx-cog me-1'></i>Manage</a>
                            </li>
                        @endif

                        <li class="nav-item"> <a class="nav-link" href="{{ route('logout') }}"><i
                                    class='bx bx-log-out me-1'></i>Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="landing-page d-flex align-items-center justify-content-center">
            <div class="container">
                <div class="row row-cols-1 row-cols-md-1 row-cols-lg-2 row-cols-xl-3">
                    <div class="col">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/home/hr.jpg') }}" alt="..."
                                        class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Human Resource</h5>
                                        <p class="card-text">Recruitment, Compensation and Employee relations. <a
                                                href="{{route('human-resource-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                                <i class="bx bx-arrow-to-right me-1"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/home/inventory.jpg') }}" alt="..."
                                        class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Inventory & Logistics</h5>
                                        <p class="card-text">Forecasting, Acquisition, Consumption, and Tracking. <a
                                                href="{{route('inventory-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                                <i class="bx bx-arrow-to-right me-1"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/home/assets.jpg') }}" alt="..."
                                        class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Assets Management</h5>
                                        <p class="card-text">Identification, Acquisition, Maintenance and Disposal. <a
                                                href="{{route('assets-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                                <i class="bx bx-arrow-to-right me-1"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/home/finance.jpg') }}" alt="..."
                                        class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Finance & Accounting</h5>
                                        <p class="card-text">Budgeting, Accounting, Invoicing, and Requisition. <a
                                                href="{{route('finance-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                                <i class="bx bx-arrow-to-right me-1"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/home/procurement.jpg') }}" alt="..."
                                        class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Procurement</h5>
                                        <p class="card-text">Planning, Identification, Selection, and Aquisition. <a
                                                href="{{route('procurement-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                                <i class="bx bx-arrow-to-right me-1"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/home/documents.jpg') }}" alt="..."
                                        class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Document Control</h5>
                                        <p class="card-text">Reports, SoPs, Policies, Notices, and Templates. <a
                                                href="{{route('documents-dashboard')}}" class="btn btn-sm btn-outline-success not_active">
                                                <i class="bx bx-arrow-to-right me-1"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/home/timesheets.jpg') }}" alt="..."
                                        class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Staff Timesheets</h5>
                                        <p class="card-text">Track employee work hours, leaves, and accruals.. <a
                                                href="#" class="btn btn-sm btn-outline-success not_active">
                                                <i class="bx bx-arrow-to-right me-1"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/home/monitoring.jpg') }}" alt="..."
                                        class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">Internal Monitoring</h5>
                                        <p class="card-text">Monitoring and Evaluation, Projects progress tracking.<a
                                                href="#" class="btn btn-sm btn-outline-success not_active">
                                                <i class="bx bx-arrow-to-right me-1"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset('assets/images/home/kpi.jpg') }}" alt="..."
                                        class="card-img">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">KPI Dashboard</h5>
                                        <p class="card-text">Tracking KPIs, summaries and aggrigates.<a href="#"
                                                class="btn btn-sm btn-outline-success not_active">
                                                <i class="bx bx-arrow-to-right me-1"></i></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (!auth()->user()->declaration)
            <livewire:user-management.data-policy-confirmation-component />
        @endif

        <footer class="bg-white shadow-sm border-top p-2 text-center fixed-bottom">
            <p class="mb-0"><span>&copy; {{ date('Y') }} <a href="#"
                        class="text-success fw-bold">Makerere University Biomedical Research Centre</a></span>. All
                right reserved.</p>
        </footer>
    </div>
    <!-- end wrapper -->

    <!--plugins-->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    @livewireScripts

    <script type="text/javascript">
        $(document).ready(function() {

            $('#info-alert-modal').modal('show');

            window.addEventListener('swal:modal', event => {
                swal({
                    title: event.detail.message,
                    text: event.detail.text,
                    icon: event.detail.type,
                });
            });

            window.addEventListener('close-modal', event => {
                $('#info-alert-modal').modal('hide');
            });

        });
    </script>
</body>

</html>
