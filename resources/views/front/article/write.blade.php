@extends('front.layout')
@section('articles')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <form action="{{ route('article.store' )}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="title" placeholder="제목"></p>
        <textarea name="description" id="editor1" name="editor1" rows="10" cols="80"></textarea>
        <script>
            CKEDITOR.replace('editor1', {
                filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
                filebrowserUploadMethod: 'form'
            });
        </script>
        <select name="category" >
            <option value="0">- Select -</option>
            @foreach($categories as $category)
                <option value="{{$category -> id}}">{{$category -> name}}</option>
            @endforeach
        </select>
{{--        <input type="hidden" name="image_thumbnail" id="image_thumbnail" >--}}
{{--        <input type="hidden" name="image_origin" id="image_origin">--}}
        <input type="file" id="file_attach" name="attachments[]" style="display: none;">
        <input type="file" name="attachments[]"> <button id='add_button'type="button" onclick="add_attach_file()">파일 추가</button>
        <p><input type="submit"></p>

    </form>
    <script>
        function add_attach_file() {
            var file_attach = $('#file_attach').clone();
            file_attach.removeAttr('id').removeAttr('style');
            $('#add_button').before(file_attach);
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
