@include('sweetalert::alert')

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{asset('vendor/dashmin/lib/chart/chart.min.js')}}"></script>
<script src="{{asset('vendor/dashmin/lib/easing/easing.min.js')}}"></script>
<script src="{{asset('vendor/dashmin/lib/waypoints/waypoints.min.js')}}"></script>
<script src="{{asset('vendor/dashmin/lib/owlcarousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('vendor/dashmin/lib/tempusdominus/js/moment.min.js')}}"></script>
<script src="{{asset('vendor/dashmin/lib/tempusdominus/js/moment-timezone.min.js')}}"></script>
<script src="{{asset('vendor/dashmin/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js')}}"></script>

<!-- Template Javascript -->
<script src="{{asset('vendor/dashmin/js/main.js')}}"></script>

@stack('roles')
@stack('data-nomor-surat')
@stack('data-pt')
@stack('data-user')

@stack('hari-ini')
@stack('kastem-admin')
@stack('kastem-modal')