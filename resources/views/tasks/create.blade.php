@extends('layouts.app')

@section('content')
    <h1>タスク作成</h1>

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">タイトル:</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div>
            <label for="description">詳細:</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <div>
            <label for="due_date">期限:</label>
            <input type="date" name="due_date" id="due_date">
        </div>
        <div>
            <label for="tags">タグ:</label>
            <select name="tags[]" id="tags" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit">登録</button>
    </form>
@endsection
