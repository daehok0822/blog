<script type="text/javascript">
    $( document ).ready(function() {
        $(".modify_form").hide();

        $('.modifyButton').click(function(e){
            var form_id = $(this).data('id');
            $("#modify_form_" + form_id).show();
            $('#buttons_' + form_id).hide();
        });
    });
</script>

<form action="{{ route('comment.store')}}" method="post">
    @csrf
    <input type="hidden" name="article_id" value="{{ $article->id }}">
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

        <form id="modify_form_{{ $comment->id }}" class="modify_form" action="{{ route('comment.update',['comment' => $comment])}}" method="post">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            <input type="text" name="nickname" value="{{$comment->nickname}}" placeholder="닉네임"></p>
            <input type="text" name="password" placeholder="비밀번호"></p>
            <p><textarea name="description">{{$comment->description}}</textarea></p>
            <p><input type="submit" name="댓글쓰기"></p>
        </form>

        <div id="buttons_{{ $comment->id }}">
            <form action="{{ route('comment.destroy', ['comment' => $comment] )}}" method="post">
                @csrf
                @method('DELETE')
                <input type="submit" value="삭제">
            </form>

            <button class="modifyButton" data-id="{{ $comment->id }}">수정</button>
        </div>

    @endforeach
</ul>
