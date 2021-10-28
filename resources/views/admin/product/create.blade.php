@extends('layouts.admin')

@section('title')
    <title>Add product</title>
@endsection

@section('css1')
    <link href="{{asset('vendors/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('admincp/product/create/create.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.content-header', ['name'=>'Product', 'key'=>'Add'])
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
                        <form method="POST" action="{{route('product.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input class="form-control" name="name" placeholder="Tên sản phẩm"
                                       value="{{old('name')}}">
                            </div>
                            <div class="form-group">
                                <label>Giá bán</label>
                                <input class="form-control" name="price" placeholder="Giá bán"
                                       value="{{old('price')}}">
                            </div>
                            <div class="form-group form-main-image-upload">
                                <div class="form-upload">
                                    <label for="main-image" class="form-upload__title">
                                        <p>Ảnh đại diện</p>
                                        <a class="btn btn-success">Upload</a>
                                    </label>
                                    <a class="btn btn-danger btn-clear ml-3">Clear</a>
                                    <input type="file"
                                           class="form-control-file form-upload__control js-form-upload-control"
                                           name="feature_image_path"
                                           id="main-image"
                                    >
                                    <div class="form-upload__preview d-flex justify-content-center mt-1"></div>
                                </div>
                            </div>
                            <div class="form-group form-image-detail-upload">
                                <div class="form-upload">
                                    <label for="detail-image" class="form-upload__title">
                                        <p>Ảnh chi tiết</p>
                                        <a class="btn btn-success">Upload</a>
                                    </label>
                                    <a class="btn btn-danger btn-clear ml-3">Clear</a>
                                    <input type="file"
                                           class="form-control-file form-upload__control js-form-upload-control"
                                           name="image_path[]"
                                           id="detail-image"
                                           multiple>
                                    <div class="form-upload__preview d-flex justify-content-sm-between mt-1"></div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Nội dung</label>
                                <textarea name="contents" cols="30" rows="10" class="form-control my-editor"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Chọn tags cho sp</label>
                                <select name="tags[]" class="form-control tags-select-choosen" multiple="multiple">

                                </select>
                            </div>

                            <div class="form-group">
                                <label>Category</label>
                                <select class="form-control select2-init" name="category_id">
                                    {{--                                    <option value="0">Menu parent</option>--}}
                                    {!! $categorySelectHtml !!}
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Add Menu</button>
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
