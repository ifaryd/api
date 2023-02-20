@extends('templates/base')
@php
  $assetUrl = "templates";
@endphp
@section('content')
<style>
  .app-fonnt{
    color:black !important;
    font-size: 18px;
    font-weight: 100;
  }
</style>
<div id="home" class="main-demo-hero">
    <div class="bg-overlay">
                      
      <!-- Hero Content -->
      <div class="hero-content-wrapper">
        <div class="hero-content">
          
          <h1 class="hero-lead wow fadeInLeft" data-wow-duration="1.5s">{!! nl2br(__('app.app.home_subtitle')) !!}</h1>
          <h4 class="h-alt hero-subheading wow fadeIn acti" data-wow-duration="2s" data-wow-delay=".7s">{{__('app.app.prophete')}} Kacou Philippe</h4>
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

    </div><!-- / .bg-overlay -->
  </div><!-- / .main-hero-2 -->



  <!-- ========== About ========== -->

  <section id="welcome" class="container">
    <div class="row">

      <div class="ws-l"></div>
      
      <header class="sec-heading">
        <h2>{{__('app.app.home_title')}}</h2>
        <span class="subheading app-fonnt">{{__('app.app.home_subtitle2')}}</span>
      </header>

      <div class="col-md-offset-2 col-md-8 text-center ws-m" style="padding-bottom: 50px;">
        <p class="app-fonnt">
          {!! nl2br(__('app.app.home_subtitle3')) !!}
        </p>
      </div>

      <div class="col-md-12">
        <img class="img-responsive wow fadeIn center-block pro" data-wow-duration="2s" src="{{asset($assetUrl.'/images/logo-pkacou3.jpeg')}}" alt="" style="max-width: 400px;">
      </div>

    </div><!-- / .row -->
  </section><!-- / .section -->



 


  


  <!-- ========== Blog Preview ========== -->

  <div class="gray-bg">
    <section id="blog" class="section container blog-columns blog-preview">
      <div class="row">
        
        <header class="sec-heading">
          <h2>{!! nl2br(__('app.menu.predication')) !!}</h2>
          <span class="subheading app-fonnt">{!! nl2br(__('app.app.home_subtitle4')) !!}</span>
        </header>

        
        <!-- Blog Post 1 -->
        <div style="">
        @foreach ($predications as $predication)
        @if($predication)
        
          <div class="col-md-3 col-md-6 mb-sm-50">
            <div class="blog-post wow fadeIn" data-wow-duration="2s">
  
              <!-- Image -->
              <a href="/predications/{{$predication->id}}" class="post-img"><img src="{{asset($assetUrl.'/images/couv.png') }}" alt="Blog Post 1"></a>
  
              <div class="bp-content">
                
                <!-- Meta data -->
                {{-- <div class="post-meta">
                  <a href="#" class="post-date">
                    <i class="fa fa-calendar-o"></i>
                    <span>20 Juillet 2022</span>
                  </a>
                  
                </div> --}}
                <!-- / .meta -->
  
                <!-- Post Title -->
                <a href="/predications/{{$predication->id}}" class="post-title"><h4>{{$predication->chapitre}}</h4></a>
  
                <!-- Blurb -->
                <p>{{$predication->chapitre}} : {{Str::substr($predication->titre, 0, 38)}} {{Str::length($predication->titre) >38 ? '...' : ''}}</p>
  
                <!-- Link -->
                <a href="/predications/{{$predication->id}}" class="btn btn-small">{!! nl2br(__('app.app.home_subtitle5')) !!}</a>
  
              </div><!-- / .bp-content -->
  
            </div><!-- / .blog-post -->
          </div>
        
        <!-- / .col-lg-4 -->
        @endif
        @endforeach
      </div>
      </div><!-- / .row -->
    </section><!-- / .container -->
  </div><!-- / .gray-bg -->

 
  
  


  <!-- ========== CTA - Newsletter Signup ========== -->

  
  <!-- ========== Shop Layout - (Top Rated Product) ========== -->

  



  <!-- ========== Contact ========== -->

  <section id="contact" class="section contact-1">
    
    <header class="sec-heading">
      <h2>{!! nl2br(__('app.menu.contactez')) !!}</h2>
      <span class="subheading app-fonnt">{!! nl2br(__('app.contact.question')) !!}</span>
    </header>
    
    <div class="contact-wrapper">
      <!-- Map -->
     
     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15881.249412620044!2d-4.580225970505733!3d5.667896487129959!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc058339b3e6993%3A0x83061b2c38f23a49!2sSikensi!5e0!3m2!1sfr!2sci!4v1674264676700!5m2!1sfr!2sci" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

      <!-- Show Info Button -->
      <div class="show-info-link">
        <a href="#" class="show-info"><i class="fa fa-info"></i><h6></h6></a>
      </div>

      <div class="container">
        <div class="row ws-m">

          <!-- Address Info -->
          <div class="col-xs-offset-1 col-xs-11 col-md-offset-2 col-md-6 contact-info-wrapper">
            <address>
              <div class="row">

                <!-- Phone -->
                <div class="col-sm-6 address-group">
                  <span>{!! nl2br(__('app.menu.telephone_mobile')) !!}</span>
                  <a href="#"  class="app-fonnt">+225 07 08 000 789</a>
                  <a href="#" class="app-fonnt">+225 07 74 747 430 </a>
                </div>

                <!-- Address -->
                <div class="col-sm-5 address-group">
                  <span>{!! nl2br(__('app.menu.adresse_postale')) !!}</span>
                  <p class="app-fonnt">BP 374 Sikensi (Côte d'Ivoire)</p>
                </div>

              </div><!-- / .row -->

              <div class="row">

                <!-- Email -->
                <div class="col-sm-6 address-group">
                  <span>{!! nl2br(__('app.contact.email')) !!}</span>
        
                  <a class="app-fonnt" href="mailto:kacou.philippe@gmail.com" target="_blank">kacou.philippe@gmail.com</a>
                </div>

                <!-- Hours -->
                <!-- <div class="col-sm-5 address-group">
                  <span>Open Hours</span>
                  <p>Mon-Fri: 9am-5pm</p>
                  <p>Sat: 10am-1pm</p>
                </div> -->

              </div><!-- / .row -->

              <!-- Show Map Button -->
              <!-- <div class="row show-map-link">
                <a href="#" class="show-map"><span class="icon-map-pin"></span>Show on map</a>
              </div> / .row -->
            </address>
          </div><!-- / .contact-info-wrapper -->
        </div><!-- / .row -->
        
        <!-- Contact Form -->
        <div class="row">
          <form action="" method="POST" id="contact-form-1" class="form-ajax">
            <div class="col-md-offset-2 col-md-4 wow fadeInUp" data-wow-duration="1s">

              <!-- Name -->
              <div class="form-group">
                <input type="text" name="name" id="name-contact-1" class="form-control validate-locally" placeholder="{{__('app.contact.placeholder')}} {{__('app.contact.nom')}}">
                <label for="name-contact-1">{!! nl2br(__('app.contact.nom')) !!}</label>
                <span class="pull-right alert-error"></span>
              </div>

              <!-- Email -->
              <div class="form-group">
                <input type="email" name="email" id="email-contact-1" class="form-control validate-locally" placeholder="{{__('app.contact.placeholder')}} {{__('app.contact.email')}}">
                <label for="email-contact-1">{!! nl2br(__('app.contact.email')) !!}</label>
                <span class="pull-right alert-error"></span>
              </div>

            </div>

            <div class="col-md-4 wow fadeInUp" data-wow-duration="1s">

              <!-- Message -->
              <div class="form-group">
                <textarea name="message" id="message-contact-1" class="form-control" rows="5" placeholder="{{__('app.contact.placeholder')}} {{__('app.contact.message')}}"></textarea>
                <label for="message-contact-1">{{__('app.contact.message')}}</label>
              </div>
              <div>
                <input type="submit" class="btn pull-right" value="{{__('app.contact.envoyer')}}">
              </div>

              <!-- Ajax Message -->
              <div class="ajax-message col-md-12 no-gap"></div>

            </div><!-- / .col-md-4 -->

          </form>
        </div><!-- / .row -->
      </div><!-- / .container -->
    </div><!-- / .contact-wrapper -->
  </section><!-- / .contact-1 -->

@endsection