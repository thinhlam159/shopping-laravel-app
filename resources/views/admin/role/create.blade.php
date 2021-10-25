@extends('layouts.admin')

@section('title')
    <title>Add role</title>
@endsection

@section('css1')
    <link href="{{asset('vendors/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('admincp/product/create/create.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.content-header', ['name'=>'Role', 'key'=>'Add'])
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
                    <div class="col-md-12">
                        <form method="POST" action="{{route('role.store')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Tên vai trò</label>
                                <input class="form-control" name="name" placeholder="Nhập tên"
                                       value="{{old('name')}}">
                            </div>

                            <div class="form-group">
                                <label>Mô tả vai trò</label>
                                <textarea class="form-control" name="display_name" cols="30"
                                          rows="10">{{old('display_name')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Vai trò</label>
                            </div>
                            @foreach($permissions as $permission)
                                <div class="card border-primary mb-3">
                                    <div class="card-header bg-cyan mb-2">
                                        <label>
                                            <input type="checkbox" class="checkbox_wrapper">
                                            {{$permission->name}}
                                        </label>
                                    </div>
                                    <div class="card-body text-primary">
                                        <div class="row">
                                            @foreach($permission->groupPermission as $value)
                                                <div class="col-md-3">
                                                    <label>
                                                        <input type="checkbox"
                                                               value="{{$value->id}}"
                                                               name="permission_id[]"
                                                               class="checkbox_children"
                                                        >
                                                        {{$value->name}}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <button type="submit" class="btn btn-primary mb-2">Add User</button>
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
    <script src="https://cdn.tiny.cloud/1/fb4v541jw5wrbs8d3afxeat2s4lqxcp2gzaebaqmh9eeuvo5/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
    <script src="{{asset('admincp/product/create/create.js')}}"></script>
    <script>
        $('.checkbox_wrapper').on('click', function () {
            $(this).parents('.card').find('.checkbox_children').prop('checked', $(this).prop('checked'))
        })
    </script>
@endsection
