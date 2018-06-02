@extends('layouts.app')

@section('content')

<div class="container" style="margin-top:100px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h2>{{ __('Edit User') }}</h2></div>

                <div class="card-body">
                    {!! Form::open(['action' => ['UserController@update', $user->id], 'method' => 'POST']) !!}
                        <div class="form-group">
                            {{Form::label('name', 'Name')}}
                            {{Form::text('name', $user->name, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('email', 'E-mail Address')}}
                            {{Form::email('email', $user->email, ['class' => 'form-control'])}}
                        </div>
                        <div class="form-group">
                            {{Form::label('password', 'Password')}}
                            {{Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password'])}}
                        </div>
                        <div class="form-group">
                            <label for="type">{{ __('User Type') }}</label>
                            <div class="radio">
                                <label class="radio-inline"><input type="radio" class="form-control" name="type" value="admin" required checked> <span class="radio-inline">Admin</span></label>
                                <label class="radio-inline"><input type="radio" class="form-control" name="type" value="user" required> <span class="radio-inline">User</span></label>
                            </div>
                        </div>
                        
                        {{Form::hidden('_method', 'PUT')}}
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary cl-btn">
                                {{ __('Save') }}
                            </button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection