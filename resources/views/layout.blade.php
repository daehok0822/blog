<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>환영합니다</title>
    <style>
        h1{
            text-align: center;
            border-bottom: 3px solid black;
            margin: 0;
            padding: 20px;
        }
        #categories ul{
            margin: 0;
            border-right: 3px solid black;
            height: 1000px;
            padding: 20px;
        }
        #cat_article{
            display: grid;
            grid-template-columns:200px 1fr ;
        }
    </style>

</head>
<body>
<a href="/login">로그인</a>
<a href="/logout">로그아웃</a>
<a href="/register">회원가입</a>
<link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<form action="{{ route('article.frontIndex' )}}" method="get">
    <input type="text" name="searchWord" id="searchWord" class="form-control pull-right" placeholder="검색어를 입력해주세요.">
    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
</form>
<h1>글 사이트</h1>
<div id="cat_article">
    <div id="categories">
        <ul>
            @foreach($categories as $category)
                <li><a href="{{ route('article.frontIndex') }}/?category_id={{ $category->id }}">{{$category -> name}}</a></li>
            @endforeach
        </ul>
    </div>
    <div id="articles">
        @yield('articles')
    </div>
</div>



</body>
</html>
