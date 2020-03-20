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

<form role="form" action="{{ route('comment.store')}}" method="post">
    @csrf
    <input type="hidden" name="article_id" value="{{ $article->id }}">
{{--    <input type="text" name="nickname" placeholder="닉네임"></p>--}}
{{--    <input type="text" name="password" placeholder="비밀번호"></p>--}}
{{--    <p><textarea name="description"></textarea></p>--}}
{{--    <p><input type="submit" name="댓글쓰기"></p>--}}
    <div class="row">
        <div class="form-group col-xs-3">
            <input type="text" name="nickname" class="form-control" placeholder="닉네임">
            <input type="text" name="password" class="form-control" placeholder="비밀번호">
        </div>
        <div class="form-group col-xs-5">
            <textarea class="form-control" rows="3" name="description" placeholder="Enter ..."></textarea>
            <input class="fa-pull-right" type="submit" name="댓글쓰기">
        </div>
    </div>

</form>
<ul>
    @foreach($comments as $comment)
        <div id="comment_{{ $comment->id }}">
{{--            <li>{{$comment -> nickname}}</li>--}}
{{--            <li id="comment_description_{{ $comment->id }}">{{$comment->description}}</li>--}}
{{--            <li>작성일: {{$comment->created_at}} | 최근 수정일: {{$comment->updated_at}}</li>--}}


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


{{--            <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">--}}
{{--                <thead>--}}
{{--                <tr>--}}
{{--                    <th rowspan="1" colspan="1">제목</th>--}}
{{--                    <th rowspan="1" colspan="1">글쓴이</th>--}}
{{--                    <th rowspan="1" colspan="1">작성일</th>--}}
{{--                </tr>--}}
{{--                </thead>--}}
{{--                <tbody>--}}
{{--                <tr role="row" class="odd">--}}
{{--                    <td class="sorting_1">{{$comment -> nickname}}</td>--}}
{{--                    <td id="comment_description_{{ $comment->id }}">{{$comment->description}}</td>--}}
{{--                    <td>{{$comment->created_at}}</td>--}}
{{--                </tr><tr role="row" class="even">--}}
{{--            </table>--}}


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
{{--                <button class="deleteButton" data-id="{{ $comment->id }}">삭제</button>--}}
{{--                <button class="modifyButton" data-id="{{ $comment->id }}">수정</button>--}}
            </div>
        </div>


    @endforeach
</ul>