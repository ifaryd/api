@extends('templates/base')
@php
  $assetUrl = env('PUBLIC_FILE');
  $locale = session('locale');
  if(!isset($locale)){
    $locale = "en";
  }
@endphp
@section('content')
<style>
  .app-fonnt{
    color:black !important;
    font-size: 18px;
    font-weight: 100;
    margin-top: 30px; 
  }
  .sec-heading {
  margin-bottom: 30px !important;
  text-align: center;
}
.ws-l {
  padding-bottom: 80px !important;
}

@media only screen and (min-width: 768px) {
  #predication-sm{
    margin-top: -140px;
  }
}

@media only screen and (max-width: 768px) {
  .app-fonnt{
    margin-top: 60px; 
  }
  #predication-sm{
    
  }
}

/* Écrans de moins de 600px (mobiles) */
@media only screen and (max-width: 600px) {
  #predication-sm{
    
  }
}

/* Écrans de moins de 480px (petits mobiles) */
@media only screen and (max-width: 480px) {
  #predication-sm{
    
  }
}

</style>
  {{-- <div id="home" class="main-demo-hero">
    <div class="bg-overlay">
                      
      <!-- Hero Content -->
      <div class="hero-content-wrapper">
        <div class="hero-content">
          
          <h1 class="hero-lead wow fadeInLeft" data-wow-duration="1.5s">{!! nl2br(__('app.app.home_subtitle')) !!}</h1>
          <h4 class="h-alt hero-subheading wow fadeIn acti" data-wow-duration="2s" data-wow-delay=".7s">{{__('app.app.prophete')}} Kacou Philippe tes</h4>
          <a href="/predications" class="btn wow fadeIn" data-wow-duration="2s" data-wow-delay="1s" style="margin-bottom: 5px">{{__('app.menu.predication')}}</a>
          <a target="_blank" href="https://play.google.com/store/apps/details?id=com.matth25.prophetekacou" class="btn wow fadeIn" data-wow-duration="2s" data-wow-delay="1s" style="margin-bottom: 5px">{{__('app.app.mobile_application')}}</a>
          <a target="_blank" href="https://apps.apple.com/bj/app/proph%C3%A8te-kacou-officiel/id1348915504" class="btn wow fadeIn" data-wow-duration="2s" data-wow-delay="1s" style="margin-bottom: 5px">{{__('app.app.iphone_application')}}</a>
          <a target="_blank" href="https://www.philippekacou.org/file/local/ProphetKacou.exe" class="btn wow fadeIn" data-wow-duration="2s" data-wow-delay="1s" style="margin-bottom: 5px">{{__('app.app.desktop_application')}}</a>

        </div> 
      </div>

      <!-- Scroller -->
      <a href="#welcome" class="scroller scroller-dark">
        <span class="scroller-text">{{__('Défiler')}}</span>
        <span class="linea-basic-magic-mouse"></span>
      </a>

    </div>
  </div> --}}



  <!-- ========== About ========== -->

  <section id="welcome" class="container">
    <div class="row">

      <div class="ws-l"></div>
      <header class="sec-heading">
        {{-- <h2>{{__('app.app.home_title')}}</h2> --}}
        {{-- <span class="subheading app-fonnt">{{__('app.app.home_subtitle2')}}</span> --}}
      </header>
      <div style="display: flex;">
        
        <div style="">
          <div class="col-md-offset-2 col-md-8 text-center ws-m" style="padding-bottom: 50px;">
            <p class="app-fonnt">
              {!! nl2br(__('app.app.home_subtitle3')) !!}
            </p>
          </div>
        </div>

        {{-- <div class="col-md-12">
          <img class="img-responsive wow fadeIn center-block pro" data-wow-duration="2s" src="{{asset($assetUrl.'/images/logo-pkacou3.jpeg')}}" alt="" style="max-width: 400px;">
        </div>

        <div class="col-md-12">
          <img class="img-responsive wow fadeIn center-block pro" data-wow-duration="2s" src="{{asset($assetUrl.'/images/logo-pkacou3.jpeg')}}" alt="" style="max-width: 400px;">
          
        </div> --}}

      </div>
      
      
      

    </div><!-- / .row -->
  </section><!-- / .section -->

  <div class="hero-content-wrapper">
    <div class="hero-content container">
    
      <a href="/predications" class="btn wow fadeInRemoveme" data-wow-duration="1s" data-wow-delay="1s" style="margin-bottom: 5px">{{__('app.menu.predication')}}</a>
      <a target="_blank" href="https://play.google.com/store/apps/details?id=com.matth25.prophetekacou" class="btn wow fadeInRemoveme" data-wow-duration="12s" data-wow-delay="1s" style="margin-bottom: 5px">{{__('app.app.mobile_application')}}</a>
      <a target="_blank" href="https://apps.apple.com/bj/app/proph%C3%A8te-kacou-officiel/id1348915504" class="btn wow fadeInRemoveme" data-wow-duration="2s" data-wow-delay="1s" style="margin-bottom: 5px">{{__('app.app.iphone_application')}}</a>
      <a target="_blank" href="https://www.philippekacou.org/file/local/ProphetKacou.exe" class="btn wow fadeInRemoveme" data-wow-duration="2s" data-wow-delay="1s" style="margin-bottom: 5px">{{__('app.app.desktop_application')}}</a>
    </div> 
  </div>

  <!-- ========== Blog Preview ========== -->

  <div class="gray-bg" style="">
    <section id="blog" class="section container blog-columns blog-preview">
      <div class="row">
        
        {{-- <header class="sec-heading">
          <h2>{!! nl2br(__('app.menu.predication')) !!}</h2>
          <span class="subheading app-fonnt">{!! nl2br(__('app.app.home_subtitle4')) !!}</span>
        </header> --}}
        
        
        <!-- Blog Post 1 -->
        <div style="" id="predication-sm">

          <header class="sec-heading">
            <h2>{!! nl2br(__('app.menu.predication')) !!}</h2>
            <span class="subheading app-fonnt">{!! nl2br(__('app.app.home_subtitle4')) !!}</span>
          </header>

        @foreach ($predications as $predication)
        @if($predication)
          @php
            $url_pre = str_replace('stream', 'tracks', str_replace('feeds','api', $predication->lien_audio_cloud));
          @endphp
          <div class="col-md-3 col-md-6 mb-sm-50" style="margin-bottom: 20px;">
            <div class="blog-post wow fadeIn" data-wow-duration="2s">
  
              <!-- Image -->
              
              <a href="/predications/{{$predication->id}}" class="post-img">
                <img src="{{asset($assetUrl."/images/couvertures/".$locale."/Kacou-".$predication->numero.".png")}}" alt="">
              </a>

              <div class="bp-contents">

                {{-- <a href="/predications/{{$predication->id}}" class="post-title"><h4>{{$predication->chapitre}}</h4></a>
  
                <p>{{$predication->chapitre}} : {{Str::substr($predication->titre, 0, 30)}} {{Str::length($predication->titre) >30 ? '...' : ''}}</p> --}}

                <a href="/predications/{{$predication->id}}" class="btn btn-small">{!! nl2br(__('app.app.home_subtitle5')) !!}</a>
  
              </div>
  
            </div>
          </div>
        
        <!-- / .col-lg-4 -->
        @endif
        @endforeach

        <a href="/predications" class="btn btn-small">{!! nl2br(__('app.app.all_sermons')) !!}</a>
      </div>
      </div><!-- / .row -->
    </section><!-- / .container -->
  </div>
  <!-- / .gray-bg -->

 
  
  


  <!-- ========== CTA - Newsletter Signup ========== -->

  
  <!-- ========== Shop Layout - (Top Rated Product) ========== -->

  



  <!-- ========== Contact ========== -->

  {{-- <section id="contacts" class="section contact-1s">
    <header class="sec-heading">
      <h2>{!! nl2br(__('app.menu.contactez')) !!}</h2>
      <span class="subheading app-fonnt">{!! nl2br(__('app.contact.question')) !!}</span>
    </header>
  </section> --}}

  <section>
    @include('layouts.contact')
  </section>

@endsection