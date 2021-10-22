@extends('layouts.admin')

@section('title')
    <title>Admin Product</title>
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
    @include('partials.content-header', ['name'=>'Product', 'key'=>'index'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="btn btn-success my-2 float-right"><a href="{{ route('product.create') }}">Add</a></div>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Hình ảnh</th>
                        <th scope="col">Danh mục</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $key => $product)
                        <tr>
                            <th scope="row">{{ $product->id }}</th>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }}</td>
                            <td><img class="product-list-image__120-100" src="{{ $product->feature_image_path }}" alt="image"></td>
                            <td>{{ optional($product->category)->name }}</td>
                            <td>
                                <div class="row">
                                    <a href="{{ route('product.edit', ['product' => $product->id]) }}"
                                       class="btn btn-sm btn-success">Edit</a>
                                    <form action="{{ route('product.destroy', ['product' => $product->id]) }}" method="post">
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
                <div class="col-md-12">
                    {{ $products->links() }}
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

