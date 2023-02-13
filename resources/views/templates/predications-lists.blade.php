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
          <li class="active">Prédications</li>
        </ol>
      </div>
    </div>
  </header>




  <div class="container section">
    <div class="row">
      <!-- Highlited Rows Table -->
    <div class="col-md-offset-0 col-lg-12 ws-m">
      @if ($predications->lastPage() && $predications->total() > $predications->perPage())
      <nav class="blog-pagination">
        <ul class="pagination">
          @for ($i=1; $i <= $predications->lastPage(); $i++)
            @if ($i == $predications->currentPage())
            <li><a class="acti" href="?page={{ $i }}">{{ $i }}</a></li>
            @else
            <li><a href="?page={{ $i }}">{{ $i }}</a></li>
            @endif
          @endfor
        </ul>
      </nav>
      @endif
        <table class="table table-row-highlight">
          <thead>
            <tr>
              <th>Chapitre</th>
              <th>Titre</th>
              <th>Télécharger</th>
              <th>Ecouter</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($predications as $predication)
            <tr>
              <td data-label><a href="{{$langue.'/'.$url.'/'.$predication->id}}" class="fott">{{ $predication->chapitre }}</a></td>
              <td data-label> <a href="{{$langue.'/'.$url.'/'.$predication->id}}" class="fott">{{ $predication->titre }}</a></td>
              <td data-label><a href="{{$langue.'/'.$url.'/'.$predication->id}}" class="fott">PDF</a> </td>
              <td data-label style="padding-top: 0px;padding-bottom: 0px;">
                <iframe width="100%" height="20" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url={{ $predication->lien_audio_cloud }}&color=%23ff5500&inverse=false&auto_play=false&show_user=true"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"></div> </td>
            </tr>
            @endforeach          
            </tbody>
        </table><!-- / .table -->
        <div class="row">
          @if ($predications->lastPage() && $predications->total() > $predications->perPage())
          <nav class="blog-pagination">
            <ul class="pagination">
              @for ($i=1; $i <= $predications->lastPage(); $i++)
                @if ($i == $predications->currentPage())
                <li><a class="acti" href="?page={{ $i }}">{{ $i }}</a></li>
                @else
                <li><a href="?page={{ $i }}">{{ $i }}</a></li>
                @endif
              @endfor
            </ul>
          </nav>
          @endif
          </div><!-- / .row -->
      </div><!-- / .col-md-6 -->

      
    
    </div><!-- / .row -->
  </div><!-- / .container -->
@endsection