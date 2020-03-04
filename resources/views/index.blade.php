@extends('layout')

@section('title')
    환영합니다
@endsection
@section('sitetitle')
    게임 사이트
@endsection

@section('categories')
    @foreach($categories as $category)
        <li>{{$category -> name}}</li>
    @endforeach
@endsection

@section('articles')
    @foreach($articles as $article)
        {{$article -> title}}<br>
        {{$article -> description}}
    @endforeach
@endsection
