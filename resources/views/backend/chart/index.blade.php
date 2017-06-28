@extends('layouts.app')

@section('css')
   <link href="/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
   <!-- Datatables -->
   <link href="/libs/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
   <link href="/libs/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">
   <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
          width: 350px;
          height: 250px;
      }
        /*#aa{
          background-color: blue;
          margin-left: 30px;
        }*/

    </style>
@endsection

@section('content')
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-xs-12 widget_tally_box">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2> MEC Taken </h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div id="graph_bar" style="width:100%; height:200px;"></div>
                      <div class="col-xs-12 bg-white progress_summary">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12 widget_tally_box">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2> Ooredoo Taken </h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div id="graph_bar_ooredoo" style="width:100%; height:200px;"></div>
                      <div class="col-xs-12 bg-white progress_summary">
                      </div>
                    </div>
                  </div>
                </div>

                 <div class="col-md-4 col-sm-6 col-xs-12 widget_tally_box">
                  <div class="x_panel">
                    <div class="x_title">
                      <h2> E-Pin Taken </h2>
                      <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                      <div id="graph_bar_epin" style="width:100%; height:200px;"></div>
                      <div class="col-xs-12 bg-white progress_summary">
                      </div>
                    </div>
                  </div>
                </div>

            </div>     
          </div>
        </div>
          
        
        <!-- /page content -->
@endsection

@section('js')
  <script src="/libs/raphael/raphael.min.js"></script>
<script src="/libs/morris.js/morris.min.js"></script>
<script>
  $(document).ready(function(){

    Morris.Bar({
      element: 'graph_bar',
      data: [
        { "period": "10000", "MEC": {{ $mec_10000 }} }, 
        { "period": "5000", "MEC": {{ $mec_5000 }} }, 
        { "period": "3000", "MEC": {{ $mec_3000 }} }, 
        { "period": "1000", "MEC": {{ $mec_1000 }} }, 
      ],
      xkey: 'period',
      hideHover: 'auto',
      barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
      ykeys: ['MEC'],
      labels: ['MEC'],
      barRatio: 0.4,
      xLabelAngle: 35,
      resize: true
    });

    Morris.Bar({
      element: 'graph_bar_ooredoo',
      data: [
        { "period": "20000", "Ooredoo": {{ $ooredoo_20000 }} }, 
        { "period": "10000", "Ooredoo": {{ $ooredoo_10000 }} }, 
        { "period": "5000", "Ooredoo": {{ $ooredoo_5000 }} }, 
        { "period": "3000", "Ooredoo": {{ $ooredoo_3000 }} }, 
        { "period": "1000", "Ooredoo": {{ $ooredoo_1000 }} }, 
      ],
      xkey: 'period',
      hideHover: 'auto',
      barColors: ['#26B99A', '#34495E', '#ACADAC', '#3498DB'],
      ykeys: ['Ooredoo'],
      labels: ['Ooredoo'],
      barRatio: 0.4,
      xLabelAngle: 35,
      resize: true
    });
    
  })

</script>
@endsection