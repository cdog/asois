@extends('layouts.page')

@section('title', 'Sign up')

@section('content')
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4">
      @include('layouts.alerts')
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">@yield('title')</h3>
        </div>{{-- .panel-heading --}}
        <div class="panel-body">
          {{ Form::open() }}
            <div class="form-group">
              {{ Form::label('name', 'Username:') }}
              {{ Form::text('name', null, array('class' => 'form-control', 'placeholder' => 'Username')) }}
            </div>{{-- .form-group --}}
            <div class="form-group">
              {{ Form::label('password', 'Password:') }}
              {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Password')) }}
            </div>{{-- .form-group --}}
            <div class="form-group">
              {{ Form::label('password_confirmation', 'Confirm your password:') }}
              {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Password confirmation')) }}
            </div>{{-- .form-group --}}
            <div class="form-group">
              {{ Form::label('country', 'Country:') }}
              {{ Form::select('country', $countries, null, array('class' => 'form-control')) }}
            </div>{{-- .form-group --}}
            {{ Form::button('Create an account', array('class' => 'btn btn-success pull-right', 'type' => 'submit')) }}
          {{ Form::close() }}
        </div>{{-- .panel-body --}}
      </div>{{-- .panel .panel-default --}}
    </div>{{-- .col-sm-6 .col-sm-offset-3 .col-lg-4 .col-lg-offset-4 --}}
  </div>{{-- .row --}}
@stop
