
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@php
  $assetUrl = "public/templates";
@endphp
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Prophète Kacou Philippe &mdash; Portail du Ciel</title> 
        <meta name="description" content="">

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{asset($assetUrl.'/images/favicon.ico')}}">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{asset($assetUrl.'/styles/vendor/bootstrap.min.css')}}">
        <!-- Fonts -->
        <link rel="stylesheet" href="{{asset($assetUrl.'/fonts/et-lineicons/css/style.css') }}">
        <link rel="stylesheet" href="{{asset($assetUrl.'/fonts/linea-font/css/linea-font.css') }}">
        <link rel="stylesheet" href="{{asset($assetUrl.'/fonts/fontawesome/css/font-awesome.min.css') }}">
        <!-- Slider -->
        <link rel="stylesheet" href="{{asset($assetUrl.'/styles/vendor/slick.css') }}">
        <!-- Lightbox -->
        <link rel="stylesheet" href="{{asset($assetUrl.'/styles/vendor/magnific-popup.css') }}">
        <!-- Animate.css -->
        <link rel="stylesheet" href="{{asset($assetUrl.'/styles/vendor/animate.css') }}">


        <!-- Definity CSS -->
        <link rel="stylesheet" href="{{asset($assetUrl.'/styles/main.css') }}">
        <link rel="stylesheet" href="{{asset($assetUrl.'/styles/perso.css') }}">
        <link rel="stylesheet" href="{{asset($assetUrl.'/styles/responsive.css') }}">

        <!-- JS -->
        <script src="{{asset('templates/js/vendor/modernizr-2.8.3.min.js') }}"></script>
    </head>
    <body id="page-top">
        <!-- Google Tag Manager -->
        <noscript><iframe src="http://www.googletagmanager.com/ns.html?id=GTM-MH7TSF"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'http://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-MH7TSF');</script>
        <!-- End Google Tag Manager -->
        
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->



        <!-- ========== Preloader ========== -->

        <!-- <div class="preloader">
          <img src="{% static 'images/loader.svg' %}" alt="Loading...">
        </div> -->


    <!-- ========== Navigation ========== -->
<style>
  @media only screen and (max-width: 600px) {
    #brand{
      display: block;
    }
  }
</style>
<nav class="navbar navbar-default navbar-trans-dark  navbar-fixed-top navbar-static-top mega">
  <div class="container" style="min-width: 93% !important;">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

      <h1 class="hero-lead wow fadeInLeft" data-wow-duration="1.5s">
        <a  href="/fr-fr" style="display: block; color: #7b3d1a;">Matthieu25v6</a>
      </h1>
      <!-- Logo -->
      <!-- <a class="navbar-brand log" href=""><img src="{% static 'images/logo.png" alt="Definity - Logo"></a>  -->
    </div><!-- / .navbar-header -->

    <!-- Navbar Links -->
    <div id="navbar" class="navbar-collapse collapse navr" >
      <ul class="nav navbar-nav" style="margin-top: 0px !important;">
        <li class="dropdown">
        <!-- Accueil -->
        <li class="dropdown mg">
          <a href="/fr-fr" class="dropdown-toggle" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false" style="color:black">Accueil</a>
        <!-- / .dropdown-menu -->
        </li>
        <!-- / Accueil -->

        <!-- Prédications -->
        <li class="dropdown mg">
          <a href="/fr-fr/predications" class="dropdown-toggle" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false" style="color:black">Prédications</a>
        </li>
        <!-- / Prédications -->

        <!-- Adorations -->
        <li class="dropdown mg">
          <a href="/fr-fr/cantiques" class="dropdown-toggle" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false" style="color:black">Cantiques</a>
        </li>

        <!-- / Adorations -->

        <li class="dropdown mg">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false" style="color:black">Galéries<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="/fr-fr/galeries/photos" style="color:black">Photos</a></li>
            <li><a href="/fr-fr/galeries/videos" style="color:black">Videos</a></li>
          </ul>
        </li>
        <!-- / Galerie -->
        
        <!-- Médias 
        <li class="dropdown mg">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Médias<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="presses-lists">Presse écrites</a></li>
            <li><a href="emissions-radio">Emission radio</a></li>
            <li><a href="emissions-tv">emissions-tv</a></li>

          </ul>
        </li>
      / Médias -->


       

        <!-- Ressources 
        <li class="dropdown mg">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">Ressources<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="temoignages">Témoignages</a></li>
            <li><a href="actualites-lists">Actualités</a></li>
            <li><a href="pepites">Les pépites d'or</a></li>
            <li><a href="aides">Aides pour la lectures</a></li>
            <li><a href="logiciels">Logiciels</a></li>

          </ul>
        </li>
         / Ressources -->

         

        <!-- Le monde -->
        <li class="dropdown mega-fw mg">
          <a href="/fr-fr/assemblees" class="dropdown-toggle"  data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false" style="color:black">Le cri de minuit dans monde</a>
        <!-- / .dropdown-menu -->
        </li>
        <!-- / Le monde -->

        <!-- Contacts -->
        <li class="dropdown mg">
          <a href="/fr-fr/contacts" class="dropdown-toggle"  data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false" style="color:black">Contacts</a>
        <!-- / .dropdown-menu -->
        </li>
        <!-- / Contacts -->
      
       
      </ul>
      <!-- / .nav .navbar-nav -->
      

      <!-- Navbar Links Right -->
      <ul class="nav navbar-nav navbar-right" style="margin-top: 0px !important;">
        <li class="dropdown mg">
          <a href="" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="350" role="button" aria-haspopup="true" aria-expanded="false">FR<span class="caret"></span></a>
          <ul class="dropdown-menu">
            {{-- {% for item in langs %} 
            <li><a href="{% url 'index' item.initial %}">{{ item.initial }}</a></li>
            {% endfor %} --}}
            <li><a href="">fr</a></li>
            <li><a href="">es</a></li>
            <li><a href="">pt</a></li>
           
        

          </ul>
        </li>

        <!-- Languages -->
        
        <!-- / Languages -->

      </ul><!-- / .nav .navbar-nav .navbar-right -->

    </div><!--/.navbar-collapse -->
  </div><!-- / .container -->
