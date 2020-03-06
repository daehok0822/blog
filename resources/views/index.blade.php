@extends('layout')


@section('articles')
    @foreach($articles as $article)
        <h3><a href="{{ route('article.frontShow', ['id' => $article->id]) }}">{{ $article->title }}</a></h3>
        작성자:{{$article->user->name}}<br>
        생성일:{{$article->created_at}}최근수정일:{{$article->updated_at}}
    @endforeach
@endsection
