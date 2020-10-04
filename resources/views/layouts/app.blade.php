<!DOCTYPE html>
<html lang="en">

<head>
    @include('common.meta')

    {{-- CSS Import --}}
    <link rel="stylesheet" href="{{ asset('css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @yield('css')

    @include('common.favicon')


    {{-- Title --}}
    <title>@yield('title') | Dinkes Melawi</title>
</head>

<body>
    <div class="container-scroller">
        {{-- Navbar Component --}}
        @include('components.navbar')
        <div class="container-fluid page-body-wrapper">

            {{-- Sidebar Component --}}
            @include('components.sidebar')
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-primary text-white mr-2">
                                <i class="mdi mdi-home"></i>
                            </span> @yield('title') </h3>
                        @yield('add')
                    </div>
                    @yield('content')
                </div>

                {{-- Footer --}}
                @include('components.footer')
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('js/chart.min.js') }}"></script>
    <script src="{{ asset('js/off-canvas.js') }}"></script>
    <script src="{{ asset('js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('js/data.js') }}"></script>
    <script src="{{ asset('js/todolist.js') }}"></script>

    @include('components.swal')

    @yield('js')
    @stack('scripts')

</body>

</html>
