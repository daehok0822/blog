@extends('front.layout')
@section('articles')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <form id="write-form" action="{{ route('article.store' )}}" method="post" enctype="multipart/form-data" onsubmit="return checkForm()">
        @csrf
        <input type="text" id="title" name="title" placeholder="제목"></p>
        <textarea name="description" id="editor1" rows="10" cols="80"></textarea>
        <script>
            var editor = CKEDITOR.replace('editor1', {
                filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });

        </script>
        <select name="category" id="category">
            <option value="0">- Select -</option>
            @foreach($categories as $category)
                <option value="{{$category -> id}}">{{$category -> name}}</option>
            @endforeach
        </select>
{{--        <input type="hidden" name="image_thumbnail" id="image_thumbnail" >--}}
{{--        <input type="hidden" name="image_origin" id="image_origin">--}}
        <input type="file" class="file-attach" name="attachments[]">
        <input type="file" id="file_attach_init" name="attachments[]" style="display: none;">
        <button type="button" id="file_add" onclick="add_attach_file()">파일 추가</button>
        <p><input type="submit"></p>

    </form>
    <script>
        function add_attach_file() {
            var file_attach = $('#file_attach_init').clone();
            file_attach.removeAttr('id').removeAttr("style");;
            $('#file_add').before(file_attach);
        }
        function checkForm() {
            if ($('#title').val() == '') {
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
            if ($('#category').val() == '0') {
                alert('카테고리를 선택하세요.');
                $('#category').focus();
                return false;
            }
            return true;
        }
    </script>
{{--<script>--}}
{{--    function imageUpload(data)--}}
{{--    {--}}
{{--        alert(data.url);--}}
{{--        return;--}}
{{--        $('#image_thumbnail').val(data.image_thumbnail);--}}
{{--        $('#image_origin').val(data.image_origin);--}}
{{--        window.parent.CKEDITOR.tools.callFunction(data.CKEditorFuncNum, data.url, data.msg);--}}
{{--    }--}}
{{--</script>--}}

@endsection
