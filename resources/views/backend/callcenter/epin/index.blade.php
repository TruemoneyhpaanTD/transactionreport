@extends('layouts.app')

@section('css')
   <link href="/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
   <!-- Datatables -->
   <link href="/libs/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

@endsection
        <!-- /top navigation -->
@section('content')
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>EPin Agent Report</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <br>
                  <div class="x_content">
                     
                          <div class="row">
                            <!-- <div class="col-sm-6">
                                <div class="form-group">
                                  <label class="col-sm-4 control-label col-lg-4"> Agent Card </label>
                                    <div class="col-lg-8">
                                      <input id="agentCard" class="form-control" type="text" name="agentCard" required="required" value="" autocomplete="off"> 
                                    </div>
                              </div>
                            </div> -->
                          <!--   <div class="col-sm-6">
                              <div class="form-group">
                                  <label class="col-sm-4 control-label col-lg-4"> Operators </label>
                                  <div class="col-lg-8">
                                      <select class="form-control" name="operator">
                                          <option value="mpt" label="MPT"> MPT </option>
                                          <option value="ALL" label="ALL"> ALL </option>
                                          <option value="telenor" label="Telenor"> Telenor </option>
                                          <option value="mec" label="MEC"> MEC </option>
                                          <option value="ooredoo" label="Ooredoo"> Ooredoo </option>
                                      </select>
                                  </div>
                              </div>
                            </div> -->
                          </div>
                          <br>

                          <div class="row">
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label class="col-sm-4 control-label col-lg-4"> From: </label>
                                    <div class="col-lg-8">
                                      <input id="fromdate" class="form-control" value="" name="from"> 
                                    </div>
                                </div>
                              </div>
                              <div class="col-sm-6">
                                <div class="form-group">
                                  <label class="col-sm-4 control-label col-lg-4"> To: </label>
                                    <div class="col-lg-8">
                                      <input id="todate" class="form-control" value="" name="to"> 
                                    </div>
                                </div>
                              </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                  <label class="col-sm-4 control-label col-lg-4">  </label>
                                    <div class="col-lg-8">
                                      <button id="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                              </div>
                          </div>
                      
                  </div>


                    <div class="x_content">                     
                     <div class="table-responsive">
                         <table class="table table-striped table-bordered" id="users-table">
                             <thead>
                                 <tr>
                                     <th>Address</th> 
                                     <!-- <th>SaleActivity</th>  -->
                                     <th>Province</th> 
                                 </tr>
                             </thead>
                         </table>
                     </div>
                     <!-- /.table-responsive -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
@endsection

@section('js')
<script src="/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<!-- Datatables -->
    <script src="/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/libs/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="/libs/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/libs/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="/libs/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/libs/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/libs/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/libs/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="/libs/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/libs/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="/libs/datatables.net-scroller/js/datatables.scroller.min.js"></script>
<script>
$(document).ready(function(){
    $('#fromdate').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
        autoclose: true
    });
    $('#todate').datepicker({
        format: 'yyyy-mm-dd',
        startDate: '2015-08-07',
      
        autoclose: true
    });
})

$(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var oTable = $('#users-table').DataTable({
        dom: "<'row'<'col-xs-12'<'col-xs-6'l><'col-xs-6'p>>r>"+
            "<'row'<'col-xs-12't>>"+
            "<'row'<'col-xs-12'<'col-xs-6'i><'col-xs-6'p>>>",
        processing: true,
        serverSide: true,
        ajax: {
            url: '/agent',
             data: function (d) {
                d.start_date = $('#fromdate').val();
                d.end_date = $('#todate').val();
            }
        },
        columns: [
            {data: 'address', name: 'address'},
            // {data: 'saleactivities', name: 'saleactivities'},
            {data: 'province', name: 'province'},
            
        ]
    });

    $('#submit').on('click', function() {
        oTable.draw();
    });
});
</script>
@endsection