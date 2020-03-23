<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Nanum+Gothic:400,700,800&display=swap&subset=korean" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
    <title>환영합니다</title>
    <style>
        body {

            margin: 0;
        }

        ul {
            list-style: none;
        }

        #TopScreen {
            background-color: #B6C5C8;
        }
        #login_links ul{
            padding-left: 12px;
        }

        #login_links li {
            float: left;
            font-weight: 500;
            margin: 0;
        }

        #login_links .saparate li::after {
            content: "|";
            margin: 0;
            padding: 0 3px 0 5px;
        }

        #site_title{
            margin: 0 auto;
            width: 300px;

        }

        h1 {
            margin: 0;
            padding: 20px;
            font-family: 'Nanum Gothic', sans-serif;
            font-size: 50px;
            font-weight: bold

        }

        #search_bar {
            border-bottom: 1px solid #4b413e;
            padding-left: 15px;
        }

        #BottomScreen {
            display: grid;
            grid-template-columns: 200px 1fr;

        }

        #articles {
            /*background-color: rgb(212,222,224);*/
            border-left: 1px solid #644756;
            border-bottom: 1px solid #644756;
            padding: 20px;

        }

        #categories{
            background-color: rgb(233,233,233);
            /*background-color: rgb(212,222,224);*/
        }
        #categories ul {
            font-size: 17px;
            font-weight: 600;
            color: #644756;
            padding: 20px;
            line-height: 30px;
        }


        #login_links a:link {
            color: #644756;
            text-decoration: none;
        }

        #login_links a:visited {
            color: #644756;
            text-decoration: none;
        }

        #login_links a:hover {
            color: #644756;
            text-decoration: underline;
        }

        #site_title a:link {
            color: #644756;
            text-decoration: none;
            text-align: center;
        }

        #site_title a:visited {
            color: #644756;
            text-decoration: none;
        }

        #site_title a:hover {
            color: #644756;
        }

        #categories a:link {
            color: #644756;
            text-decoration: none;
        }

        #categories a:visited {
            color: #644756;
            text-decoration: none;
        }

        #categories a:hover {
            color: #644756;
            text-decoration: underline;
        }

        #articles a:link {
            color: #644756;
            text-decoration: none;
        }

        #articles a:visited {
            color: #644756;
            text-decoration: none;
        }

        #articles a:hover {
            color: #644756;
            text-decoration: underline;
        }


    </style>
    @include('auth/logout_form')
    <script>
        $(document).ready(function(){
            $('#logout').click(function (ev) {
                ev.preventDefault();
                $('#logout-form').submit();
            });
        });
    </script>
</head>
<body>
<div id="TopScreen" style="margin:0 auto;">
    <div id="login_links">
        <ul style="margin:0">
            <div class="saparate">
                {!! $separate !!}
            </div>
        </ul>
    </div>


    <div id="site_title">
        <h1><a href="{{ route('front.index') }}">게임 사이트</a></h1>
    </div>

    <div id="search_bar">
        <form action="{{ route('front.index' )}}" method="get" >
            <input style="border: 0" type="text" name="searchWord" id="searchWord" placeholder="검색">
{{--            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i><img src="https://www.codingfactory.net/wp-content/uploads/button_search.png"></button>--}}
            <button style="border: 0"><i class="fa fa-search"></i></button>
        </form>
    </div>





</div>


<div id="BottomScreen">
    <div id="categories">
        <ul>
            @foreach($categories as $category)
                <li><a href="{{ route('front.index') }}/?category_id={{ $category->id }}">{{$category -> name}}</a></li>
            @endforeach
        </ul>
    </div>
    <div id="articles">
        @yield('articles')
    </div>
</div>



</body>
</html>
