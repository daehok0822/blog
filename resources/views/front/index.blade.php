@extends('front.layout')


@section('articles')
    <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
           aria-describedby="example2_info">
        <thead>
        <tr>
            <th rowspan="1" colspan="1"></th>
            <th rowspan="1" colspan="1">제목</th>
            <th rowspan="1" colspan="1">글쓴이</th>
            <th rowspan="1" colspan="1">작성일</th>
        </tr>
        </thead>
        <tbody>
        @foreach($articles as $article)
            <tr role="row" class="odd">
{{--                <td>{!! --}}
{{--if(!empty($article->image->thumbnail_image)){--}}
{{--        --}}
{{--}!!}</td>--}}
                <td class="sorting_1">
                    <a href="{{ route('article.show', ['article' => $article]) }}">{{ $article->title }}</a>
                </td>
                <td>{{$article->user->name}}</td>
                <td>{{$article->created_at}}</td>
            </tr>
        @endforeach
    </table>

    {{ $articles->links() }}
@endsection
