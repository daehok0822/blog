@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@stop
@section('content')



    <script type="text/javascript">
        $( document ).ready(function() {
            $("#modify_form").hide();
            $('.modifyButton').click(function(e){
                $("#modify_form").show();
            });
        });
    </script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $("#delete_form").hide();
            $('.deleteButton').click(function(e){
                $("#delete_form").show();
            });
        });
    </script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $("#modify_form").submit(function(e) {
                e.preventDefault();
                var name = $(this).find('text[name="name"]').val();
                var email = $(this).find('email[name="email"]').val();
                var password = $(this).find('password[name="password"]').val();
                var url = $(this).attr('action');
                $.post(url, $(this).serialize(),
                    function (data) {
                        $('#user_name_' + data.id).text(name);
                        $('#user_email_' + data.id).text(email);
                        $("#modify_form").hide();
                    }, "json");
            })
        });
    </script>
    <script type="text/javascript">
        $( document ).ready(function() {
            $(".delete_form").submit(function(e) {
                e.preventDefault();
                var url = $(this).attr('action');
                $.post(url, $(this).serialize(),
                    function (data) {
                        $('#user_' + data.id).remove();
                        $("#delete_form").hide();
                    }, "json");
            })
        });
    </script>
    <table class="table table-hover">
        <thead>
        <tr>
            <th rowspan="1" colspan="1">이름</th>
            <th rowspan="1" colspan="1">이메일</th>
            <th rowspan="1" colspan="1">비밀번호</th>
            <th rowspan="1" colspan="1">생성일</th>
            <th rowspan="1" colspan="1">수정일</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr id="user_{{$user->id}}" role="row" class="odd">
                <td class="sorting_1" id="user_name_{{$user->id}}">{{ $user->name }}</td>
                <td id="user_email_{{$user->id}}">{{$user->email}}</td>
                <td>{{$user->password}}</td>
                <td>{{$user->updated_at}}</td>
                <td>{{$user->created_at}}</td>
                <td>
                    <div id="buttons_{{ $user->id }}">
                        <a class="modifyButton" data-id="{{ $user->id }}" type="button"
                           class="btn btn-block btn-default">수정</a>
                        <a class="deleteButton" data-id="{{ $user->id }}" type="button"
                           class="btn btn-block btn-default">삭제</a>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <form id="modify_form" action="{{ route('user.update',['user' => $user])}}"
          method="post">
        @csrf
        <input type="hidden" name="_method" value="PUT">
        <input type="text" name="name" placeholder="이름">
        <input type="email" name="email" placeholder="이메일">
        <input type="password" name="password" placeholder="비밀번호">
        <p><input type="submit" name="수정"></p>
    </form>

    <form id="delete_form" action="{{ route('user.destroy', ['user' => $user] )}}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="전송">
    </form>


@stop
