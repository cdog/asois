<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title') &middot; ASOIS</title>
    <link href="{{ asset('assets/lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!--[if lt IE 9]>
      <script src="{{ asset('assets/js/html5shiv.min.js') }}"></script>
      <script src="{{ asset('assets/js/respond.min.js') }}"></script>
    <![endif]-->
  </head>
  <body>
    @include('layouts.navigation')
    <div class="page-header">
      <div class="container">
        @yield('toolbar')
        <h1>@yield('title')</h1>
      </div>{{-- .container --}}
    </div>{{-- .page-header --}}
