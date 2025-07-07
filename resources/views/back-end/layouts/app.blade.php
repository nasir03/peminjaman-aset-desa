<!DOCTYPE html>
<html lang="en">

<!-- Header -->
@include('back-end.partials.header')
<!-- End of Header -->

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        @include('back-end.partials.sidebar')
        <!-- End of Sidebar -->
        
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                @include('back-end.partials.topbar')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            @include('back-end.partials.footer')
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Script-->
    @include('back-end.partials.scripts')
    <!-- End of Script -->
<audio id="notifSound" src="{{ asset('audio/notif.mp3') }}" preload="auto"></audio>

<script>
    // Cek jika ada badge notifikasi baru
    document.addEventListener("DOMContentLoaded", function () {
        let badge = document.querySelector('.badge-counter');
        if (badge && parseInt(badge.innerText) > 0) {
            document.getElementById('notifSound').play().catch(function(e){
                console.log("Suara tidak bisa diputar otomatis karena aturan browser.");
            });
        }
    });
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/fontawesome.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/solid.min.css">

</body>
</html>