@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <p class="mb-0">You are logged in!</p>
                    <form action="/home" method="post">
                        <input type="text" name="searchWord" id="searchWord" class="form-control pull-right" placeholder="검색어를 입력해주세요.">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>

                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
