@extends('layouts.app')

@section('content')
    <h1>タグ作成</h1>

    <form action="{{ route('tags.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">名前:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <button type="submit">登録</button>
    </form>
@endsection
