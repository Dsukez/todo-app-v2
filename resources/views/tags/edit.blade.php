@extends('layouts.app')

@section('content')
    <h1>タグ編集</h1>

    <form action="{{ route('tags.update', $tag->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">名前:</label>
            <input type="text" name="name" id="name" value="{{ $tag->name }}" required>
        </div>
        <button type="submit">更新</button>
    </form>
@endsection
