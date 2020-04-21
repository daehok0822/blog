@extends('front.layout')


@section('articles')
    <script type="text/javascript">
        $(document).ready(function () {
            //삭제를 누르면 이 제이쿼리
            $(".articleDelete").submit(function (e) {
                e.preventDefault();
                if (confirm("정말 삭제하시겠습니까??") == true) {
                    var url = $(this).attr('action');
                    $.post(url, $(this).serialize(),
                        function (data) {
                            if (data.result == 'success') {
                                alert('삭제했습니다')
                            }
                        }, "json");

                } else {
                }
            })
        });
    </script>
    <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
           aria-describedby="example2_info">
        <thead>
        <tr>
            <th rowspan="1" colspan="1"></th>
            <th rowspan="1" colspan="1">제목</th>
            <th rowspan="1" colspan="1">글쓴이</th>
            <th rowspan="1" colspan="1">작성일</th>
            <th rowspan="1" colspan="1"></th>
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
                <td>
                        <a href="{{ route('article.edit', ['article' => $article])}}" class="btn btn-block btn-default">수정</a>
                    <form class="articleDelete" action="{{ route('article.destroy', ['article' => $article] )}}" method="post">
                        @csrf
                        @method('DELETE')
                        <input type="submit" value="삭제">
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {{ $articles->links() }}
@endsection

