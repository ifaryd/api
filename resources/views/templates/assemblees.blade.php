@extends(('templates/base'))
@section('content')
@php
  $title = "Assemblees";
  $langue = 'fr-fr';
  $url ="assemblees";
@endphp
<style>
    .placeholder{color: grey;}
select option:first-child{color: grey; display: none;}
select option{color: #555;}
</style>
<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">Assemblees</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="/{{ $langue }}">Accueil</a></li>
          <li class="active">Assemblees</li>
        </ol>
      </div>
    </div>
  </header>

  <div class="container section">
    <div class="row">
      <!-- Highlited Rows Table -->
    <div class="col-md-offset-0 col-lg-12 ws-m">
      <div style="display:flex; flew-direction: row; justify-content: space-between;">
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
            <select class="form-control placeholder" onchange="change(this)">
                @foreach($chantres as $chantre)
                    @if($chantre->id == $pays_id)
                      <option selected value="{{ $chantre->id }}">{{ $chantre->nom }}</option>
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
              <th>Nom</th>
              <th>Ville</th>
              <th>Addresse</th>
              <th>Dirigeant</th>
              <th>Contact</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($predications as $villes)
            @if($villes && $villes->assemblees)
                @foreach($villes->assemblees as $assemblee)
                <tr>
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