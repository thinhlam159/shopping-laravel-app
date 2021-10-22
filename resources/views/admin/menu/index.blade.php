@extends('layouts.admin')

@section('title')
    <title>Admin</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.content-header', ['name'=>'Menu', 'key'=>'index'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="btn btn-success my-2 float-right"><a href="{{ route('menu.create') }}">Add</a></div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Menu</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($menu as $key => $value)
                        <tr>
                            <th scope="row">{{ $value->id }}</th>
                            <td>{{ $value->name }}</td>
                            <td>
                                <div class="row">
                                    <a href="{{ route('menu.edit', ['menu' => $value->id]) }}" class="btn btn-sm btn-success">Edit</a>
                                    <form action="{{ url('/menu', ['id' => $value->id]) }}" method="post">
                                        <input class="btn btn-default" type="submit" value="Delete" />
                                        @method('delete')
                                        @csrf
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="col-md-12">
                    {{ $menu->links() }}
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

