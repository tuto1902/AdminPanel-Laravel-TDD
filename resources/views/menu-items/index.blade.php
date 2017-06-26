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
            Menu Items
            <small>Menu Items Administration</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Menu Items</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header">
                        <div class="box-tools pull-right">
                            <a href="/menu-items/create" class="btn btn-info btn-sm"><i class="fa fa-plus"></i> Create Menu Item</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Text</th>
                                    <th>Link</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($menuItems as $menuItem)
                                <tr>
                                    <td>{{$menuItem->id}}</td>
                                    <td><a href="/users/{{$menuItem->id}}/edit">{{$menuItem->text}}</a></td>
                                    <td>{{$menuItem->link}}</td>
                                    <td>
                                        <form action="/menu-items/{{$menuItem->id}}" method="POST">
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