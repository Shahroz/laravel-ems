@extends('system.state.base')

@section('action-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">Update state</div>
        <div class="panel-body">
          {!! Form::model($state, ['route' => ['system.states.update', $state->id], 'method' => 'PUT', 'id' => 'form-state', 'class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('input-name', 'State Name', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('name', old('name', $state->name), ['class' => 'form-control', 'id' => 'input-name', 'autofocus', true, 'required' => true]) !!}

                @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('input-country', 'Country', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-md-6">
                {!! Form::select('country_id', $countries, old('country_id', $state->country_id), ['class' => 'form-control', 'required' => true, 'id' => 'input-country']) !!}
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
