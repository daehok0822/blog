@extends('front.layout')
@section('articles')
    <h3>{{ $article->title }}</h3>
    글쓴이: {{$article->user->name}} |
    작성일: {{$article->created_at}} | 최근 수정일: {{$article->updated_at}}
    <p>{!! $article->description !!}</p>
    <ul>
        @foreach($files as $file)
            <li><a href="{{ route('front.filedown', ['id' => $file->id]) }}">{{ $file->original_name }}</a></li>
        @endforeach
    </ul>
    @include('front.article.comment')

    <div id="popup" style="display:none; position:absolute; left:50px; top:50px; width:100px; height:100px; z-index:1;">
        <button id="xbutton" type="button">
            X
        </button>
        <img id="layer" src="">
    </div>

    <script>

        $(document).ready(function () {
            $('#articles img').click(function () {
                var src = $(this).attr('src');

                var ext = src.substr(src.lastIndexOf('.') + 1);
                var filename = src.split('.').slice(0, -1).join('.');
                var original_image =  filename + '.' + ext ;
                console.log(original_image);
                 $('#layer').attr('src', original_image); //따옴표 없어서 에러난 거
                $('#popup').show();
            });
            $('#xbutton').click(function () {
                $('#popup').hide();
            });
        });
    </script>


@endsection
