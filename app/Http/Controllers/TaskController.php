<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Tag;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // タスク一覧表示
    public function index(Request $request)
    {
        $query = Task::with('tags');

        // 未完了・完了のフィルタリング
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_completed', $request->status);
        }

        // タグによるフィルタリング
        if ($request->has('tag') && $request->tag !== '') {
            $query->whereHas('tags', function($q) use ($request) {
                $q->where('tags.id', $request->tag);
            });
        }

        $tasks = $query->get();
        $tags = Tag::all();

        return view('tasks.index', compact('tasks', 'tags'));
    }

    // タスク作成フォーム表示
    public function create()
    {
        $tags = Tag::all();
        return view('tasks.create', compact('tags'));
    }

    // タスク登録処理
    public function store(Request $request)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
            'tags' => 'nullable|array',
        ]);

        // タスクの作成
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'is_completed' => false,
        ]);

        // タグの関連付け
        if (!empty($validated['tags'])) {
            $task->tags()->attach($validated['tags']);
        }

        return redirect()->route('tasks.index');
    }

    // タスク編集フォーム表示
    public function edit($id)
    {
        $task = Task::with('tags')->findOrFail($id);
        $tags = Tag::all();
        return view('tasks.edit', compact('task', 'tags'));
    }

    // タスク更新処理
    public function update(Request $request, $id)
    {
        // バリデーション
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
            'is_completed' => 'required|boolean',
            'tags' => 'nullable|array',
        ]);

        $task = Task::findOrFail($id);
        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'due_date' => $validated['due_date'] ?? null,
            'is_completed' => $validated['is_completed'],
        ]);

        // タグの更新
        if (!empty($validated['tags'])) {
            $task->tags()->sync($validated['tags']);
        } else {
            $task->tags()->detach();
        }

        return redirect()->route('tasks.index');
    }

    // タスク削除処理
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->tags()->detach();
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'タスクを削除しました。');
    }

    // 一括削除処理
    public function bulkDelete(Request $request)
    {
        if ($request->has('tasks')) {
            $tasks = Task::whereIn('id', $request->tasks)->get();

            foreach ($tasks as $task) {
                $task->tags()->detach();
                $task->delete();
            }
        }

        return redirect()->route('tasks.index')->with('success', '選択したタスクを削除しました。');
    }
}
