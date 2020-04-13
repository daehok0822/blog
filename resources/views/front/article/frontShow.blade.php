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



    <div id="Pop" class="popup" style="position:absolute; left:50px; top:50px; width:100px; height:100px; z-index:1;">
        <button type="button" >
            X
        </button>
        <img id='popup_original_image' src="">

    </div>
    <script>
        $('.popup').hide();
        var images = <?=json_encode($images)?>; //php함수를 자바스크립트에서 사용하기 위해
        var app_url = '<?= env('APP_URL') ?>'; //blog.test
        $(document).ready(function () {

            for (var i = 0; i < images.length; i++) {

                $('#popup_original_image').attr('src', app_url + '/' + images[i].original_image);

                $(document).on('click', 'button', function () {
                    $('.popup').hide();
                });
                $(document).on('click', 'img', function () {
                    $('.popup').show();
                });



            }
        });
    </script>


@endsection
