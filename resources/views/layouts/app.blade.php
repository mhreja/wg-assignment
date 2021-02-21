<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">

    <!-- Custom styles for DataTables -->
    <link href="{{asset('vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">

    @yield('head')
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('user.index')}}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{config('app.name')}}</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item @if(Route::current()->getName() == 'user.index') active @endif">
                <a class="nav-link" href="{{route('user.index')}}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item @if(Route::current()->getName() == 'product.index') active @endif">
                <a class="nav-link" href="{{route('product.index')}}">
                    <i class="fab fa-fw fa-product-hunt"></i>
                    <span>Products</span></a>
            </li>


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>


                    <div class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100">
                        <span class="greetings text-success font-weight-bold"></span>
                    </div>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow mr-4 d-sm-none">
                            <!-- Show Greetings on Mobile -->
                            <span class="greetings text-success font-weight-bold"
                                style="height: 4.375rem;display: flex;align-items: center;padding: 0 .75rem;"></span>
                        </li>



                        <li class="nav-item dropdown no-arrow d-none d-sm-block">
                            <span class="time text-danger"
                                style="height: 4.375rem;display: flex;align-items: center;padding: 0 .75rem;"><i
                                    class="fa fa-clock"></i></span>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                @yield('content')

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; {{ config('app.name', 'Laravel') }} {{date('Y')}}</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('js/sb-admin-2.min.js')}}"></script>

    <!-- DataTables -->
    <script src="{{asset('vendor/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>

    <!-- DataTables -->
    <script src="{{asset('js/demo/datatables-demo.js')}}"></script>

    <!-- GrowlNotification -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-growl/1.0.0/jquery.bootstrap-growl.min.js"
        integrity="sha512-pBoUgBw+mK85IYWlMTSeBQ0Djx3u23anXFNQfBiIm2D8MbVT9lr+IxUccP8AMMQ6LCvgnlhUCK3ZCThaBCr8Ng=="
        crossorigin="anonymous"></script>


    <!-- Notification -->
    @if(Session('success'))
    <script>
        $.bootstrapGrowl("{{Session('success')}}" , {
            ele: "body", //On which Element to Append
            type: "success", //This is for color
            offset: {from: "top", amount:20}, //Top or Bottom
            align: "right",
            width: 250, 
            delay: 800,
            allow_dismiss: true,
        });
    </script>
    @endif


    @if(Session('danger'))
    <script>
        $.bootstrapGrowl("{{Session('danger')}}" , {
            ele: "body", //On which Element to Append
            type: "danger", //This is for color
            offset: {from: "top", amount:20}, //Top or Bottom
            align: "right",
            width: 250, 
            delay: 800,
            allow_dismiss: true,
        });
    </script>
    @endif



    <script>
        $(document).ready(function() {
            function dateTime() {
                var ndate = new Date();
                var hr = ndate.getHours();
                var m = ndate.getMinutes();
                var s = ndate.getSeconds();
                
                if (hr < 12)
                {
                    greet = 'Good Morning';
                }
                else if (hr >= 12 && hr <= 17)
                {
                    greet = 'Good Afternoon';
                }
                else if (hr >= 17 && hr <= 24)
                {
                    greet = 'Good Evening';
                }            

                if (s < 10) {
                s = "0" + s;
                }

                if (m < 10) {
                m = "0" + m;
                }

                $(".greetings").html(greet);
                $('.time').html('<i class="fa fa-clock"></i>&nbsp'+hr + ":" + m + ":" + s);
            }

          setInterval(dateTime, 1000);
        });
    </script>




    @yield('scripts')

</body>

</html>