@extends('layout')
@section('articles')
    <h3>{{ $article->title }}</h3>
    글쓴이: {{$article->user->name}} |
    작성일: {{$article->created_at}} | 최근 수정일: {{$article->updated_at}}
    <p>{{$article->description}}</p>
    @include('comment')
@endsection
