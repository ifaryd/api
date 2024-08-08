@extends(('templates/base'))
@section('content')
@php
  $langue = '';
  $url ="predications";
  $url_predication = str_replace('stream', 'tracks', str_replace('feeds','api', $predication->lien_audio_cloud));
@endphp

<style>
  .app-fonnt{
    color:black !important;
    font-size: 18px;
    font-weight: 100;
  }


  @media only screen and (max-width: 768px) {
    .small-content{
      margin-top: 12px;
    }
}

/* Écrans de moins de 600px (mobiles) */
@media only screen and (max-width: 600px) {
  .small-content{
      margin-top: 12px;
    }
}

/* Écrans de moins de 480px (petits mobiles) */
@media only screen and (max-width: 480px) {
  .small-content{
      margin-top: 12px;
    }
}
  
</style>

<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">{{__('app.menu.predication')}}</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ $langue }}">{{__('app.menu.home')}}</a></li>
          <li><a href="{{ $langue }}/{{$url}}">{{__('app.menu.predication')}}</a></li>
        </ol>
      </div>
    </div>
  </header>

<section class="container section">
    <div class="row ws-m" id="invoice">
      
      <header class="sec-heading" style="margin-bottom: 60px;">
        <h2 class="pred-title">{{ $predication->chapitre }} : {{ $predication->titre }}</h2>
        <span class="subheading lesr" style="color:black !important">{{ $predication->sous_titre }}</span>
      </header>

      @if ($predication->versets)
      <div class="col-lg-12 mb-sm-50 just app-fonnt">
        @foreach ($predication->versets as $verset)
        <p><strong>{{ $verset->numero }}</strong> {{ $verset->contenu }}</p>
        @endforeach
        <h4 class="blog-section-title">{{ $predication->sermon_similaire }}</h4>
      </div>
      @endif

    </div><!-- / .row -->

    <div class="row ws-m">
    
      <div style="display:flex; justify-content: space-between; flex-wrap: wrap;">
        <div style="display:flex">
          <div class="" id="download">
            <a type="" title="Télécharger"  onclick="document.title = '{{ $predication->chapitre }} : {{ $predication->titre }}'; printForm()">
                <button class="btn-ghost btn-small">{{__('app.app.home_subtitle7')}} PDF</button>
            </a>
        </div>
        <div class="ml-2" id="download" style="margin-left: 12px">
          <a title="Télécharger" href="{{ $predication->lien_audio_cloud }}">
              <button class="btn-ghost btn-small">{{__('app.app.home_subtitle7')}} MP3 </button>
          </a>
       </div>
        </div>
        
      
        <div class="small-content" id="download">
          <audio controls style="background-color: rgb(4, 255, 0); opacity: 0.7">
            <source src="{{ $predication->lien_audio_cloud }}" type="audio/mpeg">
            Your browser does not support the audio element.
          </audio>
         </div>
       </div>

        {{-- <div class="col-md-6 mb-sm-50">
            <iframe width="100%" height="110" scrolling="no" frameborder="no" allow="autoplay" 
            src="https://w.soundcloud.com/player/?url={{ $url_predication }}&color=%23915d22&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/kacou-philippe-proph-te" title="Prophète Kacou Philippe" target="_blank" style="color: #cccccc; text-decoration: none;"></a> <a href="https://soundcloud.com/kacou-philippe-proph-te/kacou-80-version-wolof" title="" target="_blank" style="color: #cccccc; text-decoration: none;"></a></div>
        </div> --}}

      </div><!-- / .row -->

   

  </section><!-- / .container -->

  <script>
    function printForm() {
        printJS({
            printable: 'invoice',
            type: 'html',
            style: ".pred-title {text-align: center !important;} .lesr {text-align: center !important;} .just {text-align: justify;}",
            ignoreElements: ['esc', 'esc1', 'esc2'],
            documentTitle: '{{ $predication->chapitre }} : {{ $predication->titre }}',
            
        })
        
    }
    </script>
@endsection