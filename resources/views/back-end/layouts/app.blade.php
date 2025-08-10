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

    <!-- ========== SUARA NOTIFIKASI PEMINJAMAN ========== -->
    <audio id="notifSound" src="{{ asset('audio/notif.mp3') }}" preload="auto"></audio>
    <script>
        function playNotifSound() {
            const audio = document.getElementById("notifSound");
            if (audio) {
                audio.currentTime = 0;
                audio.volume = 1.0;
                audio.play().catch((error) => {
                    console.warn("Gagal memutar suara:", error);
                });
            }
        }

        function checkNewNotifications() {
            fetch("{{ route('cek.notifikasi.baru') }}")
                .then(response => response.json())
                .then(data => {
                    const jumlahBaru = parseInt(data.jumlah);
                    const jumlahLama = parseInt(sessionStorage.getItem("lastNotifCount") || "0");

                    if (jumlahBaru > jumlahLama) {
                        console.log("🔔 Notifikasi baru terdeteksi!");
                        playNotifSound();
                    }
                    sessionStorage.setItem("lastNotifCount", jumlahBaru);
                })
                .catch(error => console.error("Gagal mengambil notifikasi:", error));
        }

        document.addEventListener("click", function unlockNotifAudio() {
            const audio = document.getElementById("notifSound");
            if (audio) {
                audio.play().then(() => {
                    audio.pause();
                    console.log("✅ Audio notifikasi siap diputar.");
                    document.removeEventListener("click", unlockNotifAudio);
                }).catch((e) => console.log("⚠️ Autoplay diblokir:", e));
            }
        });

        document.addEventListener("DOMContentLoaded", function () {
            checkNewNotifications();
            setInterval(checkNewNotifications, 10000);
        });
    </script>

    

    <!-- FontAwesome (Opsional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/fontawesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/solid.min.css">

</body>
</html>
