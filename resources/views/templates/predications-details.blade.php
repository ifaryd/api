@extends(('templates/base'))
@section('content')
@php
  $title = "Prédications";
  $langue = 'fr-fr';
  $url ="predications"
@endphp
<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">Prédications</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ $langue }}">Accueil</a></li>
          <li><a href="/{{ $langue }}/{{$url}}">Prédications</a></li>
          <li class="active">{{ $predication->titre }}</li>
        </ol>
      </div>
    </div>
  </header>





<section class="container section">
    <div class="row ws-m" id="invoice">
      
      <header class="sec-heading" style="margin-bottom: 60px;">
        <h2 class="pred-title">{{ $predication->chapitre }} : {{ $predication->titre }}</h2>
        <span class="subheading lesr">{{ $predication->sous_titre }}</span>
      </header>

      @if ($predication->versets)
      <div class="col-lg-12 mb-sm-50 just">
        @foreach ($predication->versets as $verset)
        <p><strong>{{ $verset->numero }}</strong> {{ $verset->contenu }}</p>
        @endforeach
        <h4 class="blog-section-title">{{ $predication->sermon_similaire }}</h4>
      </div>
      @endif

    </div><!-- / .row -->

    <div class="row ws-m">
    
    
        <div class="col-md-6 mb-sm-50">
            <a type="" title="Télécharger"  onclick="document.title = '{{ $predication->chapitre }} : {{ $predication->titre }}'; printForm()">
                <button class="btn-ghost btn-small">Télécharger le pdf</button>
            </a>
         </div>
         
        <div class="col-md-6 mb-sm-50">
            <iframe width="100%" height="110" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url={{ $predication->lien_audio_cloud }}&color=%23915d22&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/kacou-philippe-proph-te" title="Prophète Kacou Philippe" target="_blank" style="color: #cccccc; text-decoration: none;"></a> <a href="https://soundcloud.com/kacou-philippe-proph-te/kacou-80-version-wolof" title="" target="_blank" style="color: #cccccc; text-decoration: none;"></a></div>
          </div>
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