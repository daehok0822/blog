@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">글생성</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="process_create.blade.php" method="post">
                        <input type="text" name="title" placeholder="제목"></p>
                        <p><textarea name="description" placeholder="본문"></textarea></p>
                        <select name="category" >
                            <option value="0">- Select -</option>
                            @foreach($categories1 as $category)
                                <option value="{{$category -> id}}">{{$category -> name}}</option>
                            @endforeach
                        </select>
                        <p><input type="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
