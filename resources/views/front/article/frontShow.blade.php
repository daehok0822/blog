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

@foreach($images as $key => $image)
    {{$key}}
    <div id="Pop_{{$key}}" class="popup" style="position:absolute; left:50px; top:50px; width:100px; height:100px; z-index:1;">
        <button type="button" >
            X
        </button>
        <img id='popup_original_image_{{$key}}' src="">
    </div>
@endforeach


    <script>
        $('.popup').hide();
        var images = <?=json_encode($images)?>; //php함수를 자바스크립트에서 사용하기 위해
        var app_url = '<?= env('APP_URL') ?>'; //blog.test
        $(document).ready(function () {

            for (var i = 0; i < images.length; i++) {

                $('#popup_original_image_' + i).attr('src', app_url + '/' + images[i].original_image);

                $(document).on('click', '#popup_original_image_' + i, function () { //사진을 클릭하면 팝업되고
                    $('#Pop_' + i).show();
                });
                $(document).on('click', 'button', function () { //x버튼을 누르면 꺼진다
                    $('#Pop_' + i).hide();
                });


            }
        });
    </script>


@endsection
