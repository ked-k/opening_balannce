
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon.png')}}">
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/style.css')}}" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="{{ asset('assets/css/colors/blue.css')}}" id="theme" rel="stylesheet">
        <!-- iziToast CSS -->
    <link href="{{ asset('assets/plugins/izitoast/css/iziToast.min.css') }}" rel="stylesheet" type="text/css">
 {{-- <script src="{{ asset('assets/plugins/apexcharts-bundle/css/apexcharts.css') }}"></script> --}}
    @livewireStyles
        <!-- Push CSS -->
    @stack('css')

</head>

<body class="fix-sidebar fix-header card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <livewire:layouts.partials.header-component />
        <livewire:layouts.partials.sidebar-navigation-component />

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            @include('layouts.messages')
            {{-- @yield('content') --}}
            {{ $slot }}
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->

        <!-- ============================================================== -->
        <!-- Right sidebar -->
        <!-- ============================================================== -->
        <!-- .right-sidebar -->
        
        <!-- ============================================================== -->
        <!-- End Right sidebar -->
        <!-- ============================================================== -->
        <livewire:layouts.partials.footer-component />

    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js')}}"></script>

    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/js/jquery.slimscroll.js')}}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('assets/js/waves.js')}}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('assets/js/sidebarmenu.js')}}"></script>
    <!--stickey kit -->
    <script src="{{ asset('assets/plugins/sticky-kit-master/dist/sticky-kit.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <!--Custom JavaScript -->

    <script src="{{ asset('assets/plugins/styleswitcher/jQuery.style.switcher.js')}}"></script>
    <script src="{{ asset('assets/js/custom.min.js')}}"></script>
    <script src="{{ asset('assets/js/jquery.PrintArea.js')}}" type="text/JavaScript"></script>
    
    <script src="{{ asset('assets/plugins/apexcharts-bundle/js/apexcharts.min.js') }}"></script>
    @stack('scripts')
    <script src="{{ asset('assets/plugins/izitoast/js/iziToast.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/js/sort.js') }}"></script>
    <script src="{{ asset('assets/js/xlsx.full.min.js') }}"></script>
    <script>
    $(document).ready(function() {
        $("#print").click(function() {
            var mode = 'iframe'; //popup
            var close = mode == "popup";
            var options = {
                mode: mode,
                popClose: close
            };
            $("div.printableArea").printArea(options);
        });
    });
    </script>
     <script>
        $(document).ready(function() {
            $('#example1').DataTable();
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    "columnDefs": [{
                        "visible": false,
                        "targets": 2
                    }],
                    "order": [
                        [2, 'asc']
                    ],
                    "displayLength": 25,
                    "drawCallback": function(settings) {
                        var api = this.api();
                        var rows = api.rows({
                            page: 'current'
                        }).nodes();
                        var last = null;
                        api.column(2, {
                            page: 'current'
                        }).data().each(function(group, i) {
                            if (last !== group) {
                                $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                                last = group;
                            }
                        });
                    }
                });
                // Order by the grouping
                $('#example tbody').on('click', 'tr.group', function() {
                    var currentOrder = table.order()[0];
                    if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                        table.order([2, 'desc']).draw();
                    } else {
                        table.order([2, 'asc']).draw();
                    }
                });
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        </script>
 @livewireScripts
 <script>
     window.addEventListener('alert', event => {

         if (event.detail.type == 'success') {
             iziToast.success({
                 title: 'Success!',
                 message: `${event.detail.message}`,
                 timeout: 5000,
                 position: 'topRight'
             });
         }

         if (event.detail.type == 'Error') {
             iziToast.error({
                 title: 'Error!',
                 message: `${event.detail.message}`,
                 timeout: 5000,
                 position: 'topRight'
             });
         }

         if (event.detail.type == 'warning') {
             iziToast.warning({
                 title: 'Warning!',
                 message: `${event.detail.message}`,
                 timeout: 5000,
                 position: 'topRight'
             });
         }
     });

     window.addEventListener('switch-theme', event => {
         $("html").attr("class", `${event.detail.theme}`)
     });

     window.addEventListener('swal:modal', event => {
         swal({
             title: event.detail.message,
             text: event.detail.text,
             icon: event.detail.type,
         });
     });

     window.addEventListener('swal:confirm', event => {
         swal({
                 title: event.detail.message,
                 text: event.detail.text,
                 icon: event.detail.type,
                 buttons: true,
                 dangerMode: true,
             })
             .then((willDelete) => {
                 if (willDelete) {
                     window.livewire.emit('remove');
                 } else {
                     window.livewire.emit('cancel');
                 }
             });
     });
 </script>

 @stack('scripts')
</body>

</html>
