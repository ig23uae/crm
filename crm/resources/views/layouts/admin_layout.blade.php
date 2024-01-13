<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Админ панель - @yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('panel/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('/panel/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/panel/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('/panel/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('panel/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('panel/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('panel/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('panel/plugins/summernote/summernote-bs4.min.css')}}">
    <!-- Lightbox -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css" integrity="sha512-Velp0ebMKjcd9RiCoaHhLXkR1sFoCCWXNp6w4zj1hfMifYB5441C+sKeBl/T/Ka6NjBiRfBBQRaQq65ekYz3UQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">


    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{route('admin_index')}}" class="nav-link">Админ панель</a>
                @else
                    <a href="{{ route('panel') }}" class="nav-link">Главная</a>
                @endif
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{route('cars_index', 'all')}}" class="nav-link">Интерфейс продавцов</a>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=random&size=160" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{route('admin_index')}}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Главная
                                </p>
                            </a>
                        @else
                            <a href="{{ route('panel') }}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Главная
                                </p>
                            </a>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-car"></i>
                            <p>
                                Машины
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('add_car')}}" class="nav-link">
                                    <i class="nav-icon fas fa-solid fa-plus"></i>
                                    <p>Добавить авто</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('cars_index', 'available')}}" class="nav-link">
                                    <i class="nav-icon fas fa-solid fa-circle"></i>
                                    <p>Авто в наличии</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('cars_index', 'sold')}}" class="nav-link">
                                    <i class="nav-icon fas fa-solid fa-circle"></i>
                                    <p>Проданные авто</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('cars_index', 'all')}}" class="nav-link">
                                    <i class="nav-icon fas fa-solid fa-circle"></i>
                                    <p>Все авто</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-solid fa-file-invoice-dollar"></i>
                            <p>
                                Сделки
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('create_sale')}}" class="nav-link">
                                    <p>
                                        <i class="nav-icon fas fa-solid fa-plus"></i>
                                        Создать сделку
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('sales')}}" class="nav-link">
                                    <p>Сделки</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('sales', ['status' => 'booked']) }}" class="nav-link">
                                    <p>Сделки в процессе</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('sales', ['status' => 'sold']) }}" class="nav-link">
                                    <p>Завершенные сделки</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <p>Изменить сделку</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item fixed-bottom border-top border-secondary" style="width: 13%">
                        <a class="nav-link" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Выход') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('main_content')
    </div>
    <!-- /.content-wrapper -->
    <footer class="main-footer">
        CRM
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0.0
        </div>
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('../panel/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('../panel/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('../panel/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('../panel/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('../panel/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('../panel/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('../panel/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('../panel/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('../panel/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('../panel/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('../panel/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('../panel/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('../panel/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('../panel/dist/js/adminlte.js') }}"></script>
<!-- file_input -->
<script src="{{ asset('../panel/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- create_sale -->
<script>
    $(function (){
        bsCustomFileInput.init();
    });
</script>
<!-- ekko lightbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.min.js" integrity="sha512-Y2IiVZeaBwXG1wSV7f13plqlmFOx8MdjuHyYFVoYzhyRr3nH/NMDjTBSswijzADdNzMyWNetbLMfOpIPl6Cv9g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('../panel/dist/js/pages/dashboard.js')}}"></script>
<script>$(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
@yield('scripts')
</body>
</html>
