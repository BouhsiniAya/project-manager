<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Comment;
use App\Models\Task;

class CommentController extends Controller
{
    public function store(Request $request, Task $task)
    {
        $validated = $request->validate([
            'content' => 'required|string',
        ]);

        Comment::create([
            'content' => $validated['content'],
            'task_id' => $task->id,
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Comment added.');
    }
}
