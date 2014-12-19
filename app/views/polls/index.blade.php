@extends('layouts.page')

@section('title', 'Polls')

@if (Auth::check() && Auth::user()->can('create_polls'))
  @section('toolbar')
    <div class="btn-toolbar pull-right" role="toolbar">
      <div class="btn-group" role="group">
        <a class="btn btn-success" href="{{ URL::to('polls/new') }}" role="button">
          <span class="glyphicon glyphicon-plus"></span>
          New poll
        </a>{{-- .btn .btn-success --}}
      </div>{{-- .btn-group --}}
    </div>{{-- .btn-toolbar .pull-right --}}
  @stop
@endif

@section('tabs')
  <ul class="nav nav-tabs">
    <li {{ Request::is('/') ? 'class="active"' : '' }} role="presentation"><a href="{{ URL::to('/') }}">All</a></li>
    <li {{ Request::is('polls/open') ? 'class="active"' : '' }} role="presentation"><a href="{{ URL::to('polls/open') }}">Open</a></li>
    <li {{ Request::is('polls/closed') ? 'class="active"' : '' }} role="presentation"><a href="{{ URL::to('polls/closed') }}">Closed</a></li>
  </ul>{{-- .nav .nav-tabs --}}
@stop

@section('content')
  <div class="panel panel-default">
    <table class="table table-hover">
      <thead>
        <tr>
          @if (Auth::check() && (Auth::user()->can('delete_polls') || Auth::user()->can('edit_polls')))
            <td class="cell-checkbox cell-middle text-center">
              <input type="checkbox">
            </td>{{-- .cell-checkbox .cell-middle .text-center --}}
          @endif
          <td class="cell-middle" colspan="{{ Auth::check() && (Auth::user()->can('delete_polls') || Auth::user()->can('edit_polls')) ? 5 : 4 }}">
            @if (Auth::check())
              <div class="btn-toolbar pull-right" role="toolbar">
                @if (Auth::user()->can('delete_polls'))
                  <div class="btn-group" role="group">
                    <button class="btn btn-link" type="button" disabled>
                      <span class="glyphicon glyphicon-trash"></span>
                      Delete
                    </button>{{-- .btn .btn-link --}}
                  </div>{{-- .btn-group --}}
                @endif
                @if (Auth::user()->can('edit_polls'))
                  <div class="btn-group" role="group">
                    <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false" disabled>
                      Mark as
                      <span class="caret"></span>
                    </button>{{-- .btn .btn-link .dropdown-toggle --}}
                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Open</a></li>
                      <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Closed</a></li>
                    </ul>{{-- .dropdown-menu .dropdown-menu-right --}}
                  </div>{{-- .btn-group --}}
                @endif
                <div class="btn-group" role="group">
                  <button class="btn btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
                    Filter
                    <span class="caret"></span>
                  </button>{{-- .btn .btn-link .dropdown-toggle --}}
                  <ul class="dropdown-menu dropdown-menu-right" role="menu">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Answered</a></li>
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Unanswered</a></li>
                  </ul>{{-- .dropdown-menu .dropdown-menu-right --}}
                </div>{{-- .btn-group --}}
              </div>{{-- .btn-toolbar .pull-right --}}
            @endif
            <p class="toolbar-text text-muted">Showing <strong>{{ $showing }}</strong> of <strong>{{ $count }}</strong> polls</p>
          </td>{{-- .cell-middle --}}
        </tr>
      </thead>
      <tbody>
        @forelse ($polls as $poll)
          <tr>
            @if (Auth::check() && (Auth::user()->can('delete_polls') || Auth::user()->can('edit_polls')))
              <td class="cell-checkbox text-center">
                <input type="checkbox">
              </td>{{-- .cell-checkbox .text-center --}}
            @endif
            <td class="cell-open text-center">
              @if ($poll->open)
                <h4 class="list-group-item-heading text-success">
                  <span class="glyphicon glyphicon-ok-circle" aria-hidden="true" data-toggle="tooltip" title="Open"></span>
                </h4>{{-- .list-group-item-heading .text-success --}}
              @else
                <h4 class="list-group-item-heading text-danger">
                  <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" data-toggle="tooltip" title="Closed"></span>
                </h4>{{-- .list-group-item-heading .text-danger --}}
              @endif
            </td>{{-- .cell-open .text-center --}}
            <td>
              <h4 class="list-group-item-heading">
                <a href="{{ URL::route('poll', array($poll->id)) }}">{{{ $poll->question }}}</a>
              </h4>{{-- .list-group-item-heading --}}
              <p class="list-group-item-text">Added on {{ date('d F Y', strtotime($poll->created_at)) }}</p>
            </td>
            <td class="cell-views text-center">
              <h4 class="list-group-item-heading">{{ $poll->views }}</h4>
              <p class="list-group-item-text">views</p>
            </td>{{-- .cell-views .text-center --}}
            <td class="cell-answers text-center">
              <h4 class="list-group-item-heading">0</h4>
              <p class="list-group-item-text">answers</p>
            </td>{{-- .cell-answers .text-center --}}
            @if (Auth::check() && (Auth::user()->can('delete_polls') || Auth::user()->can('edit_polls')))
              <td class="cell-answered text-center">
                <h4 class="list-group-item-heading">
                  @if ($poll->answered)
                    <span class="glyphicon glyphicon-check" aria-hidden="true" data-toggle="tooltip" title="Answered"></span>
                  @else
                    <span class="glyphicon glyphicon-unchecked" aria-hidden="true" data-toggle="tooltip" title="Unanswered"></span>
                  @endif
                </h4>{{-- .list-group-item-heading --}}
              </td>{{-- .cell-answered .text-center --}}
            @endif
          </tr>
        @empty
          <tr>
            <td class="cell-lg text-center" colspan="{{ Auth::check() && (Auth::user()->can('delete_polls') || Auth::user()->can('edit_polls')) ? 5 : 4 }}">
                <h1 class="text-muted">
                  <span class="glyphicon glyphicon-search"></span>
                </h1>
                <h2>There aren&apos;t any polls to show.</h2>
                <p>
                  Use the links above to find what you&apos;re looking for.
                  @if (Auth::check())
                    The Filters menu is also super helpful for quickly finding polls most relevant to you.
                  @endif
                </p>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>{{-- .table .table-hover --}}
  </div>{{-- .panel .panel-default --}}
@stop
