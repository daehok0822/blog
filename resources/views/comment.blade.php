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
<script type="text/javascript">
    $( document ).ready(function() {
        $(".modify_form").submit(function(e) {
            e.preventDefault();
            var des = $(this).find('textarea[name="description"]').val();
            var url = $(this).attr('action');
            $.post(url, $(this).serialize(),
                function (data) {
                    // $('#comment_description_' + data.id).text(data.description);
                    $('#comment_description_' + data.id).text(des);
                    $("#modify_form_" + data.id).hide();
                    if(data.result=='실패'){
                        alert('비밀번호가 틀렸습니다')
                    }
                }, "json");
        })
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
        <li id="comment_description_{{ $comment->id }}">{{$comment->description}}</li>
        <li>생성일:{{$comment->created_at}}최근수정일:{{$comment->updated_at}}</li>

        <form id="modify_form_{{ $comment->id }}" class="modify_form" action="{{ route('comment.update',['comment' => $comment])}}" method="post">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <input type="hidden" name="article_id" value="{{ $article->id }}">
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
