@extends('front.layout')
@section('articles')
    <script src="https://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>

    <form action="{{ route('article.store' )}}" method="post" >
        @csrf
        <input type="text" name="title" placeholder="제목"></p>
        <textarea name="description" id="editor1" name="editor1" rows="10" cols="80"></textarea>
        <script>
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
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
        <input type="file" name="attachments[]"> <button type="button" onclick="">파일 추가</button>
        <p><input type="submit"></p>

    </form>


@endsection
