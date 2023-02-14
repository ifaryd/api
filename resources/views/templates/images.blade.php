@extends(('templates/base'))
@section('content')
@php
  $langue = '';
  $url ="photos"
@endphp

<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">{{__('app.menu.photo')}}</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ $langue }}">{{__('app.menu.home')}}/{{__('app.menu.galerie')}}</a></li>
          <li class="active">{{__('app.menu.photo')}}</li>
        </ol>
      </div>
    </div>
  </header>

  <section class="container portfolio-layout portfolio-columns-boxed">
    <div class="row ws-m wow fadeIn" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: fadeIn;">

        @if ($photos->lastPage() && $photos->total() > $photos->perPage())
        <nav class="blog-pagination">
          <ul class="pagination">
            @for ($i=1; $i <= $photos->lastPage(); $i++)
              @if ($i == $photos->currentPage())
              <li><a class="acti" href="?page={{ $i }}">{{ $i }}</a></li>
              @else
              <li><a href="?page={{ $i }}">{{ $i }}</a></li>
              @endif
            @endfor
          </ul>
        </nav>
        @endif
        @foreach ($photos as $photo)
        <div class="col-md-4 portfolio-item print mt-1">
          <div class="p-wrapper hover-default" style="height: 292px !important;">
            <img src="{{ $photo->url }}" alt="{{ $photo->description }}">
            <div class="p-hover" style="height: 292px !important;">
              <div class="p-content">
                
                <h6 class="subheading">{{ $photo->description }}</h6>
              </div>
            </div>
            <a href="{{ $photo->url }}" class="open-btn open-gallery"><i class="fa fa-expand"></i></a>
          </div>
        </div><!-- / .portfolio-item -->
        @endforeach 
        @if ($photos->lastPage() && $photos->total() > $photos->perPage())
        <nav class="blog-pagination">
          <ul class="pagination">
            @for ($i=1; $i <= $photos->lastPage(); $i++)
              @if ($i == $photos->currentPage())
              <li><a class="acti" href="?page={{ $i }}">{{ $i }}</a></li>
              @else
              <li><a href="?page={{ $i }}">{{ $i }}</a></li>
              @endif
            @endfor
          </ul>
        </nav>
        @endif
    </div><!-- / .row -->
  </section>
@endsection