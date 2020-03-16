@extends('layout')


@section('articles')
    <ul>
        @foreach($articles as $article)
            <li>
                <h3><a href="{{ route('article.frontShow', ['id' => $article->id]) }}">{{ $article->title }}</a></h3>
                작성자:{{$article->user->name}}<br>
                생성일:{{$article->created_at}}최근수정일:{{$article->updated_at}}
            </li>
        @endforeach
    </ul>

    {{ $articles->links() }}
@endsection
