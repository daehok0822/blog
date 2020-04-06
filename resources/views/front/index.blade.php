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
        @foreach($articles as $key => $article)
            <tr role="row" class="odd">
                <td>
                    @if(!empty($article->thumbnail_image))

                        <img src="{{$article->thumbnail_image}}" style="width:50px;">

                    @else
                        <img
                            src="https://st2.depositphotos.com/1007566/11947/v/950/depositphotos_119474406-stock-illustration-page-document-file-article-icon.jpg"
                            style="width:50px;">
                    @endif

                </td>
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
