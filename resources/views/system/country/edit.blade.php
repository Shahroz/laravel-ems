@extends('system.country.base')

@section('action-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">Update country</div>
        <div class="panel-body">
            {!! Form::model($country, ['route' => ['system.countries.update', $country->id], 'method' => 'PUT', 'id' => 'form-country', 'class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('input-name', 'Country Name', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('name', old('name', $country->name), ['class' => 'form-control', 'id' => 'input-name', 'autofocus', true]) !!}

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
                {!! Form::text('code', old('code', $country->code), ['class' => 'form-control', 'id' => 'input-code']) !!}
                @if ($errors->has('code'))
                <span class="help-block">
                  <strong>{{ $errors->first('code') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                {!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
