
<form action="process_create.blade.php" method="post">
    <input type="text" name="title" placeholder="제목"></p>
    <p><textarea name="description" placeholder="본문"></textarea></p>
    <select name="category" >
        <option value="0">- Select -</option>
        @foreach($categories1 as $category)
            <option value="{{$category -> id}}">{{$category -> name}}</option>
        @endforeach
    </select>
    <p><input type="submit"></p>
</form>
