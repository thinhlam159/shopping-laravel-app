@extends('layouts.admin')

@section('title')
    <title>Edit menu</title>
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
    @include('partials.content-header', ['name'=>'Menu', 'key'=>'Edit'])
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
                        <form method="POST" action="{{route('menu.update', ['menu'=>$menu->id])}}">
                            @method('PUT')
                            @csrf
                            <div class="form-group">
                                <label>Category name</label>
                                <input class="form-control" name="name" placeholder="Menu name"
                                       value="{{$menu->name}}">
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
    <script type="text/javascript">

    </script>
@endsection
