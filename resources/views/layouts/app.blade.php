@include('layouts.top')

<body>
<div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

        @include('partials.menu')

        <!-- Layout container -->
        <div class="layout-page">

            @include('partials.header')

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    @yield('breadcrumb')

                    @yield('content')
                </div>
                @include('partials.footer')
                <div class="content-backdrop fade"></div>
            </div>
        </div>
    </div>
    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
</div>

@include('layouts.bottom')

@yield('datatable_script')

@yield('scripts')

@include('layouts.notification_alerts')
</body>
</html>
