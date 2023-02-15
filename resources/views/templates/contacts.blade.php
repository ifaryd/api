@extends(('templates/base'))
@section('content')
@php
  $langue = '';
@endphp

<style>
  .app-fonnt{
    color:black !important;
    font-size: 18px;
    font-weight: 100;
  }
</style>
<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">{!! nl2br(__('app.contact.contact_us')) !!}</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="accueil">{!! nl2br(__('app.menu.home')) !!}</a></li>
          <li class="active app-fonnt">{!! nl2br(__('app.menu.contact')) !!}</li>
        </ol>
      </div>
    </div>
  </header>

  <section id="contact" class="section contact-1" >
    
    <div class="contact-wrapper">
      <!-- Map -->
     
     <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15881.249412620044!2d-4.580225970505733!3d5.667896487129959!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc058339b3e6993%3A0x83061b2c38f23a49!2sSikensi!5e0!3m2!1sfr!2sci!4v1674264676700!5m2!1sfr!2sci" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

      <div class="container">
        <div class="row ws-m">
        </div>
        
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