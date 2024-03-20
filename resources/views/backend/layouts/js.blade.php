<script src="{{ asset('backend/admin1/js/jquery.min.js') }}"></script>
<script src="{{ asset('backend/admin1/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('backend/admin1/js/scrollbar.min.js') }}"></script>
<script src="{{ asset('backend/admin1/js//toastr.min.js') }}"></script>
<script>
       toastr.options = {
        "closeButton": true,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "200",
        "hideDuration": "4000",
        "timeOut": "2000",
        "extendedTimeOut": "200",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    @if(Session::has('success'))
        toastr.success("{{ Session::get('success') }}");
    @endif
    @if(Session::has('error'))
        toastr.error("{{ Session::get('error') }}");
    @endif
    @if(Session::has('info'))
        toastr.info("{{ Session::get('info') }}");
    @endif
    @if(Session::has('warning'))
        toastr.warning("{{ Session::get('warning') }}");
    @endif

</script>