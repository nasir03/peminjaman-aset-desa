<!-- Footer -->
  <div class="container my-auto py-2">
    <div class="copyright text-center my-auto">
      <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - by
        <b><a href="https://www.instagram.com/nasir_allfin?igsh=MXBidHh1czIxaGFhYg==" target="_blank">nasirallfin</a></b>
      </span>
    </div>
  </div>
</footer>
<!-- Footer -->

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Modal Logout -->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
  aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabelLogout">Ohh Tidakk!</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>"Selamat jalan! Ingat, pintu selalu terbuka untuk Anda."</p>
      </div>
    <div class="modal-footer">
    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-primary">Logout</button>
    </form>
</div>

    </div>
  </div>
</div>