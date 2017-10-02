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
       height:10%;   /* Height of the footer */
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
            <form class="form-horizontal" role="form" method="POST" action="/login">
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
    
      <footer id="footer"> 
      <div class="col-md-6 col-lg-6">2017 @ TrueMoney Myanmar Co., Ltd </div> 
      <!-- <div class="col-md-6 col-lg-6"> 
      <table title="CLICK TO VERIFY: This site uses a GlobalSign SSL Certificate to secure your personal information." width="125" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><script src="//ssif1.globalsign.com/SiteSeal/siteSeal/siteSeal/siteSeal.do?p1=marchent.truemoney.com.mm&amp;p2=SZ110-45&amp;p3=image&amp;p4=en&amp;p5=V0022&amp;p6=S001&amp;p7=https"></script><span> <a id="aa" href="javascript:ss_open_sub()"><img name="ss_imgTag" src="//ssif1.globalsign.com/SiteSeal/siteSeal/siteSeal/siteSealImage.do?p1=marchent.truemoney.com.mm&amp;p2=SZ110-45&amp;p3=image&amp;p4=en&amp;p5=V0022&amp;p6=S001&amp;p7=https&amp;deterDn=" alt="Please click to see profile." oncontextmenu="return false;" galleryimg="no" border="0"></a></span><span id="ss_siteSeal_fin_SZ110-45_image_en_V0022_S001"></span><script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_110-45_en_blue.js"></script></td></tr></tbody></table>  <div>
        
      </div></div> -->
      <div class="col-md-6 col-lg-6" >
               <table width=125 border=0 cellspacing=0 cellpadding=0 title="CLICK TO VERIFY: This site uses a GlobalSign SSL Certificate to secure your personal information." ><tr><td><span id="ss_img_wrapper_gmogs_image_110-45_en_blue"><a href="https://www.globalsign.com/" target=_blank title="GlobalSign Site Seal" rel="nofollow"><img alt="SSL" border=0 id="ss_img" src="//seal.globalsign.com/SiteSeal/images/gs_noscript_110-45_en.gif"></a></span><script type="text/javascript" src="//seal.globalsign.com/SiteSeal/gmogs_image_110-45_en_blue.js"></script></td></tr></table> 
              <!-- <p style="text-align:center;"> hi</p> -->
      </div>
      </footer>
    </body>



</html>
