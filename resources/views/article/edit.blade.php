@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">글생성</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('article.store' )}}" method="post">
                        @csrf
                        <input type="text" name="title" placeholder="제목" value="{{$article->title}}"></p>
                        <p><textarea name="description" placeholder="본문">{{$article->description}}</textarea></p>
                        <select name="category" >
                            <option value="0">- Select -</option>
                            @foreach($categories as $category)
                                @if($category->id === $article->id)
                                    <option value="{{$category -> id}}" selected="selected">{{$category -> name}}</option>
                                    @else
                                    <option value="{{$category -> id}}">{{$category -> name}}</option>
                                @endif
                            @endforeach
                        </select>
                        <p><input type="submit"></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
