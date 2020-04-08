@extends('front.layout')
@section('articles')

    <h3>{{ $article->title }}</h3>
    글쓴이: {{$article->user->name}} |
    작성일: {{$article->created_at}} | 최근 수정일: {{$article->updated_at}}
    <p>{!! $article->description !!}</p>
    @include('front.article.comment')
<script>

    var images = <?=json_encode($images)?>; //php함수를 자바스크립트에서 사용하기 위해
    var app_url = '<?= env('APP_URL') ?>'; //blog.test
    $(document).ready(function () {
        for (var i = 0; i < images.length; i++) {
            $('img[src="' + app_url + '/' + images[i].description_image + '"]').attr('original_image', images[i].original_image);
            $(document).on('click', 'img[src="' + app_url + '/' + images[i].description_image + '"]', function () {
                console.log($(this).attr('original_image'));
                window.open(app_url + '/' + $(this).attr('original_image'));

            });
        }
    });
</script>
@endsection
