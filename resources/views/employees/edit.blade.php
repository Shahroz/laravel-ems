@extends('employees.base')

@section('action-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">Update Employee</div>
        <div class="panel-body">
          {!! Form::model($employee, ['route' => ['employees.update', $employee->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) }}
            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
              {!! Form::label('input-firstname', 'First Name', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('firstname', old('firstname', $employee->firstname), ['class' => 'form-control', 'required' => true, 'autofocus' => true, 'id' => 'input-firstname']) !!}

                @if ($errors->has('firstname'))
                <span class="help-block">
                  <strong>{{ $errors->first('firstname') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('middlename') ? ' has-error' : '' }}">
              {!! Form::label('input-middlename', 'Middle Name', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('middlename', old('middlename', $employee->middlename), ['class' => 'form-control', 'id' => 'input-middlename']) !!}

                @if ($errors->has('middlename'))
                <span class="help-block">
                  <strong>{{ $errors->first('middlename') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
              {!! Form::label('input-lastname', 'Last Name', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('lastname', old('lastname', $employee->lastname), ['class' => 'form-control', 'required' => true, 'id' => 'input-lastname']) !!}

                @if ($errors->has('lastname'))
                <span class="help-block">
                  <strong>{{ $errors->first('lastname') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
              {!! Form::label('input-address', 'Address', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('address', old('address', $employee->address), ['class' => 'form-control', 'required' => true, 'id' => 'input-address']) !!}

                @if ($errors->has('address'))
                <span class="help-block">
                  <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('input-country', 'Country', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-md-6">
                {!! Form::select('country_id', $countries, old('country_id', $employee->country_id), ['class' => 'form-control', 'required' => true, 'id' => 'input-country']) !!}

                @if ($errors->has('country_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('country_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('input-state', 'State', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-md-6">
                {!! Form::select('state_id', $states, old('state_id', $employee->state_id), ['class' => 'form-control', 'required' => true, 'id' => 'input-state']) !!}

                @if ($errors->has('state_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('state_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('input-city', 'City', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-md-6">
                {!! Form::text('city', old('city', $employee->city), ['class' => 'form-control', 'required' => true, 'id' => 'input-city']) !!}

                @if ($errors->has('city'))
                <span class="help-block">
                  <strong>{{ $errors->first('city') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
              {!! Form::label('input-zipcode', 'Zipcode', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-md-6">
                {!! Form::text('zipcode', old('zipcode', $employee->zipcode), ['class' => 'form-control', 'required' => true, 'id' => 'input-zipcode']) !!}

                @if ($errors->has('zipcode'))
                <span class="help-block">
                  <strong>{{ $errors->first('zipcode') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('age') ? ' has-error' : '' }}">
              {!! Form::label('input-age', 'Age', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::number('age', old('age', $employee->age), ['class' => 'form-control', 
                  'required' => true, 'id' => 'input-age', 'pattern' => '[0-9]{2}', 'step' => 1, 'min' => 18, 'max' => 70]) !!}

                @if ($errors->has('age'))
                <span class="help-block">
                  <strong>{{ $errors->first('age') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('input-birthday', 'Birthday', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-md-6">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  {!! Form::text('birthdate', old('birthdate', $employee->birthdate), ['class' => 'form-control pull-right', 'required' => true, 'id' => 'input-birthdate']) !!}
                </div>

                @if ($errors->has('birthdate'))
                <span class="help-block">
                  <strong>{{ $errors->first('birthdate') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('input-date-hired', 'Hired Date', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-md-6">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  {!! Form::text('date_hired', old('date_hired', $employee->date_hired), ['class' => 'form-control pull-right', 'required' => true, 'id' => 'input-date-hired']) !!}
                </div>

                @if ($errors->has('date_hired'))
                <span class="help-block">
                  <strong>{{ $errors->first('date_hired') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('input-department', 'Department', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-md-6">
                {!! Form::select('department_id', $departments, old('department_id', $employee->department_id), ['class' => 'form-control', 'required' => true, 'id' => 'input-department']) !!}

                @if ($errors->has('department_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('department_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('input-division', 'Division', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-md-6">
                {!! Form::select('division_id', $divisions, old('division_id', $employee->division_id), ['class' => 'form-control', 'required' => true, 'id' => 'input-division']) !!}

                @if ($errors->has('division_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('division_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              {!! Form::label('input-avatar', 'Picture', ['class' => 'col-md-4 control-label']) !!}
              <div class="col-md-6">
                {!! Form::file('avatar', null, ['id' => 'input-avatar']) !!}
                @if ($errors->has('avatar'))

                <span class="help-block">
                  <strong>{{ $errors->first('avatar') }}</strong>
                </span>
                @endif
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
