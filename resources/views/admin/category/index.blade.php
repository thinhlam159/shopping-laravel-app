@extends('layouts.admin')

@section('title')
    <title>admin</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        @include('partials.content-header', ['name'=>'category', 'key'=>'index'])
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="btn btn-success my-2 float-right"><a href="{{ route('categories.create') }}">Add</a></div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Category Slug</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($categories as $key => $category)
                    <tr>
                        <th scope="row">{{ $category->id }}</th>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->slug }}</td>
                        <td>
                            <div class="row">
                                <a href="{{ route('categories.edit', ['category' => $category->id]) }}" class="btn btn-sm btn-success">Edit</a>
                                <form action="{{ route('categories.destroy', ['category' => $category->id]) }}" method="post">
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
                    {{ $categories->links() }}
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

