@extends('layouts.public')

@section('body')
<form method="post">
    {{csrf_field()}}
    <textarea name="code" style="width: 900px; height: 420px;">{{$code or ''}}</textarea>
    <input type="submit" value="格式化" style="height: 40px; width: 100px; display: block; margin: 10px;">
    <textarea style="width: 900px; height: 420px;">{{$show or ''}}</textarea>
</form>
@endsection
