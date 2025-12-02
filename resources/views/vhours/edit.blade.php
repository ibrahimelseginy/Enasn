@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">تعديل ساعات</h5>
<form method="POST" action="{{ route('volunteer-hours.update',$vh) }}">@csrf @method('PUT')
<div class="row g-3"><div class="col-md-6"><label class="form-label">المتطوع</label><select class="form-select" disabled><option>{{ $vh->user?->name }}</option></select></div><div class="col-md-6"><label class="form-label">التاريخ</label><input type="date" name="date" class="form-control" value="{{ $vh->date->format('Y-m-d') }}"></div><div class="col-md-6"><label class="form-label">الساعات</label><input name="hours" class="form-control" value="{{ $vh->hours }}"></div><div class="col-md-6"><label class="form-label">المهمة</label><input name="task" class="form-control" value="{{ $vh->task }}"></div></div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('volunteer-hours.show',$vh) }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
