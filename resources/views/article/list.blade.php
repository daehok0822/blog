@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">글 목록</h1>
@stop

@section('content')
    @foreach($articles as $article)
        <h3>{{$article->title}}</h3>{{$article->user->name}}
        <a href="{{ route('article.edit', ['article' => $article]) }}">수정</a><br>
        {{$article->description}}
    @endforeach


@stop
