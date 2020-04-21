@extends('front.layout')
@section('articles')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
    <script src="https://www.google.com/recaptcha/api.js?render=6LdaW-kUAAAAABZ7-zrVak0baJp1e5-CSAUjRCeJ"></script>
    <form action="{{ route('article.update', ['article' => $article])}}" enctype="multipart/form-data" onsubmit="return checkFormM()" method="post">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <input id="title" type="text" name="title" placeholder="제목" value="{{$article->title}}"></p>
        <textarea name="description" id="editor1" rows="10" cols="80">{{$article->description}}</textarea>
        <script>
            var editor = CKEDITOR.replace('editor1', {
                filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });
        </script>
        <select name="category" id="category">
            <option value="">- Select -</option>
            @foreach($categories as $category)
                @if($category->id === $article->category_id)
                    <option value="{{$category -> id}}" selected="selected">{{$category -> name}}</option>
                @else
                    <option value="{{$category -> id}}">{{$category -> name}}</option>
                @endif
            @endforeach
        </select>
        <input type="file" data="" id="file_attach" name="attachments[]" style="display: none;">
        <input type="file" name="attachments[]">
        <button id='add_button'type="button" onclick="add_attach_file()">파일 추가</button>
        <p><input type="submit"></p>

        <input type="hidden" id="g-recaptcha" name="g-recaptcha">
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <script type="text/javascript">
        grecaptcha.ready(function() {
            grecaptcha.execute('6LdaW-kUAAAAABZ7-zrVak0baJp1e5-CSAUjRCeJ', {action: 'homepage'}).then(function(token) {
                // 토큰을 받아다가 g-recaptcha 에다가 값을 넣어줍니다.
                document.getElementById('g-recaptcha').value = token;
            });
        });
    </script>

    <script>
        var fileCount = 1;
        function add_attach_file() {
            if(fileCount >= 5){
                alert('파일은 총 5개까지 업로드 가능합니다.');
                return false;
            }
            fileCount = fileCount + 1;
            var file_attach = $('#file_attach').clone();
            file_attach.removeAttr('id').removeAttr('style');
            $('#add_button').before(file_attach);
        }
    </script>

    <script>
        function checkFormM() {
            if($('#title').val() == ''){
                alert('제목을 입력하세요.');
                $('#title').focus();
                return false;
            }
            var desc = editor.getData();
            if (desc == '') {
                alert('본문을 입력하세요.');
                editor.focus();
                return false;
            }
            if ($('#category').val() == '') {
                alert('카테고리를 선택하세요.');
                $('#category').focus();
                return false;
            }
            return true;
        }
    </script>

@endsection
