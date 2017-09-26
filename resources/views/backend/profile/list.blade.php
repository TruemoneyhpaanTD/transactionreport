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
       /*   width: 350px;
          height: 197px;*/

          width: 450px;
          height: 240px;
      }


    </style>
@endsection

@section('content')
<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
            </div>

            <div class="clearfix"></div>

            <div class="row">
             
                  
                  <div class="x_content">

                    <div class="x_panel">
               

                  <div class="row">

                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2> Personal Details </h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                          <table class="table table-striped">
                           
                            <tbody>
                              <tr>
                                <th width="30%"> Agent Name </th>
                                <th> : </th>
                                <td width="70%"> {{ $editdata->agent_name }}</td>
                              </tr>
                              <tr>
                                <th> Shop Name  </th>
                                <th> : </th>
                                <td> {{ $editdata->short_name }}</td>
                              </tr>
                              <tr>
                                <th> NRC  </th>
                                <th> : </th>
                                <td> {{ $editdata->nrc }}</td>
                              </tr>
                              
                              <tr>
                                <th> Township  </th>
                                <th> : </th>
                                <td> {{ $editdata->township }}</td>
                              </tr>
                              <tr>
                                <th> Phone No </th>
                                <th> : </th>
                                <td> {{ $editdata->phone_no }}</td>
                              </tr>
                              <tr>
                                <th> Address  </th>
                                <th> : </th>
                                <td> {{ $editdata->address }}</td>
                              </tr>
                            </tbody>
                          </table>

                        </div>
                      </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="x_panel"  style="height:344px;">
                        <div class="x_title">
                          <h2> Account Details </h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                          <table class="table table-striped">
                           
                            <tbody>
                              <tr>
                                <th width="30%"> Agent Type </th>
                                <th> : </th>
                                <td width="70%"> {{ $editdata->description }}</td>
                              </tr>
                              <tr>
                                <th> Card Number </th>
                                <th> : </th>
                                <td> {{ $editdata->AgentCard }}</td>
                              </tr>
                              <tr>
                                <th> Terminal </th>
                                <th> : </th>
                                <td> {{ $editdata->Terminal }}</td>
                              </tr>
                              <tr>
                                <th> Version  </th>
                                <th> : </th>
                                <td> {{ $editdata->Version }}</td>
                              </tr> 
                              <tr>
                                <th> Start Date  </th>
                                <th> : </th>
                                <td> {{ $editdata->start_date ? date('d-m-Y', strtotime($editdata->start_date)) : ""}}</td>
                              </tr>
                              <tr>
                                <th> Balance  </th>
                                <th> : </th>
                                <!-- <td> {{ $editdata->balance_amount.' MMK' }}</td> -->
                                <td> {{ number_format($editdata->balance_amount) }} MMK</td>
                                <!-- number_format(1234) -->
                              </tr>
                            
                            </tbody>
                          </table>

                        </div>
                      </div>
                    </div>

                  </div>


                  <div class="row">

                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="x_panel"  style="height:401px;">
                        <div class="x_title">
                          <h2> POS Details </h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                          <table class="table table-striped">
                           
                            <tbody>
                              <tr>
                                <th width="30%"> SIM </th>
                                <th> : </th>
                                <td width="70%"> {{ $editdata->sim}}</td>
                              </tr>
                              <tr>
                                <th> Operator  </th>
                                <th> : </th>
                                <td> {{ $editdata->operator}}</td>
                              </tr>
                              <tr>
                                <th> Expire Date  </th>
                                <th> : </th>
                                <td> {{ $editdata->expire_date ? date('d-m-Y', strtotime($editdata->expire_date)) : ""}}</td>
                              </tr>
                              <tr>
                                <th> Check Date  </th>
                                <th> : </th>
                                <td> {{ $editdata->last_check_date ? date('d-m-Y', strtotime($editdata->last_check_date)) : ""}}</td>
                              </tr>
                              
                              <tr>
                                <th> Balance    </th>
                                <th> : </th>
                                <!-- <td> {{ $editdata->last_balance.' MMK' }} </td> -->
                                <td> {{ number_format($editdata->last_balance) }} MMK</td>

                              </tr>
                              
                            </tbody>
                          </table>

                        </div>
                      </div>
                    </div>



                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <div class="x_panel">
                        <div class="x_title">
                          <h2> Location </h2>
                          <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                          <table class="table table-striped">
                           
                            <tbody>
                            <tr>
                                <th width="30%"> Location    </th>
                                <th> : </th>
                                <td width="70%"> {{ $editdata->location }}<input class="form-control" id="location" type="hidden" value="{{ $editdata->location }}"></td>
                            </tr>
                              
                            <div id="map"></div>
                            </tbody>
                          </table>

                        </div>
                      </div>
                    </div>
                
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
<script>
     function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          // zoom: 13,
          minZoom: 15,
          center: {
            lat: {{ explode(', ', $editdata->location)[0] }}, 
            lng: {{ explode(', ', $editdata->location)[1] }}
          }
        });
        var geocoder = new google.maps.Geocoder;
        var infowindow = new google.maps.InfoWindow;

      


          geocodeLatLng(geocoder, map, infowindow);
        
    }

     function geocodeLatLng(geocoder, map, infowindow) {
        var input = document.getElementById('location').value;
        var latlngStr = input.split(', ', 2);
        var latlng = {lat: parseFloat(latlngStr[0]), lng: parseFloat(latlngStr[1])};
        geocoder.geocode({'location': latlng}, function(results, status) {
          if (status === 'OK') {
            if (results[1]) {
              map.setZoom(11);
              var marker = new google.maps.Marker({
                position: latlng,
                map: map
              });
              infowindow.setContent(results[1].formatted_address);
              infowindow.open(map, marker);
            } else {
              window.alert('No results found');
            }
          } else {
            window.alert('Geocoder failed due to: ' + status);
          }
        });
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