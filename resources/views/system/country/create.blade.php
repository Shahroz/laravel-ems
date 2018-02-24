@extends('system.country.base')

@section('action-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">Add new country</div>
        <div class="panel-body">
            {!! Form::open(['route' => 'system.countries.store', 'id' => 'form-country', 'class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('input-name', 'Country Name', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('name', old('name'), ['class' => 'form-control', 'id' => 'input-name', 'autofocus', true, 'required' => true]) !!}

                @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
              {!! Form::label('input-code', 'Country Code', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('code', old('code'), ['class' => 'form-control', 'id' => 'input-code', 'required' => true]) !!}
                @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                {!! Form::submit('Create', ['class' => 'btn btn-primary']) !!}
              </div>
            </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
