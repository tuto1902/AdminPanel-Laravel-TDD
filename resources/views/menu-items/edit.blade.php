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
            Update Menu Item
            <small>Update menu item</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="/menu-items">Menu Items</a></li>
            <li class="active">Update Menu Item</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box">
                    <form role="form" action="/menu-items/{{$menuItem->id}}" method="POST">
                        {{ csrf_field() }}
                        <input type="hidden" name="_method" value="PUT">
                        <div class="box-body">
                            <div class="form-group {{ $errors->has('text') ? "has-error" : ""}}">
                                <label for="name">Text</label>
                                <input type="text" name="text" class="form-control" value="{{$menuItem->text}}">
                                @if($errors->has('text'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('text') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group {{ $errors->has('link') ? "has-error" : ""}}">
                                <label for="name">Link</label>
                                <input type="text" name="link" class="form-control" value="{{$menuItem->link}}">
                                @if($errors->has('link'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('link') }}</strong>
                                    </span>
                                @endif
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