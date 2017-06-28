
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>True Money Myanmar </title>

    <!-- Bootstrap -->
    <link href="/libs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="/libs/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="/libs/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="/libs/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="/libs/gentelella/css/custom.min.css" rel="stylesheet">
    <style type="text/css">
    #logo-container img {
      width: 100%; height: auto;
    }
    #footer
    {  
       position:absolute;
       bottom:0;
       width:100%;
       height:7%;   /* Height of the footer */
       background:#6cf;
       background-color:#FF6600;
       /*border:2px solid orange;*/
       margin-left: 0px;
       color:black;
    }



/*#imginthefooter img {       
    background: url(/images/banner1.jpg) no-repeat;
    width:100%;
    height:auto;
    top: -108px;   
    right: 150px; 
    position: absolute;
}​​​​​​​​​*/

    </style>
  </head>
 <!--  <div id="header">
  m
  </div> -->
  <div id="logo-container"><img src="/images/banner1.jpg" alt="" /></a></div>
  
  <body class="login" >
    <div>
      

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
              <h1>Login Form</h1>
              {{ csrf_field() }}
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group{{ $errors->has('factory_cardno') ? ' has-error' : '' }}">
                            <br>
                            <!-- <label for="factory_cardno" class="col-md-4 col-xs-6 col-sm-4 control-label">Name</label> -->
                            <div>
                                <input id="factory_cardno" type="text" class="form-control" name="factory_cardno" value="{{ old('factory_cardno') }}" required placeholder='Agent ID'>
                                @if ($errors->has('factory_cardno'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('factory_cardno') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group{{ $errors->has('pinno') ? ' has-error' : '' }}">
                            <!-- <label for="pinno" class="col-md-4 col-xs-6 col-sm-4 control-label">Password</label> -->

                            <div>
                                <input id="pinno" type="password" class="form-control" name="pinno" required placeholder='Password'>

                                <!-- @if ($errors->has('pinno'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('pinno') }}</strong>
                                    </span>
                                @endif -->

                                    @if (Session::has('message'))
                                       
                                       <span>
                                         <strong>{{ Session::get('message') }}</strong>
                                       </span>
                                    @endif
                            </div>
                        </div>
              <div>
                <button type="submit" class="btn btn-primary">
                                    Login
                                </button>
              </div>

              <div class="clearfix"></div>
            </form>
          </section>
        </div>

        
      </div>
    </div>
      <footer  id ="footer">2017 @ TrueMoney Myanmar Co., Ltd</footer>
    </body>



</html>
