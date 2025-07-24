<!-- Bootstrap core JavaScript-->
<script src="{{ asset('assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset("assets/vendor/bootstrap/js/bootstrap.bundle.min.js") }}"></script>


<!-- Core plugin JavaScript-->
<script src="{{ asset("assets/vendor/jquery-easing/jquery.easing.min.js") }}"></script>



<!-- Custom scripts for all pages-->
<script src="{{ asset('assets/js/sb-admin-2.min.js') }}"></script>

<script>



    document.addEventListener('DOMContentLoaded', function () {
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif
        @if(session('warning'))
        toastr.info("{{ session('warning') }}");
        @endif

        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif
        @if($errors->any())
        @foreach($errors->all() as $error)
        toastr.error("{{ $error }}");
        @endforeach
        @endif
    });
</script>
