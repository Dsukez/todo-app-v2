@extends('layouts.app')

@section('content')
    <h1>タスク編集</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="title">タイトル:</label>
            <input type="text" name="title" id="title" value="{{ $task->title }}" required>
        </div>
        <div>
            <label for="description">詳細:</label>
            <textarea name="description" id="description">{{ $task->description }}</textarea>
        </div>
        <div>
            <label for="due_date">期限:</label>
            <input type="date" name="due_date" id="due_date" value="{{ $task->due_date }}">
        </div>
        <div>
            <label for="is_completed">ステータス:</label>
            <select name="is_completed" id="is_completed">
                <option value="0" {{ !$task->is_completed ? 'selected' : '' }}>未完了</option>
                <option value="1" {{ $task->is_completed ? 'selected' : '' }}>完了</option>
            </select>
        </div>
        <div>
            <label for="tags">タグ:</label>
            <select name="tags[]" id="tags" multiple>
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ $task->tags->contains($tag->id) ? 'selected' : '' }}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit">更新</button>
    </form>
@endsection
