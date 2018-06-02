@extends('layouts.app')

@section('content')
    <div class="cl-container-table">
        @include('layouts.messages')
        <h2>Users</h2>
        <button id="cl-open-user-modal" class="btn cl-add-btn" data-toggle="modal" data-target="#cl-register-user"><i class="icon ion-plus"></i> Add User</button>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="active">#</th>
                    <th class="active">Name</th>
                    <th class="active">Email</th>
                    <th class="active">Role</th>
                    <th class="active">Created At</th>
                    <th class="active">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(count($users) > 0)
                    @foreach($users as $user )
                        <tr id="user-{{$user->id}}">
                            <td>{{$user->id}}</td>
                            <td><a href="{{route('user.edit', $user->id)}}">{{$user->name}}</a></td>
                            <td>{{$user->email}}</td>
                            <td style="text-transform:capitalize">{{$user->type}}</td>
                            <td>{{date('D j/M/y', strtotime($user->created_at))}}</td>
                            <td>
                                {!! Form::open(['url' => route('user.delete', $user->id), 'method' => 'POST', 'class' => 'cl-delete-user', 'data-id' => $user->id]) !!}
                                    {{Form::hidden('_method', 'DELETE')}}
                                    <button class="btn btn-danger">Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                @else
                @endif
            </tbody>
        </table>
        @if(count($errors) > 0)
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger" role="alert">
                    {{$error}}
                </div>
            @endforeach
        @endif
    </div>
    <div class="modal fade" id="cl-register-user" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" >Add User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('register') }}" id="cl-user-form">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="col-form-label">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                            @if ($errors->has('name'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-form-label">{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password" class="col-form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-form-label">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>

                        <div class="form-group">
                            <label for="type" class="col-form-label">{{ __('User Type') }}</label>
                            <div class="radio">
                                <label class="radio-inline"><input type="radio" class="form-control" name="type" value="admin" required checked> <span class="radio-inline">Admin</span></label>
                                <label class="radio-inline"><input type="radio" class="form-control" name="type" value="user" required> <span class="radio-inline">User</span></label>
                            </div>
                            @if ($errors->has('type'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('type') }}</strong>
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" onclick="event.preventDefault(); document.getElementById('cl-user-form').submit();" class="btn btn-primary cl-btn">Save User</button>
                </div>
            </div>
        </div>
    </div>
@endsection
