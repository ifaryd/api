@extends(('templates/base'))
@section('content')
@php
  $langue = '';
  $url ="cantiques"
@endphp

<style>
  .app-fonnt{
    color:black !important;
    font-size: 18px;
    font-weight: 100;
  }


  @media only screen and (min-width: 768px) {
    .sec-heading{
      margin-top: -66px;
    }
    .sec-heading{
      margin-bottom: 0px;
    }
  }

  @media only screen and (max-width: 768px) {
    .small-content{
      margin-top: 12px;
    }
    .sec-heading{
      margin-top: -56px;
    }
    .sec-heading{
      margin-bottom: 0px;
    }
}

@media only screen and (max-width: 700px) {
    .small-content{
      margin-top: 12px;
    }
    .sec-heading{
      margin-top: 38px;
    }
    .sec-heading{
      margin-bottom: 0px;
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
    .sec-heading{
      font-size: 12px;
    }
}
  
</style>

<header class="page-title pt-small" style="margin-top: 70px; display: none;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">{{__('app.menu.cantique')}}</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ $langue }}">{{__('app.menu.home')}}</a></li>
          <li><a href="{{ $langue }}/{{$url}}">{{__('app.menu.cantique')}}</a></li>
          <li class="active">{{ $predication->titre }}</li>
        </ol>
      </div>
    </div>
  </header>

<section class="container section">
    <div class="row ws-m" id="invoice">
      
      <header class="sec-heading" >
        <h2 class="pred-title">{{ $predication->titre }}</h2>
        <span class="subheading lesr">{{ $predication->user->first_name }}</span>
      </header>

      @if($predication->contenu)
      <p style="display:flex; justify-content:center">{!! nl2br($predication->contenu) !!}</p>
      @else
      {{__('app.app.home_subtitle6')}}
      @endif


    </div><!-- / .row -->

    <div class="row ws-m">
    
    <div style="display:flex; justify-content: space-between; flex-wrap: wrap;">
        <div style="display:flex">
          <div class="" id="download">
            <a type="" title="Télécharger"  onclick="document.title = '{{ $predication->titre }} : {{ $predication->user->first_name }}'; printForm()">
                <button class="btn-ghost btn-small">{{__('app.app.home_subtitle7')}} PDF</button>
            </a>
        </div>
        <div class="ml-2" id="download" style="margin-left: 12px">
          {{-- <a title="Télécharger" href="{{ $predication->lien_audio }}">
              
          </a> --}}
          <button id="downloadBtn" class="btn-ghost btn-small">{{__('app.app.home_subtitle7')}} MP3 </button>
       </div>
        </div>
        
      
        <div class="small-content" id="download">
          <audio controls style="background-color: rgb(4, 255, 0); opacity: 0.7">
            <source src="{{ $predication->lien_audio }}" type="audio/mpeg">
            Your browser does not support the audio element.
          </audio>
         </div>
       </div>

      </div>

   

  </section><!-- / .container -->
  <script>
    function printForm() {
        printJS({
            printable: 'invoice',
            type: 'html',
            style: ".pred-title {text-align: center !important;} .lesr {text-align: center !important;} .just {text-align: justify;}",
            ignoreElements: ['esc', 'esc1', 'esc2'],
            documentTitle: '{{ $predication->titre }} : {{ $predication->user->first_name }}',
            
        })
        
    }

    document.getElementById('downloadBtn').addEventListener('click', function() {
      // Lien à télécharger
      var audioUrl = '{{ $predication->lien_audio }}';
      
      // Crée un élément <a> de manière dynamique
      var link = document.createElement('a');
      link.href = audioUrl;
      link.download = ''; // Optionnel: le nom du fichier téléchargé

      // Ajoute l'élément <a> au DOM, clique dessus pour initier le téléchargement, puis le retire
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    });
    </script>
@endsection