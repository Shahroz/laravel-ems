@extends('users.base')

@section('action-content')
<div class="container-fluid">
  <div class="row">
    <div class="col-xs-12">
      <div class="panel panel-default">
        <div class="panel-heading">Update User</div>
        <div class="panel-body">
          {!! Form::model($user, ['route' => ['user.update', $user->id], 'method' => 'PUT', 'class' => 'form-horizontal']) !!}

            <div class="form-group{{ $errors->has('username') ? ' has-error' : '' }}">
              {!! Form::label('input-username', 'User Name', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('username', old('username', $user->username), ['class' => 'form-control', 'required' => true, 'autofocus' => true, 'id' => 'input-username']) !!}

                @if ($errors->has('username'))
                <span class="help-block">
                  <strong>{{ $errors->first('username') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              {!! Form::label('input-email', 'Email Address', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::email('email', old('email', $user->email), ['class' => 'form-control', 'required' => true, 'id' => 'input-email']) !!}

                @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
              {!! Form::label('input-firstname', 'First Name', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('first_name', old('first_name', $user->first_name), ['class' => 'form-control', 'required' => true, 'id' => 'input-firstname']) !!}

                @if ($errors->has('first_name'))
                <span class="help-block">
                  <strong>{{ $errors->first('first_name') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
              {!! Form::label('input-lastname', 'Last Name', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::text('last_name', old('last_name', $user->last_name), ['class' => 'form-control', 'required' => true, 'id' => 'input-lastname']) !!}

                @if ($errors->has('last_name'))
                <span class="help-block">
                  <strong>{{ $errors->first('last_name') }}</strong>
                </span>
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('input-password', 'Password', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::password('password', ['class' => 'form-control', 'id' => 'input-password']) !!}

                @if ($errors->has('password'))
                <span class="help-block">
                  <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group">
              {!! Form::label('input-password-confirmation', 'Confirm Password', ['class' => 'col-md-4 control-label']) !!}

              <div class="col-md-6">
                {!! Form::password('password_confirmation', ['class' => 'form-control', 'id' => 'input-password-confirmation']) !!}
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
