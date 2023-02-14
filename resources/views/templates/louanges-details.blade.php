@extends(('templates/base'))
@section('content')
@php
  $title = "Cantiques";
  $langue = 'fr-fr';
  $url ="cantiques"
@endphp
<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">Cantiques</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ $langue }}">Accueil</a></li>
          <li><a href="/{{ $langue }}/{{$url}}">Cantique</a></li>
          <li class="active">{{ $predication->titre }}</li>
        </ol>
      </div>
    </div>
  </header>

<section class="container section">
    <div class="row ws-m" id="invoice">
      
      <header class="sec-heading" style="margin-bottom: 60px;">
        <h2 class="pred-title">{{ $predication->titre }}</h2>
        <span class="subheading lesr">{{ $predication->user->first_name }}</span>
      </header>

      @if($predication->contenu)
      <p style="display:flex; justify-content:center">{!! nl2br($predication->contenu) !!}</p>
      @else
      Aucun texte associé
      @endif


    </div><!-- / .row -->

    <div class="row ws-m">
    
    
        <div class="col-md-6 mb-sm-50" id="download">
            <a href="{{ $predication->lien_audio }}"  title="Télécharger">
                <button class="btn-ghost btn-small">Télécharger</button>
            </a>
         </div>
         
        @php
         $link = str_replace('feeds', 'api', $predication->lien_audio);
         $link = str_replace('stream', 'tracks', $link);
        @endphp

        <div class="col-md-6 mb-sm-50">
            <iframe width="100%" height="110" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url={{ $link }}&color=%23915d22&auto_play=false&hide_related=false&show_comments=true&show_user=true&show_reposts=false&show_teaser=true"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"><a href="https://soundcloud.com/kacou-philippe-proph-te" title="Prophète Kacou Philippe" target="_blank" style="color: #cccccc; text-decoration: none;"></a> <a href="https://soundcloud.com/kacou-philippe-proph-te/kacou-80-version-wolof" title="" target="_blank" style="color: #cccccc; text-decoration: none;"></a></div>
          </div>
      </div><!-- / .row -->

   

  </section><!-- / .container -->

@endsection