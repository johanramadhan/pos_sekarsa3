<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/inc/TimeCircles.js') }}"></script>
<script>
  $("#CountDownTimer").TimeCircles({ time: { Days: { show: true }, Hours: { show: true } }});
</script>