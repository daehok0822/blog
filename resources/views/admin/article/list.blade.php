@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">글 목록</h1>
@stop

@section('content')
    @foreach($articles as $article)
        <h3><a href="{{ route('article.show', ['article' => $article]) }}">{{ $article->title }}</a></h3>
        작성자:{{$article->user->name}}<br>
        생성일:{{$article->created_at}}최근수정일:{{$article->updated_at}}
    @endforeach

    {{ $articles->links() }}
@stop
