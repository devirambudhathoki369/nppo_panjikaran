<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ env('APP_NAME') }}" name="description" />
    <meta content="{{ env('APP_OFFICE') }}" name="author" />
    <!-- Add this in your blade layout head section -->
    <meta name="base-url" content="{{ url('/') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
        type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- datepicker css -->
    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">

    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="{{ asset('assets/nepali-datepicker/css/nepali.datepicker.v4.0.1.min.css') }}" rel="stylesheet"
        type="text/css" />

    <!-- Custom css -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @yield('styles')

</head>

<body class="pace-done" data-topbar="dark" data-sidebar="dark">
    <!-- Begin page -->
    <div id="layout-wrapper">

        @include('includes.header')

        <!-- ========== Left Sidebar ========== -->
        @include('includes.sidebar')
        <!-- /Left Sidebar -->

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @include('includes.alerts')


                    @yield('content')

                </div> <!-- container-fluid -->
            </div>
            <!-- End Page-content -->


            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">© {{ date('Y') }} {{ env('APP_OFFICE') }}</div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Design & Develop by <a href="http://himalayanit.com.np/home" class="text-decoration-underline" target="_blank">Himalayan IT</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>
    @yield('modal')


    <!-- JAVASCRIPT -->
    <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
    <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/province-district.js')}}"></script>

    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('assets/nepali-datepicker/js/nepali.datepicker.v4.0.1.min.js') }}"></script>

    <script src="{{ asset('assets/js/jquery.maskedinput.min.js') }}"></script>

    <script src="{{ asset('assets/js/text-in-unicode.min.js') }}"></script>

    <!-- pace js -->
    <script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/jquery.table2excel.js') }}"></script>

    <script>

        $('#btnExpExcel').click(function() {
    var fileName = $(this).val();
    if(fileName == ''){
        fileName = 'download-report'
    }

    $("#ExportExcel").table2excel({
        exclude: ".noExl",
        name: "Worksheet Name",
        filename: fileName + ".xls",
        fileext: ".xls",
        exclude_links: true
    });
})

function exportToExcel(tableID){
    $("#"+tableID).table2excel({
        exclude: ".noExl",
        name: tableID,
        filename: tableID + ".xls",
        fileext: ".xls",
        exclude_links: true
    });
}
    </script>
@yield('scripts')

</body>

</html>
