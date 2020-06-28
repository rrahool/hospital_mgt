
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 ">
                <div class="copyright-text">
                    <p>CopyRight © 2018 | ISRATTS Technologies </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="{{ asset('admin/js/jquery.min.js') }} "></script>

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('admin/js/bootstrap.min.js') }}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('admin/js/metisMenu.min.js') }}"></script>
@if(\Request::is('dashboard')){
<!-- Morris Charts JavaScript -->
<script src="{{ asset('admin/js/raphael.min.js') }}"></script>
<script src="{{ asset('admin/js/morris.min.js') }}"></script>
<script src="{{ asset('admin/js/morris-data.js') }}"></script>
}
@endif

{{--data table--}}
<script src="{{ asset('admin/js/dataTables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin/js/dataTables/dataTables.bootstrap.min.js') }}"></script>



<!-- Custom Theme JavaScript -->
<script src="{{ asset('admin/js/startmin.js') }}"></script>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });


</script>


</body>
</html>