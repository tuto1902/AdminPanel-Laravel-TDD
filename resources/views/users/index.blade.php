@extends('layouts.admin-lte')

@section('styles')
    <style>
        .user-panel>.info {
            position: initial;
        }
        .box-header {
            padding: 15px;
        }
    </style>
    @endsection

    @section('content')
            <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Users
            <small>User Administration</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Users</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <div class="box-tools pull-right">
                            <a href="/users/create" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Create User</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td><a href="/users/{{$user->id}}/edit">{{$user->name}}</a></td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <form action="/users/{{$user->id}}" method="POST">
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection