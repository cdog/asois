@extends('layouts.page')

@section('title', 'View poll')

@if (Auth::check() && Auth::user()->can('create_polls'))
  @section('toolbar')
    <div class="btn-toolbar pull-right" role="toolbar">
      <div class="btn-group" role="group">
        <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#modal-poll-delete">
          <span class="glyphicon glyphicon-trash"></span>
          Delete
        </button>{{-- .btn .btn-danger --}}
      </div>{{-- .btn-group --}}
      <div class="btn-group" role="group">
        @if ($poll->open)
          <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-poll-close">
            <span class="glyphicon glyphicon-remove-circle"></span>
            Close poll
          </button>{{-- .btn .btn-default --}}
        @else
          <button class="btn btn-default" type="button" data-toggle="modal" data-target="#modal-poll-open">
            <span class="glyphicon glyphicon-ok-circle"></span>
            Reopen poll
          </button>{{-- .btn .btn-default --}}
        @endif
      </div>{{-- .btn-group --}}
    </div>{{-- .btn-toolbar .pull-right --}}
  @stop
@endif

@section('tabs')
  <ul class="nav nav-tabs">
    <li role="presentation"><a href="{{ URL::route('poll', array($poll->id)) }}">Poll</a></li>
    @if ($poll->answered || (Auth::check() && Auth::user()->can('read_poll_results')))
      <li role="presentation"><a href="{{ URL::route('results', array($poll->id)) }}">Results</a></li>
    @endif
    @if (Auth::check() && Auth::user()->can('read_poll_statistics'))
      <li class="active" role="presentation"><a href="{{ URL::route('statistics', array($poll->id)) }}">Statistics</a></li>
    @endif
  </ul>{{-- .nav .nav-tabs --}}
@stop

@section('content')
  <div class="row">
    <div class="col-md-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <h4>{{{ $poll->question }}}</h4>
          <hr>
          @foreach ($answers as $answer)
            <div class="radio">
              <label>
                {{ Form::radio('answer', $answer->id) }}
                {{{ $answer->answer }}}
              </label>
            </div>{{-- .radio --}}
          @endforeach
        </div>{{-- .panel-body --}}
      </div>{{-- .panel .panel-default --}}
    </div>{{-- .col-md-4 --}}
    <div class="col-md-8">
      <div id="map"></div>
      <script id="statistics" type="application/json">{{ $statistics }}</script>
    </div>{{-- .col-md-4 --}}
  </div>{{-- .row --}}
  <div class="modal fade" id="modal-poll-delete" tabindex="-1" role="dialog" aria-labelledby="modal-poll-delete-label" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="modal-poll-delete-label">Are you sure?</h4>
        </div>{{-- .modal-header --}}
        <div class="modal-body">
          <p>Are you sure you want to delete this poll?</p>
        </div>{{-- .modal-body --}}
        <div class="modal-footer">
          <a href="{{ URL::route('delete', array($poll->id)) }}" class="btn btn-danger btn-block">Delete</a>
        </div>{{-- .modal-footer --}}
      </div>{{-- .modal-content --}}
    </div>{{-- .modal-dialog .modal-sm --}}
  </div>{{-- .modal .fade --}}
  <div class="modal fade" id="modal-poll-close" tabindex="-1" role="dialog" aria-labelledby="modal-poll-close-label" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="modal-poll-close-label">Are you sure?</h4>
        </div>{{-- .modal-header --}}
        <div class="modal-body">
          <p>Are you sure you want to close this poll?</p>
        </div>{{-- .modal-body --}}
        <div class="modal-footer">
          <a href="{{ URL::route('close', array($poll->id)) }}" class="btn btn-default btn-block">Close poll</a>
        </div>{{-- .modal-footer --}}
      </div>{{-- .modal-content --}}
    </div>{{-- .modal-dialog .modal-sm --}}
  </div>{{-- .modal .fade --}}
  <div class="modal fade" id="modal-poll-open" tabindex="-1" role="dialog" aria-labelledby="modal-poll-open-label" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="modal-poll-open-label">Are you sure?</h4>
        </div>{{-- .modal-header --}}
        <div class="modal-body">
          <p>Are you sure you want to reopen this poll?</p>
        </div>{{-- .modal-body --}}
        <div class="modal-footer">
          <a href="{{ URL::route('open', array($poll->id)) }}" class="btn btn-default btn-block">Reopen poll</a>
        </div>{{-- .modal-footer --}}
      </div>{{-- .modal-content --}}
    </div>{{-- .modal-dialog .modal-sm --}}
  </div>{{-- .modal .fade --}}
@stop
