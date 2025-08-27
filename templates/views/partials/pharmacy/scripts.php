<!-- jQuery -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="<?= BASE_URL; ?>assets/dist/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/moment/moment.min.js"></script>
<script src="<?= BASE_URL; ?>assets/dist/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script
    src="<?= BASE_URL; ?>assets/dist/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= BASE_URL; ?>assets/dist/js/adminlte.js"></script>
<!-- Toastr -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/toastr/toastr.min.js"></script>

<script src="<?= BASE_URL; ?>assets/dist/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<!-- Select2 -->
<script src="<?= BASE_URL; ?>assets/dist/plugins/select2/js/select2.full.min.js"></script>

<!-- Date range picker-->
<script src="<?= BASE_URL; ?>assets/dist/plugins/daterangepicker/daterangepicker.js"></script>

<script src="<?= BASE_URL; ?>assets/dist/plugins/inputmask/jquery.inputmask.min.js"></script>

<script>
    $(function () {
        bsCustomFileInput.init();

        //Initialize Select2 Elements
        $('.select2').select2({
            theme: 'bootstrap4'
        });

        $('.date-range').daterangepicker({
            format: 'Y-m-d'
        });

        //Money
        $('.currency-mask').inputmask({
            alias: 'currency'
        });

    });
</script>