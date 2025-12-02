@extends('layouts.app')
@section('content')
<div class="card p-4">
<h5 class="mb-3">إضافة مهمة</h5>
<form method="POST" action="{{ route('tasks.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">العنوان</label><input type="text" name="title" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">الحالة</label><select name="status" class="form-select"><option value="pending">قيد الانتظار</option><option value="in_progress">قيد التنفيذ</option><option value="done">منجزة</option></select></div>
<div class="col-12"><label class="form-label">الوصف</label><textarea name="description" class="form-control" rows="3"></textarea></div>
<div class="col-md-6"><label class="form-label">المكلّف</label><select name="assigned_to" class="form-select"><option value="">—</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">المكلِّف</label><select name="assigned_by" class="form-select"><option value="">—</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">تاريخ الاستحقاق</label><input type="date" name="due_date" class="form-control"></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('tasks.index') }}" class="btn btn-light">إلغاء</a></div>
</form>
</div>
@endsection

