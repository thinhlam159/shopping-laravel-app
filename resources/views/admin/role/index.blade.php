@extends('layouts.admin')

@section('title')
    <title>Admin Role</title>
@endsection

@section('css1')
    <link rel="stylesheet" href="{{ asset('admincp/product/index/indexList.css') }}">
@endsection

@section('js')

@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.content-header', ['name'=>'Role', 'key'=>'index'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="btn btn-success my-2 float-right"><a href="{{ route('role.create') }}">Add</a></div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Mô tả vai trò</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $key => $role)
                        <tr>
                            <th scope="row">{{ $role->id }}</th>
                            <td>{{ $role->name }}</td>
                            <td>{{ $role->display_name }}</td>
                            <td>
                                <div class="row">
                                    <a href="{{ route('role.edit', ['role' => $role->id]) }}"
                                       class="btn btn-sm btn-success">Edit</a>
                                    <form action="{{ route('role.destroy', ['role' => $role->id]) }}" method="post">
                                        <input class="btn btn-default" type="submit" value="Delete"/>
                                        @method('delete')
                                        @csrf
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

