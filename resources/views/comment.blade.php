<form action="{{ route('comment.store' )}}" method="post">
    @csrf
    <input type="text" name="nickname" placeholder="닉네임"></p>
    <input type="text" name="password" placeholder="비밀번호"></p>
    <p><textarea name="description"></textarea></p>
    <p><input type="submit" name="댓글쓰기"></p>
</form>
<ul>
    @foreach($comments as $comment)
        <li>{{$comment -> nickname}}</li>
        <li>{{$comment -> description}}</li>
        <li>생성일:{{$comment->created_at}}최근수정일:{{$comment->updated_at}}</li>
    @endforeach
</ul>
