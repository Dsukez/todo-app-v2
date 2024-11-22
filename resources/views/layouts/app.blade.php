<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ToDoアプリ</title>
    <!-- スタイルシートの読み込み -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <nav>
        <a href="{{ route('tasks.index') }}">タスク一覧</a>
        <a href="{{ route('tasks.create') }}">タスク作成</a>
        <a href="{{ route('tags.index') }}">タグ一覧</a>
        <a href="{{ route('tags.create') }}">タグ作成</a>
    </nav>

    <!-- 成功メッセージの表示 -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        @yield('content')
    </div>
</body>
</html>
