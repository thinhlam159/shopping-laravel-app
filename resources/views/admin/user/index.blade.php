@extends('layouts.admin')

@section('title')
    <title>Admin User</title>
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
    @include('partials.content-header', ['name'=>'User', 'key'=>'index'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="btn btn-success my-2 float-right"><a href="{{ route('user.create') }}">Add</a></div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $key => $user)
                        <tr>
                            <th scope="row">{{ $user->id }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <div class="row">
                                    <a href="{{ route('user.edit', ['user' => $user->id]) }}"
                                       class="btn btn-sm btn-success">Edit</a>
                                    <form action="{{ route('user.destroy', ['user' => $user->id]) }}" method="post">
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

