@extends(('templates/base'))
@section('content')
@php
  $langue = '';
@endphp

<style>
  .app-fonnt{
    color:black !important;
    font-size: 18px;
    font-weight: 100;
  }
</style>
<header class="page-title pt-small" style="margin-top: 70px;">
    <div class="container">
      <div class="row">
        <h1 class="col-sm-6">{!! nl2br(__('app.contact.contact_us')) !!}</h1>
        <ol class="col-sm-6 text-right breadcrumb">
          <li><a href="accueil">{!! nl2br(__('app.menu.home')) !!}</a></li>
          <li class="active app-fonnt">{!! nl2br(__('app.menu.contact')) !!}</li>
        </ol>
      </div>
    </div>
  </header>

@include('layouts.contact')
@endsection