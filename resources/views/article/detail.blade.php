@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">글 detail view</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <p>제목: {{$article->title}}</p>
                        <p>본문: {{$article->description}}</p>
                    <a href="{{ route('article.edit', ['article' => $article]) }}">수정</a><br>
                    <form action="{{ route('article.destroy', ['article' => $article] )}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="글삭제">
                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
