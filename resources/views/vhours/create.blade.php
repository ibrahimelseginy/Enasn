@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">ساعات متطوع</h5>
<form method="POST" action="{{ route('volunteer-hours.store') }}">@csrf
<div class="row g-3"><div class="col-md-6"><label class="form-label">المتطوع</label><select name="user_id" class="form-select" required>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div><div class="col-md-6"><label class="form-label">التاريخ</label><input type="date" name="date" class="form-control" value="{{ now()->format('Y-m-d') }}" required></div><div class="col-md-6"><label class="form-label">الساعات</label><input name="hours" class="form-control" required></div><div class="col-md-6"><label class="form-label">المهمة</label><input name="task" class="form-control"></div></div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('volunteer-hours.index') }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
