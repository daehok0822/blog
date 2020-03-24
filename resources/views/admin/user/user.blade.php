@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@stop
@section('content')

@section('js')
    <script>
        $(document).ready(function () {

            $("#modify_form").hide();
            $('.modifyButton').click(function (e) {
                var user_id = $(this).data('id');

                var user_name = $(this).data('name');
                var user_email = $(this).data('email');
                // var user_password = $(this).data('password');

                $( 'input#name' ).val( user_name );
                $( 'input#email' ).val( user_email );

                // $( '#password' ).attr( 'value', 'user_password' );

                $("#modify_form").attr('action', '/admin/user/' + user_id);
                $("#modify_form").show();
            });

            $("#delete_form").hide();
            $('.deleteButton').click(function (e) {
                var form_id = $(this).data('id');
                $("#delete_form").show();
            });

            $("#modify_form").submit(function (e) {
                e.preventDefault();
                var name = $(this).find('input[name="name"]').val();
                var email = $(this).find('input[name="email"]').val();
                var password = $(this).find('input[name="password"]').val();
                var url = $(this).attr('action');
                $.post(url, $(this).serialize(),
                    function (data) {
                        console.log(data.result);
                        if(data.result=='실패'){
                            alert('아이디나 이메일을 입력해 주세요')

                        }else{
                            alert('변경되었습니다')
                            $('#user_name_' + data.id).text(name);
                            $('#user_email_' + data.id).text(email);
                            $("#modify_form").hide();
                        }


                    }, "json");
            });
            $("#delete_form").submit(function (e) {
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
@endsection


    <table class="table table-hover">
        <thead>
        <tr>
            <th rowspan="1" colspan="1">이름</th>
            <th rowspan="1" colspan="1">이메일</th>
            <th rowspan="1" colspan="1">생성일</th>
            <th rowspan="1" colspan="1">수정일</th>
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr id="user_{{$user->id}}" role="row" class="odd">
                <td class="sorting_1" id="user_name_{{$user->id}}">{{ $user->name }}</td>
                <td id="user_email_{{$user->id}}">{{$user->email}}</td>
                <td>{{$user->updated_at}}</td>
                <td>{{$user->created_at}}</td>
                <td>
                    <div id="buttons_{{ $user->id }}">
                        <a class="modifyButton" data-id="{{ $user->id }}" data-name="{{$user->name}}"
                           data-email="{{$user->email}}" data-password="{{$user->password}}" type="button"
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
        <input id="name" type="text" name="name" placeholder="이름" >
        <input id="email" type="email" name="email" placeholder="이메일">
        <input id="password" type="password" name="password" placeholder="비밀번호">
        <p><input type="submit" name="수정"></p>
    </form>

    <form id="delete_form" action="{{ route('user.destroy', ['user' => $user] )}}" method="post">
        @csrf
        @method('DELETE')
        <input type="submit" value="전송">
    </form>


@stop
