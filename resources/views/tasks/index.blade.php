@extends('layouts.app')

@section('content')
    <h1>タスク一覧</h1>

    <!-- フィルタリングフォーム -->
    <form method="GET" action="{{ route('tasks.index') }}">
        <label for="status">ステータス:</label>
        <select name="status" id="status">
            <option value="">全て</option>
            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>未完了</option>
            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>完了</option>
        </select>

        <label for="tag">タグ:</label>
        <select name="tag" id="tag">
            <option value="">全てのタグ</option>
            @foreach($tags as $tag)
                <option value="{{ $tag->id }}" {{ request('tag') == $tag->id ? 'selected' : '' }}>{{ $tag->name }}</option>
            @endforeach
        </select>

        <button type="submit">フィルター</button>
    </form>

    <!-- 一括削除フォーム -->
    <form action="{{ route('tasks.bulkDelete') }}" method="POST">
        @csrf
        <table>
            <thead>
                <tr>
                    <th>選択</th>
                    <th>タイトル</th>
                    <th>詳細</th>
                    <th>期限</th>
                    <th>ステータス</th>
                    <th>タグ</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr>
                        <td>
                            <input type="checkbox" name="tasks[]" value="{{ $task->id }}">
                        </td>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->description }}</td>
                        <td>{{ $task->due_date }}</td>
                        <td>{{ $task->is_completed ? '完了' : '未完了' }}</td>
                        <td>
                            @foreach($task->tags as $tag)
                                {{ $tag->name }}
                            @endforeach
                        </td>
                        <td>
                            <a href="{{ route('tasks.edit', $task->id) }}">編集</a>

                            <!-- 削除フォーム -->
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">タスクがありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <button type="submit" onclick="return confirm('選択したタスクを削除しますか？')">選択したタスクを削除</button>
    </form>
@endsection
