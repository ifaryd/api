@extends(('templates/base'))
@section('content')
@php
  $langue = '';
  $url ="assemblees";
@endphp

<style>
  .placeholder{color: grey;}
select option:first-child{color: grey; display: none;}
select option{color: #555;}

  @media only screen and (min-width: 768px) {
    .small-content{
      margin-bottom: 0px;
    }
  }

  @media only screen and (max-width: 768px) {
    .small-content{
      margin-top: 12px !important;
    }
}

@media only screen and (max-width: 700px) {
    .small-content{
      margin-top: 80px !important;
    }
}

/* Écrans de moins de 600px (mobiles) */
@media only screen and (max-width: 600px) {
  .small-content{
      margin-top: 80px !important;
    }
}

/* Écrans de moins de 480px (petits mobiles) */
@media only screen and (max-width: 480px) {
  .small-content{
      margin-top: 100px !important;
    }
}
  
</style>
<!--<header class="page-title pt-small" style="margin-top: 90px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">{{__('app.app.home_subtitle10')}}</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ $langue }}">{{__('app.menu.home')}}</a></li>
          <li class="active">{{__('app.app.home_subtitle10')}}</li>
        </ol>
      </div>
    </div>
  </header>-->

  <div class="container section small-content">
    <div class="row">
      <!-- Highlited Rows Table -->
    <div class="col-md-offset-0 col-lg-12 ws-m">
      <div style="display:flex; flew-direction: row; justify-content: space-between;  flex-wrap: wrap; margin-bottom: 10px;">
        <a href="changeAssemblee" id="url" class="d-none"></a>
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
        <div>
          <label style="color:red">{{__('app.app.select_country')}}</label>
            <select class="form-control placeholder" onchange="change(this)" style="font-size: 18px; color:blue">
              <option>Selectionner votre pays</option>
                @foreach($chantres as $chantre)
                    @if($chantre->id == $pays_id)
                      <option class="color:white" selected value="{{ $chantre->id }}">{{ $chantre->nom }}</option>
                    @else
                      <option value="{{ $chantre->id }}">{{ $chantre->nom }}</option>
                    @endif
                @endforeach
            </select>
        </div>
      </div>
        <table class="table table-row-highlight">
          <thead>
            <tr>
              <th>{{__('app.app.home_subtitle15')}}</th>
              <th>{{__('app.app.home_subtitle14')}}</th>
              <th>{{__('app.app.home_subtitle13')}}</th>
              <th>{{__('app.app.home_subtitle12')}}</th>
              <th>{{__('app.app.home_subtitle11')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($predications as $villes)
            @if($villes && $villes->assemblees)
                @foreach($villes->assemblees as $assemblee)
                <tr style="font-size: 18px;">
                    <td data-label><a class="fott">{{ $assemblee->nom }}</a></td>
                    <td data-label><a class="fott">{{ $villes->libelle }}</a></td>
                    <td data-label><a class="fott">{{ $assemblee->addresse }}</a></td>
                    <td data-label><a class="fott">{{ dirigeantAssemblee($assemblee->id) ? dirigeantAssemblee($assemblee->id)->first_name : '' }}</a></td>
                    <td data-label><a class="fott">{{  dirigeantAssemblee($assemblee->id) ? dirigeantAssemblee($assemblee->id)->telephone : ''  }}</a></td>
                </tr>
                @endforeach
            @endif
            
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
  <script>
    function change(selector){

      if(!selector.value){
        return false;
      }
      var userURL = document.getElementById('url');

      $.ajax({
          url: userURL.getAttribute('href')+'/'+selector.value,
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            window.location.reload();
          },
          error: function(data) {
            window.location.reload();
          }
      });
    }
  </script>
@endsection