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
                    <form action="{{ route('admin.index' )}}" method="get">
                        <input type="text" name="searchWord" id="searchWord" class="form-control pull-right" placeholder="검색어를 입력해주세요.">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @foreach($articles as $article)
        <h3><a href="{{ route('article.show', ['article' => $article]) }}">{{ $article->title }}</a></h3>
        작성자:{{$article->user->name}}<br>
        생성일:{{$article->created_at}}최근수정일:{{$article->updated_at}}
    @endforeach

    {{ $articles->links() }}

@stop
