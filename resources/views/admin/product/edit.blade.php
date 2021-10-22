@extends('layouts.admin')

@section('title')
    <title>Edit product</title>
@endsection

@section('css1')
    <link href="{{asset('vendors/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('admincp/product/create/create.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.content-header', ['name'=>'Product', 'key'=>'Edit'])
    <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST" action="{{route('product.update', ['product'=>$product->id])}}">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>Category name</label>
                                <input class="form-control" name="name" placeholder="Menu name"
                                       value="{{$product->name}}">
                            </div>
                            <div class="form-group">
                                <label>Giá bán</label>
                                <input class="form-control" name="price" placeholder="Giá bán"
                                       value="{{$product->price}}">
                            </div>
                            <div class="form-group">
                                <label>Ảnh đại diện</label>
                                <input type="file" class="form-control-file" name="feature_image_path">
                            </div>
                            <div class="form-group">
                                <label>Ảnh chi tiết</label>
                                <input type="file" class="form-control-file" name="image_path[]" multiple>
                            </div>
                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="contents" cols="30" rows="10" class="form-control my-editor">
                                    {{ $product->content }}
                                </textarea>
                            </div>
                            <div class="form-group">
                                <label>Chọn tags cho sp</label>
                                <select name="tags[]" class="form-control tags-select-choosen" multiple="multiple">

                                </select>
                            </div>

                            <div class="form-group">
                                <label>Category parent</label>
                                <select class="form-control" name="parent_id">
                                    <option value="0">Category parent</option>
                                    {!! $menuSelectHtml !!}
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Save</button>
                        </form>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@section('js')
    <script src="{{asset('vendors/select2/select2.min.js')}}"></script>
    <script src="https://cdn.tiny.cloud/1/fb4v541jw5wrbs8d3afxeat2s4lqxcp2gzaebaqmh9eeuvo5/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="{{asset('admincp/product/create/create.js')}}"></script>
@endsection
