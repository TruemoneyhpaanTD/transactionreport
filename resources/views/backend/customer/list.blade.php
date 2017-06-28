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
    </style>
@endsection

@section('content')
<!-- page content -->
   <div class="right_col" role="main">
      <div class="">
         <div class="page-title">
              <div class="title_left">
                <!-- <h3>User Profile</h3> -->
              </div>
         </div>
         <div class="row">
            
            <div class="col-md-12 col-sm-12 col-xs-12">
               <div class="x_panel">
                    <div class="x_title">
                        <h3>User Profile</h3>
                    <div class="clearfix"></div>
                    <div class="panel-body">
                      <form>
                <div class="form-group">
                  <label for="agentName">Agent Name</label>
                  <input type="text" value="{{ $editdata->agent_name }}" class="form-control" id="agentName">
                </div>
                <div class="form-group">
                  <label for="shortName">Short Name</label>
                  <input type="text" value="{{ $editdata->short_name }}" class="form-control" id="shortName">
                </div>
                <div class="form-group">
                  <label for="address">address</label>
                  <input type="text" value="{{ $editdata->address }}" class="form-control" id="address">
                </div>
                <div class="form-group">
                  <label for="township">Township</label>
                  <input type="township" value="{{ $editdata->township }}" class="form-control" id="township">
                </div>
                <div class="form-group">
                  <label for="mobileNo">Mobile No</label>
                  <input type="text" value="{{ $editdata->phone_no }}" class="form-control" id="mobileNo">
                </div>
                <div class="form-group">
                  <label for="nrc">NRC</label>
                  <input type="text" value="{{ $editdata->nrc }}" class="form-control" id="nrc">
                </div>
                <div class="form-group">
                  <label for="balanceAmount">Balance Amount</label>
                  <input type="text" value="{{ $editdata->balance_amount }}" class="form-control" id="balanceAmount">
                </div> 
              <div class="form-group">
                            <div id="map"></div>
                        </div>

              <div class="form-group">
                            <label for="">Location</label>
                            <input type="text" class="form-control input-sm" name="location" id="location" value="{{ $lat }}''{{ $lng }}" onkeyup="initialize();">
                </div>
              </form>
                  </div>
                </div>
            </div>
         </div>
      </div>  
   </div>
   <!-- /page content -->
@endsection

@section('js')
<script>
    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            center: {
              lat: {{ $lat }}, 
              lng: {{ $lng }}
            },
            zoom: 15
        });
        var infoWindow = new google.maps.InfoWindow({map: map});

        // You can use this code if you want to show current location as default.
        // Try HTML5 geolocation.
        // if (navigator.geolocation) {
        //     navigator.geolocation.getCurrentPosition(function(position) {
        //         var pos = {
        //             lat: position.coords.latitude,
        //             lng: position.coords.longitude
        //         };
            
        //         $("#location").val(position.coords.latitude+' '+position.coords.longitude);
        //         infoWindow.setPosition(pos);
        //         infoWindow.setContent('Location found. '+ position.coords.latitude+' '+position.coords.longitude);
        //         map.setCenter(pos);
        //     }, function() {
        //         handleLocationError(true, infoWindow, map.getCenter());
        //     });
        // } else {
        //     // Browser doesn't support Geolocation
        //     handleLocationError(false, infoWindow, map.getCenter());
        // }
    }

    function initialize() {
        var lat = $("#location").val().split(" ")[0];
        var lng = $("#location").val().split(" ")[1];
        var myCenter = new google.maps.LatLng(lat, lng);
        var map;
        var marker;
        var mapProp = {
            center : myCenter,
            zoom : 10,
            mapTypeId : google.maps.MapTypeId.ROADMAP
        };
        
        map = new google.maps.Map(document.getElementById('map'),mapProp);
        
        marker = new google.maps.Marker({
            position : myCenter,
        });
        marker.setMap(map);
    }


    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ? 'Error: The Geolocation service failed.' : 'Error: Your browser doesn\'t support geolocation.');
    }
</script>

<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCyB6K1CFUQ1RwVJ-nyXxd6W0rfiIBe12Q&libraries&callback=initMap">
</script>
@endsection