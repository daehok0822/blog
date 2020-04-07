@extends('front.layout')
@section('articles')
{{--    <script type="text/javascript">--}}
{{--        $( document ).ready(function() {--}}
{{--            $('img').attr('style','cursor:pointer');--}}
{{--            $('img').click(function(e){--}}
{{--                fnImgPop({{$image->original_image}});--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--    <script type="text/javascript">--}}
{{--        function fnImgPop(url) {--}}
{{--            var img = new Image();--}}
{{--            img.src = url;--}}
{{--            var img_width = img.width;--}}
{{--            var win_width = img.width + 25;--}}
{{--            var img_height = img.height;--}}
{{--            var win = img.height + 30;--}}
{{--            var OpenWindow = window.open('', '_blank', 'width=' + img_width + ', height=' + img_height + ', menubars=no, scrollbars=auto');--}}
{{--            OpenWindow.document.write("<style>body{margin:0px;}</style><img src='" + url + "' width='" + win_width + "'>");--}}
{{--        }--}}

{{--    </script>--}}

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
<script>


    var images = <?=json_encode($images)?>;
    var app_url = '<?= env('APP_URL') ?>';
    $(document).ready(function () {
        for (var i=0; i< images.length; i++) {
            $('img[src="' + app_url + '/' + images[i].description_image + '"]').attr('original_image', images[i].original_image);
            $('img[src="' + app_url + '/' + images[i].description_image + '"]').click(function () {
                window.open(app_url + '/' + $(this).attr('original_image'));
            });
        }
    });

    // for (var i=0; i< images.length; i++) {
    //     console.log(images[i].original_image);
    //     $(document).on('click', 'img[src="' + app_url + '/' + images[i].description_image + '"]', function () {
    //         console.log(images[i]);
    //         window.open(app_url + '/' + images[i].original_image);
    //     });
    // }
</script>
@endsection
