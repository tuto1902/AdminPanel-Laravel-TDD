@extends('layouts.admin-lte')

@section('styles')
    <style>
        .user-panel>.info {
            position: initial;
        }
    </style>
    @endsection

    @section('content')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Create User
            <small>Create new user</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/users"><i class="fa fa-dashboard"></i> Users</a></li>
            <li class="active">Create User</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <form role="form" action="/users" method="POST">
                        {{ csrf_field() }}
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('name') ? "has-error" : ""}}">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" value="{{old('name')}}">
                                @if($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('email') ? "has-error" : ""}}">
                                <label for="name">Email</label>
                                <input type="email" name="email" class="form-control" value="{{old('email')}}">
                                @if($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('password') ? "has-error" : ""}}">
                                <label for="name">Password</label>
                                <input type="password" name="password" class="form-control" value="">
                                @if($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="name">Password Confirmation</label>
                                <input type="password" name="password_confirmation" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label>Menu Items</label>
                                <select name="menu-items[]" class="form-control" multiple>
                                    @foreach($menuItems as $menuItem)
                                        <option value="{{$menuItem->id}}">{{$menuItem->text}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection