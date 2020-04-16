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
        $(".delete_form").hide();
        $('.deleteButton').click(function(e){
            var form_id = $(this).data('id');
            $("#delete_form_" + form_id).show();
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
<script type="text/javascript">
    $( document ).ready(function() {
        $(".delete_form").submit(function(e) {
            e.preventDefault();
            var url = $(this).attr('action');
            $.post(url, $(this).serialize(),
                function (data) {
                    $('#comment_' + data.id).remove();
                    $("#delete_form_" + data.id).hide();
                    if(data.result=='실패'){
                        alert('비밀번호가 틀렸습니다')
                    }
                }, "json");
        })
    });
</script>
<script>
    function checkForm() {
        if($('#nickname').val() == ''){
            alert('닉네임을 입력하세요.');
            $('#nickname').focus();
            return false;
        }
        if ($('#text').val() == '') {
            alert('내용을 입력하세요.');
            $('#text').focus();
            return false;
        }
        if ($('#password').val() == '') {
            alert('비밀번호를 입력하세요.');
            $('#password').focus();
            return false;
        }
        return true;
    }
</script>
<form role="form" action="{{ route('comment.store')}}" method="post" onsubmit="return checkForm()">
    @csrf
    <input type="hidden" name="article_id" value="{{ $article->id }}">
    <div class="row">
        <div class="form-group col-xs-3">
            <input id="nickname" type="text" name="nickname" class="form-control" placeholder="닉네임">
            <input id="password" type="text" name="password" class="form-control" placeholder="비밀번호">
        </div>
        <div class="form-group col-xs-5">
            <textarea id="text" class="form-control" rows="3" name="description" placeholder="Enter ..."></textarea>
            <input class="fa-pull-right" type="submit" name="댓글쓰기">
        </div>
    </div>

</form>
<ul>
    @foreach($comments as $comment)
        <div id="comment_{{ $comment->id }}">
            <table class="table table-hover">
                <tbody>
                <tr>
                    <th>글쓴이</th>
                    <th>내용</th>
                    <th>작성일</th>
                </tr>
                <tr>
                    <td class="sorting_1">{{$comment -> nickname}}</td>
                    <td id="comment_description_{{ $comment->id }}">{{$comment->description}}</td>
                    <td>{{$comment->created_at}}</td>
                </tr>
                </tbody>
            </table>

            <form id="modify_form_{{ $comment->id }}" class="modify_form" action="{{ route('comment.update',['comment' => $comment])}}" method="post">
                @csrf
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="article_id" value="{{ $article->id }}">
                <input type="text" name="password" placeholder="비밀번호"></p>
                <p><textarea name="description">{{$comment->description}}</textarea></p>

                <p><input type="submit" name="수정"></p>
            </form>
            <form id="delete_form_{{ $comment->id }}" class="delete_form" action="{{ route('comment.destroy', ['comment' => $comment] )}}" method="post">
                @csrf
                @method('DELETE')
                <input type="text" name="password" placeholder="비밀번호"></p>
                <input type="submit" value="전송">
            </form>

            <div id="buttons_{{ $comment->id }}">
                <a class="modifyButton" data-id="{{ $comment->id }}" type="button" class="btn btn-block btn-default">수정</a>
                <a class="deleteButton" data-id="{{ $comment->id }}" type="button" class="btn btn-block btn-default">삭제</a>
            </div>
        </div>
    @endforeach
</ul>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
