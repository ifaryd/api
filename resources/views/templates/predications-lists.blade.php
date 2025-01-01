@extends(('templates/base'))
@section('content')
@php
  $langue = '';
  $url ="predications";
  $assetUrl = env('PUBLIC_FILE');
  $locale = session('locale');
  if(!isset($locale)){
    $locale = "en";
  }
@endphp

<style>
  .app-fonnt{
    color:black !important;
    font-size: 18px;
    font-weight: 100;
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
    margin-top: -40px;
  }
}

@media only screen and (max-width: 768px) {
  #predication-sm{
    margin-top: 50px;
  }
}

/* Écrans de moins de 600px (mobiles) */
@media only screen and (max-width: 600px) {
  #predication-sm{
    margin-top: 50px;
  }
}

/* Écrans de moins de 480px (petits mobiles) */
@media only screen and (max-width: 480px) {
  #predication-sm{
    margin-top: 50px;
  }
}

</style>

<header class="page-title pt-small" style="margin-top: 70px; display:none;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">{{__('app.app.predication')}}</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ $langue }}">{{__('app.menu.home')}}</a></li>
          <li class="active">{{__('app.app.predication')}}</li>
        </ol>
      </div>
    </div>
  </header> 

  
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
          <!-- <div class="row">
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
        </div> -->
        <div class="row">
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
        </div>
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
          </div>
      </div>
      </div><!-- / .row -->
    </section><!-- / .container -->
  </div>
@endsection