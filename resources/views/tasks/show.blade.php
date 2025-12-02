@extends('layouts.app')
@section('content')
<div class="card p-4"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">تفاصيل مهمة</h5><a class="btn btn-secondary" href="{{ route('tasks.edit',$task) }}">تعديل</a></div>
<div class="mt-3"><div>العنوان: {{ $task->title }}</div><div>الوصف: {{ $task->description ?? '—' }}</div><div>المكلّف: {{ $task->assignee?->name ?? '—' }}</div><div>المكلِّف: {{ $task->assigner?->name ?? '—' }}</div><div>الاستحقاق: {{ $task->due_date?->format('Y-m-d') ?? '—' }}</div><div>الحالة: {{ $task->status }}</div></div>
<div class="mt-3"><a href="{{ route('tasks.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection

