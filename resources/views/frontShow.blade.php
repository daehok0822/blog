@extends('layout')
@section('articles')
    <h3>{{ $article->title }}</h3>
    작성자:{{$article->user->name}}<br>
    생성일:{{$article->created_at}}최근수정일:{{$article->updated_at}}
    <p>{{$article->description}}</p>
    @include('comment', ['comments' => $comments])
@endsection
