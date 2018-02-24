@extends('system.division.base')

@section('action-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">Update division</div>
        <div class="panel-body">
          {!! Form::model($division, ['route' => ['system.divisions.update', $division->id], 'id' => 'form-divison', 'class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('input-name', 'Department Name', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('name', old('name', $division->name), ['class' => 'form-control', 'id' => 'input-name', 'autofocus', true, 'required' => true]) !!}

                @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
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
