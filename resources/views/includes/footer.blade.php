<!-- Footer Start -->
<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                2020 - <script>
                    document.write(new Date().getFullYear())
                </script> &copy; by <a href="https://dreamcapvc.com">dreamcapvc</a>
            </div>
        </div>
    </div>
</footer>
<!-- end Footer -->

</div>

<!-- ============================================================== -->
<!-- End Page content -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Vendor js -->
<script src="{{ asset('js/vendor.min.js') }}"></script>

<!-- App js-->
<script src="{{ asset('js/app.min.js') }}"></script>

<script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datatable/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('toastr/toastr.min.js') }}"></script>


<script src="{{ asset('date-picker/jquery-ui.js') }}"></script>
<!-- Init js -->
<script src="{{ asset('js/validation/validation.js') }}"></script>
<!-- Plugins js-->
<script src="{{ asset('libs/flatpickr/flatpickr.min.js') }}"></script>
<!-- <script src="{{ asset('libs/clockpicker/bootstrap-clockpicker.min.js') }}"></script> -->
<script src="{{ asset('libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<!-- Init js-->
<!-- <script src="{{ asset('js/pages/form-pickers.init.js') }}"></script> -->
<script>
    toastr.options.preventDuplicates = true;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>
<!-- custom js  -->