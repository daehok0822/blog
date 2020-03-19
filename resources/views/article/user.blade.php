@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
@stop
@section('content')
    <table id="example2" class="table table-bordered table-hover dataTable" role="grid"
           aria-describedby="example2_info">
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
            <tr role="row" class="odd">
                <td class="sorting_1">{{ $user->name }}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->password}}</td>
                <td>{{$user->updated_at}}</td>
                <td>{{$user->created_at}}</td>
            </tr>
        @endforeach
    </table>

@stop
