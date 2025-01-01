@extends(('templates/base'))
@section('content')
@php
  $langue = '';
  $url ="cantique";
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

<!--<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">{{__('app.menu.cantique')}}</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ $langue }}">{{__('app.menu.home')}}</a></li>
          <li class="active">{{__('app.menu.cantique')}}</li>
        </ol>
      </div>
    </div>
  </header>-->

  <div class="container section small-content">
    <div class="row">
      <!-- Highlited Rows Table -->
    <div class="col-md-offset-0 col-lg-12 ws-m">
      <div style="display:flex; flew-direction: row; justify-content: space-between; flex-wrap: wrap; margin-bottom: 10px;">
        <a href="changeCantique" id="url" class="d-none"></a>
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
          <label style="color:red">{{__('app.app.select_user')}}</label>
            <select class="form-control placeholder" onchange="change(this)" style="font-size: 18px; color:blue">
              <option>Sélectionner le chantre</option>
                @foreach($chantres as $chantre)
                    @if($chantre->id == $userId)
                      <option selected value="{{ $chantre->id }}">{{ $chantre->first_name }}</option>
                    @else
                      <option value="{{ $chantre->id }}">{{ $chantre->first_name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
      </div>
        <table class="table table-row-highlight">
          <thead>
            <tr>
              <th>{{__('app.app.home_subtitle9')}}</th>
              <th>{{__('app.app.home_subtitle7')}}</th>
              <th>{{__('app.app.home_subtitle8')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($predications as $predication)
            <tr style="font-size: 18px;">
              <td data-label><a href="{{$url.'/'.$predication->id}}" class="fott">{{ $predication->titre }}</a></td>
              <td data-label><a href="{{ $url.'/'.$predication->id }}" class="fott">{{__('app.app.home_subtitle7')}}</a> </td>
              @php
               $link = str_replace('feeds', 'api', $predication->lien_audio);
               $link = str_replace('stream', 'tracks', $link);
              @endphp
              <td data-label style="padding-top: 0px;padding-bottom: 0px;">
              {{-- <iframe width="100%" height="20" scrolling="no" frameborder="no" allow="autoplay" src="https://w.soundcloud.com/player/?url={{ $link}}&color=%23ff5500&inverse=false&auto_play=false&show_user=true"></iframe><div style="font-size: 10px; color: #cccccc;line-break: anywhere;word-break: normal;overflow: hidden;white-space: nowrap;text-overflow: ellipsis; font-family: Interstate,Lucida Grande,Lucida Sans Unicode,Lucida Sans,Garuda,Verdana,Tahoma,sans-serif;font-weight: 100;"></div> </td>  --}}
                  <audio controls style="background-color: rgb(4, 255, 0); opacity: 0.7">
                  <source src="{{ $predication->lien_audio }}" type="audio/mpeg">
                  Your browser does not support the audio element.
                </audio>
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
  <script>
    function change(selector){

      if(!selector.value){
        return false;
      }
      var userURL = document.getElementById('url');
      //$('a#url').data('url');
 
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