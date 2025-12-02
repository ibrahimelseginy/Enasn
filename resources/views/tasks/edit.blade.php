@extends('layouts.app')
@section('content')
<div class="card p-4">
<div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">تعديل مهمة</h5><a class="btn btn-light" href="{{ route('tasks.show',$task) }}">عرض</a></div>
<form method="POST" action="{{ route('tasks.update',$task) }}">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label">العنوان</label><input type="text" name="title" class="form-control" value="{{ $task->title }}"></div>
<div class="col-md-6"><label class="form-label">الحالة</label><select name="status" class="form-select"><option value="pending" @selected($task->status==='pending')>قيد الانتظار</option><option value="in_progress" @selected($task->status==='in_progress')>قيد التنفيذ</option><option value="done" @selected($task->status==='done')>منجزة</option></select></div>
<div class="col-12"><label class="form-label">الوصف</label><textarea name="description" class="form-control" rows="3">{{ $task->description }}</textarea></div>
<div class="col-md-6"><label class="form-label">المكلّف</label><select name="assigned_to" class="form-select"><option value="">—</option>@foreach($users as $u)<option value="{{ $u->id }}" @selected($task->assigned_to==$u->id)>{{ $u->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">المكلِّف</label><select name="assigned_by" class="form-select"><option value="">—</option>@foreach($users as $u)<option value="{{ $u->id }}" @selected($task->assigned_by==$u->id)>{{ $u->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">تاريخ الاستحقاق</label><input type="date" name="due_date" class="form-control" value="{{ $task->due_date?->format('Y-m-d') }}"></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('tasks.index') }}" class="btn btn-light">رجوع</a></div>
</form>
</div>
@endsection

