@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@stop


@section('js')
    <script>
        $(document).ready(function () {

            $("#modify_form").hide();
            $('.modifyButton').click(function (e) {
                var user_id = $(this).data('id');

                var user_name = $(this).attr('data-name');
                var user_email = $(this).attr('data-email');

                $( 'input#name' ).val( user_name );
                $( 'input#email' ).val( user_email );


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
                        if(data.result=='실패'){
                            alert('아이디나 이메일을 입력해 주세요')
                        }else{
                            alert('변경되었습니다')
                            $('#user_name_' + data.id).text(name);
                            $('#user_email_' + data.id).text(email);
                            $('#user_data_' + data.id).attr('data-name', name);
                            $('#user_data_' + data.id).attr('data-email', email);
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
        function checkForm() {
            if($('#name').val() == ''){
                alert('이름을 입력하세요.');
                $('#name').focus();
                return false;
            }
            if ($('#email')) {
                alert('이메일을 입력하세요.');
                ($('#email')).focus();
                return false;
            }
            if ($('#password').val() == '0') {
                alert('비밀번호를 입력하세요.');
                $('#password').focus();
                return false;
            }
            return true;
        }
        $("#add_form").hide();
        $('#addButton').click(function (e) {
            $("#add_form").show();
        });
        $("#add_form").submit(function (e) {
            e.preventDefault();
            var url = $(this).attr('action');
            $.post(url, $(this).serialize(),
                function (data) {
                        alert('추가되었습니다');
                        $user = data.user;

                        $( 'tbody' ).append( "" );
                        $("#add_form").hide();

                }, "json");
        });
    </script>
@endsection


@section('content')
    <a href="{{route('admin.user.excel')}}">엑셀로 다운로드</a>

<a id="addButton" type="button" class="btn btn-block btn-default">추가</a>

<form id="add_form" action="{{ route('user.store')}}"
      method="post">
    @csrf
    <input  type="text" name="name" placeholder="이름" >
    <input  type="email" name="email" placeholder="이메일">
    <input  type="password" name="password" placeholder="비밀번호">
    <p><input type="submit" value="추가"></p>
</form>

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

                        <a class="modifyButton" id="user_data_{{ $user->id }}" data-id="{{ $user->id }}" data-name="{{$user->name}}"
                           data-email="{{$user->email}}" type="button"
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
          method="post"  onsubmit="return checkForm()">
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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@endsection