</nav><!-- / .navbar -->
       

  @yield('content')

              <!-- ========== Footer ========== -->
        
        <footer class="footer-widgets">
          <div class="container">
            <div class="row section">

              <!-- About Us -->
              <div class="col-md-3 col-sm-6 mb-sm-100" style="margin-bottom: 67px;">
                <div class="widget about-widget">
                  <h5 class="header-widget">
                    <a href="/fr-fr/predications"><li class="fot">Prédications</li></a>
                  </h5>

                  <ul class="social-links">
                    <li ><a href="https://www.facebook.com/kacou.philippe"  target="_blank"><i class="fa fa-facebook" style="color: white !important"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter" target="_blank" style="color: white !important"></i></a></li>
                    <li><a href="https://www.youtube.com/c/PhilippekacouOrgChannelTV" style="color: white !important"><i class="fa fa-youtube-play" target="_blank"></i></a></li>
                  </ul>
                </div><!-- / .widget -->
              </div><!-- / .col-md-3 -->

              <!-- Instagram Feed -->
              <div class="col-md-3 col-sm-6 mb-sm-100">
                <div class="widget gallery-widget">
                  <h5 class="header-widget">
                    <a href="/fr-fr/cantiques"><li class="fot">Cantiques</li></a>
                  </h5>
                </div><!-- / .widget -->
              </div><!-- / .col-md-3 -->

              <!-- Twitter Feed -->
              <div class="col-md-3 col-sm-6 mb-sm-100">
                <div class="widget twitter-widget">
                  <h5 class="header-widget">Galéries</h5>
                  <a href="/fr-fr/galeries/photos"><li class="fot">Photos</li></a> 
                  <a href="/fr-fr/galeries/videos"><li class="fot">Videos</li></a>
                </div><!-- / .widget -->
              </div><!-- / .col-md-3 -->

              <!-- Newsletter -->
              <div class="col-md-3 col-sm-6 mb-sm-100">
                <div class="widget newsletter-widget">
                  <h5 class="header-widget">Contacts</h5>
                  <strong><p>Téléphone Mobile</p></strong>
                  <p>(+225) 0708000789 (Apôtre Aman Martin)</p>
                  <p>(+225) 0574747430 (Apôtre Aman Martin)</p>
                  <strong><p>Email</p></strong>
                  <a href="mailto:kacou.philippe@gmail.com" target="_blank" style="color: #fff !important;">kacou.philippe@gmail.com</a>
                  <strong><p>Adresse postale</p></strong>
                  <p>BP 374 Sikensi (Côte d'Ivoire)</p>
                  <!-- <strong><p>Skype</p></strong>
                   <a href="skype:kacou.philippe" target="_blank">kacou.philippe</a> 
                  <strong><p>Facebook</p></strong>
                  <a href="https://www.facebook.com/kacou.philippe" target="_blank">prophete.kacou</a> -->


                  
          

                </div><!-- / .widget -->
              </div><!-- / .col-md-3 -->

            </div><!-- / .row -->
          </div><!-- / .container -->


          <!-- Copyright -->
          <div class="copyright">
            <div class="container">
              <div class="row">
                
                <div class="col-sm-6">
                  <small>&copy; <script>document.write(new Date().getFullYear());</script> philippekacou.org Made by <a class="no-style-link" href="" target="_blank">PKP-DEV</a></small>
                </div>

                <div class="col-sm-6">
                  <small><a href="#page-top" class="pull-right to-the-top">Monter<i class="fa fa-angle-up"></i></a></small>
                </div>

              </div><!-- / .row -->
            </div><!-- / .container -->
          </div><!-- / .copyright -->

        </footer><!-- / .footer-widgets -->



        <!-- ========== Scripts ========== -->

        <script src="{{asset($assetUrl.'/js/vendor/jquery-2.1.4.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/google-fonts.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/jquery.easing.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/jquery.waypoints.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/bootstrap.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/bootstrap-hover-dropdown.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/smoothscroll.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/jquery.localScroll.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/jquery.scrollTo.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/jquery.stellar.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/jquery.parallax.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/slick.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/jquery.easypiechart.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/countup.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/isotope.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/jquery.magnific-popup.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/wow.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/jquery.mb.YTPlayer.min.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/vendor/jquery.ajaxchimp.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/pdf.js')}}"></script>
        <script src="{{asset($assetUrl.'/js/print.min.js')}}"></script>

        <!-- Google Maps -->
        <script src="{{asset($assetUrl.'/js/gmap.js')}}"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly"></script>

        <!-- Definity JS -->
        <script src="{{asset($assetUrl.'/js/main.js')}}"></script>
        <script>
          $('select').change(function() {
          if ($(this).children('option:first-child').is(':selected')) {
            $(this).addClass('placeholder');
          } else {
            $(this).removeClass('placeholder');
          }
          });
        </script>
    </body>

<!-- Mirrored from ajdethemes.com/definity-html/index-main-mp.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 30 Aug 2022 11:37:25 GMT -->
</html>
