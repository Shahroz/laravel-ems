@extends('employees.base')

@section('action-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">Update employee</div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="{{ route('employee.update', ['id' => $employee->id]) }}" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PATCH" />
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('firstname') ? ' has-error' : '' }}">
              <label for="input-firstname" class="col-md-4 control-label">First Name</label>

              <div class="col-md-6">
                <input id="input-firstname" type="text" class="form-control" name="firstname"
                  value="{{ old('firstname', $employee->firstname) }}" required autofocus />

                @if ($errors->has('firstname'))
                <span class="help-block">
                  <strong>{{ $errors->first('firstname') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('middlename') ? ' has-error' : '' }}">
              <label for="input-middlename" class="col-md-4 control-label">Middle Name</label>

              <div class="col-md-6">
                <input id="input-middlename" type="text" class="form-control" name="middlename"
                  value="{{ old('middlename', $employee->middlename) }}" />

                @if ($errors->has('middlename'))
                <span class="help-block">
                  <strong>{{ $errors->first('middlename') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('lastname') ? ' has-error' : '' }}">
              <label for="input-lastname" class="col-md-4 control-label">Last Name</label>

              <div class="col-md-6">
                <input id="input-lastname" type="text" class="form-control" name="lastname"
                  value="{{ old('lastname', $employee->lastname) }}" required />

                @if ($errors->has('lastname'))
                <span class="help-block">
                  <strong>{{ $errors->first('lastname') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
              <label for="input-address" class="col-md-4 control-label">Address</label>

              <div class="col-md-6">
                <input id="input-address" type="text" class="form-control" name="address"
                  value="{{ old('address', $employee->address) }}" required />

                @if ($errors->has('address'))
                <span class="help-block">
                  <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label for="input-city" class="col-md-4 control-label">City</label>
              <div class="col-md-6">
                <input id="input-city" type="text" class="form-control" name="city"
                  value="{{ old('city', $employee->city) }}" required />

                @if ($errors->has('city'))
                <span class="help-block">
                  <strong>{{ $errors->first('city') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="input-state">State</label>
              <div class="col-md-6">
                <select class="form-control" name="state_id" id="input-state">
                  @foreach ($states as $state)
                  <option value="{{$state->id}}" {{ old('state_id', $employee->state_id) == $state->id ? 'selected' : '' }}>{{$state->name}}</option>
                  @endforeach
                </select>

                @if ($errors->has('state_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('state_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="input-country">Country</label>
              <div class="col-md-6">
                <select class="form-control" name="country_id" id="input-country">
                  @foreach ($countries as $country)
                  <option value="{{$country->id}}" {{ old('country_id', $employee->country_id) == $country->id ? 'selected' : '' }}>{{$country->name}}</option>
                  @endforeach
                </select>

                @if ($errors->has('country_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('country_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('zipcode') ? ' has-error' : '' }}">
              <label for="input-zipcode" class="col-md-4 control-label">Zip</label>
              <div class="col-md-6">
                <input id="input-zipcode" type="text" class="form-control" name="zipcode"
                  value="{{ old('zipcode', $employee->zipcode) }}" required />

                @if ($errors->has('zipcode'))
                <span class="help-block">
                  <strong>{{ $errors->first('zipcode') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('age') ? ' has-error' : '' }}">
              <label for="input-age" class="col-md-4 control-label">Age</label>

              <div class="col-md-6">
                <input id="input-age" type="number" class="form-control" name="age" pattern="[0-9]{2}" 
                  step="1" min="18" max="70" value="{{ old('age', $employee->age) }}" required />

                @if ($errors->has('age'))
                <span class="help-block">
                  <strong>{{ $errors->first('age') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label for="input-birthdate" class="col-md-4 control-label">Birthday</label>
              <div class="col-md-6">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" value="{{ old('birthdate', $employee->birthdate) }}" name="birthdate" 
                    id="input-birthdate" class="form-control pull-right" required />
                </div>

                @if ($errors->has('birthdate'))
                <span class="help-block">
                  <strong>{{ $errors->first('birthdate') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="input-date-hire">Hired Date</label>
              <div class="col-md-6">
                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" value="{{ old('date_hired', $employee->date_hired) }}" name="date_hired"
                  class="form-control pull-right" id="input-date-hire" required />
                </div>

                @if ($errors->has('date_hired'))
                <span class="help-block">
                  <strong>{{ $errors->first('date_hired') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="input-department">Department</label>
              <div class="col-md-6">
                <select class="form-control" name="department_id" id="input-department">
                  @foreach ($departments as $department)
                  <option value="{{$department->id}}" {{ old('department_id', $employee->department_id) == $department->id ? 'selected' : '' }}>{{$department->name}}</option>
                  @endforeach
                </select>

                @if ($errors->has('department_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('department_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label class="col-md-4 control-label" for="input-devision">Division</label>
              <div class="col-md-6">
                <select class="form-control" name="division_id" id="input-devision">
                  @foreach ($divisions as $division)
                  <option value="{{$division->id}}" {{ old('division_id', $employee->division_id) == $division->id ? 'selected' : '' }}>{{$division->name}}</option>
                  @endforeach
                </select>

                @if ($errors->has('division_id'))
                <span class="help-block">
                  <strong>{{ $errors->first('division_id') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <label for="input-avatar" class="col-md-4 control-label">Picture</label>
              <div class="col-md-6">
                <input type="file" id="input-avatar" name="avatar" />
                @if ($errors->has('avatar'))

                <span class="help-block">
                  <strong>{{ $errors->first('avatar') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  Update
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
