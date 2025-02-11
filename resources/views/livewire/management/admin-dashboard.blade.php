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
            <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
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
                            <h3 class="">{{$audit_counts->count()}}</h3>
                            <h6 class="card-subtitle">Total Entries</h6></div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 85%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                                <th>Anomaly</th>
                                <th class="text-right">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-certificate  font-12" style="color:#B2BE36 "></i>Meter Bypass</td>
                                <td class="text-right bold">{{$audit_counts->where('anomaly','Meter Bypass')->count()}}</td>                            
                            </tr>
                            <tr>
                                <td><i class="fa fa-certificate  font-12" style="color:#B2BE36 "></i>Faulty Meters</td>
                                <td class="text-right">{{$audit_counts->where('anomaly','Faulty Meter')->count()}}</td>                            
                            </tr>
                            <tr>
                                <td><i class="fa fa-certificate font-12" style="color:#B2BE36 "></i>Tampered Meters</td>
                                <td class="text-right">{{$audit_counts->where('anomaly','Tampered Meter')->count()}}</td>                            
                            </tr>
                        </tbody>
                    </table>                    
                    <div class="row">
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 90%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
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
                                <th>Anomaly</th>
                                <th class="text-right">Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa fa-certificate  font-12" style="color:#B2BE36 "></i>Stolen Bypass</td>
                                <td class="text-right bold">{{$audit_counts->where('anomaly','Stolen Meter')->count()}}</td>                            
                            </tr>
                            <tr>
                                <td><i class="fa fa-certificate  font-12" style="color:#B2BE36 "></i>Abandoned Meters</td>
                                <td class="text-right">{{$audit_counts->where('anomaly','Abandoned Meter')->count()}}</td>                            
                            </tr>
                            <tr>
                                <td><i class="fa fa-certificate  font-12" style="color:#B2BE36 "></i>Meter Ok</td>
                                <td class="text-right">{{$audit_counts->where('anomaly','Meter Ok')->count()}}</td>                            
                            </tr>
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" style="width: 40%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="card d-none">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="m-b-0"><i class="fa fa-users text-warning"></i></h2>
                            <h3 class="">{{$users}}</h3>
                            <h6 class="card-subtitle">Total Users</h6></div>
                        <div class="col-12">
                            <div class="progress">
                                <div class="progress-bar bg-warning" role="progressbar" style="width: 26%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <livewire:management.admin.mainbar-component /> 
            </div> 
        </div>
           <div class="row">
                <div class="col-12 col-lg-8 col-xl-8 d-flex">
                    <div class="card radius-10 w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0"> {{ __('Total Count per Anomaly type') }}</h6>
                                </div>
                                <div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
                                </div>
                            </div>
                            <livewire:management.admin.anomalychart-component /> 

                           
                        </div>
                        <br>
                    </div>
                </div>
                <div class="col-12 col-lg-4 col-xl-4 d-flex">
                    <div class="card radius-10 overflow-hidden w-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6 class="mb-0"> {{ __('Visits Status') }}</h6>
                                </div>
                                <div class="font-22 ms-auto"><i class="bx bx-dots-horizontal-rounded"></i>
                                </div>
                            </div>
                            <livewire:management.admin.statuschart-component /> 
                        </div>
                    </div>
                </div>
          </div>
    </div>
    

</div>
