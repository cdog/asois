@extends('layouts.page')

@section('title', 'Events')

@section('content')
  <div class="panel panel-default">
    <table class="table table-hover">
      <tbody>
        @foreach ($events as $event)
          <tr>
            <td class="cell-icon text-center {{ $event->color }}">
              <span class="glyphicon glyphicon-{{ $event->icon }}"></span>
            </td>{{-- .cell-icon .text-center .text-danger --}}
            <td>{{ $event->event }}</td>
            <td class="text-right">
              {{ date('d F Y H:m:s', strtotime($event->created_at)) }}
            </td>{{-- .text-right --}}
          </tr>
        @endforeach
      </tbody>
    </table>{{-- .table .table-hover --}}
  </div>{{-- .panel .panel-default --}}
@stop
