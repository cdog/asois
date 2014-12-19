@extends('layouts.page')

@section('title', 'New poll')

@section('content')
  <div class="row">
    <div class="col-sm-6 col-sm-offset-3 col-lg-4 col-lg-offset-4">
      @include('layouts.alerts')
      <div class="panel panel-default">
        <div class="panel-body">
          {{ Form::open() }}
            {{ Form::hidden('answer_id', 2, array('id' => 'answer_id')) }}
            <div class="form-group form-group-lg">
              {{ Form::label('question', 'Question:') }}
              {{ Form::text('question', null, array('class' => 'form-control', 'placeholder' => 'Question')) }}
            </div>{{-- .form-group .form-group-lg --}}
            <hr>
            <div class="form-group">
              {{ Form::label('answer_0', 'Answer:') }}
              {{ Form::text('answer_0', null, array('class' => 'form-control answer', 'placeholder' => 'Answer')) }}
            </div>{{-- .form-group --}}
            <div class="form-group">
              {{ Form::label('answer_1', 'Answer:') }}
              {{ Form::text('answer_1', null, array('class' => 'form-control answer', 'placeholder' => 'Answer')) }}
            </div>{{-- .form-group --}}
            @foreach($answers as $answer)
              <div class="form-group">
                {{ Form::label($answer, 'Answer:') }}
                <div class="input-group">
                  {{ Form::text($answer, null, array('class' => 'form-control answer', 'placeholder' => 'Answer')) }}
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-danger" data-remove="answer">
                      <span class="glyphicon glyphicon-remove"></span>
                    </button>{{-- .btn btn-danger --}}
                  </span>{{-- .input-group-btn --}}
                </div>{{-- .input-group --}}
              </div>{{-- .form-group --}}
            @endforeach
            <p><a href="#" data-add="answer" role="button">Add another answer</a></p>
            {{ Form::button('Submit new poll', array('class' => 'btn btn-success pull-right', 'type' => 'submit')) }}
          {{ Form::close() }}
        </div>{{-- .panel-body --}}
      </div>{{-- .panel .panel-default --}}
    </div>{{-- .col-sm-6 .col-sm-offset-3 .col-lg-4 .col-lg-offset-4 --}}
  </div>{{-- .row --}}
  <script id="answer-template" type="text/x-handlebars-template">
    <div class="form-group">
      <label for="answer_@{{id}}">Answer:</label>
      <div class="input-group">
        <input type="text" class="form-control answer" id="answer_@{{id}}" name="answer_@{{id}}" placeholder="Answer">
        <span class="input-group-btn">
          <button type="button" class="btn btn-danger" data-remove="answer">
            <span class="glyphicon glyphicon-remove"></span>
          </button>{{-- .btn btn-danger --}}
        </span>{{-- .input-group-btn --}}
      </div>{{-- .input-group --}}
    </div>{{-- .form-group --}}
  </script>{{-- #answer-template --}}
@stop
