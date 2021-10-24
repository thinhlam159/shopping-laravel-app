@extends('layouts.admin')

@section('title')
    <title>Edit User</title>
@endsection

@section('css1')
    <link href="{{asset('vendors/select2/select2.min.css')}}" rel="stylesheet">
    <link href="{{asset('admincp/product/create/create.css')}}" rel="stylesheet">
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.content-header', ['name'=>'User', 'key'=>'Edit'])
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
                        <form method="POST" action="{{route('user.update', ['user'=>$user->id])}}">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>Tên </label>
                                <input class="form-control" name="name" placeholder="Nhập tên"
                                       value="{{$user->name}}">
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input class="form-control" name="email" placeholder="Nhập email"
                                       value="{{$user->email}}">
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" name="password" value="" placeholder="Nhập password">
                            </div>
                            <div class="form-group">
                                <label>Vai trò</label>
                                <Select name="roles[]" class="form-control tags-select-choosen" multiple>
                                    {{--                                    <option value="">Chọn vai trò</option>--}}
                                    @foreach($roles as $role)
                                        <option
                                            {{ $roleUsers->contains('id', $role->id) ? 'selected' : '' }}
                                            value="{{ $role->id }}"
                                        >
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </Select>
                            </div>
                            <button type="submit" class="btn btn-primary mb-2">Lưu</button>
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
