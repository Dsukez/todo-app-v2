@extends('layouts.app')

@section('content')
    <h1>タグ一覧</h1>

    <a href="{{ route('tags.create') }}">新しいタグを作成</a>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>名前</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>{{ $tag->id }}</td>
                    <td>{{ $tag->name }}</td>
                    <td>
                        <a href="{{ route('tags.edit', $tag->id) }}">編集</a>
                        <form action="{{ route('tags.destroy', $tag->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('本当に削除しますか？')">削除</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
