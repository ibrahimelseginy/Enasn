<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;

class TaskWebController extends Controller
{
    public function index() { $tasks = Task::with(['assignee','assigner'])->orderByDesc('id')->paginate(50); return view('tasks.index', compact('tasks')); }
    public function create() { $users = User::orderBy('name')->get(); return view('tasks.create', compact('users')); }
    public function store(Request $request) { $data = $request->validate(['title' => 'required|string','description' => 'nullable|string','assigned_to' => 'nullable|exists:users,id','assigned_by' => 'nullable|exists:users,id','due_date' => 'nullable|date','status' => 'in:pending,in_progress,done']); $task = Task::create($data); return redirect()->route('tasks.show',$task); }
    public function show(Task $task) { return view('tasks.show', ['task' => $task->load(['assignee','assigner'])]); }
    public function edit(Task $task) { $users = User::orderBy('name')->get(); return view('tasks.edit', ['task' => $task, 'users' => $users]); }
    public function update(Request $request, Task $task) { $data = $request->validate(['title' => 'sometimes|string','description' => 'nullable|string','assigned_to' => 'nullable|exists:users,id','assigned_by' => 'nullable|exists:users,id','due_date' => 'nullable|date','status' => 'in:pending,in_progress,done']); $task->update($data); return redirect()->route('tasks.show',$task); }
    public function destroy(Task $task) { $task->delete(); return redirect()->route('tasks.index'); }
}

