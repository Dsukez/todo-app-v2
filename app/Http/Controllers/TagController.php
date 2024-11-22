<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    // タグ一覧表示
    public function index()
    {
        $tags = Tag::all();
        return view('tags.index', compact('tags'));
    }

    // タグ作成フォーム表示
    public function create()
    {
        return view('tags.create');
    }

    // タグ登録処理
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        Tag::create($validated);

        return redirect()->route('tags.index');
    }

    // タグ編集フォーム表示
    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        return view('tags.edit', compact('tag'));
    }

    // タグ更新処理
    public function update(Request $request, $id)
    {
        // バリデーション
        $validated = $request->validate([
            'name' => 'required|max:255',
        ]);

        $tag = Tag::findOrFail($id);
        $tag->update($validated);

        return redirect()->route('tags.index');
    }

    // タグ削除処理
    public function destroy($id)
    {
        $tag = Tag::findOrFail($id);
        $tag->tasks()->detach();
        $tag->delete();

        return redirect()->route('tags.index')->with('success', 'タグを削除しました。');
    }
}
