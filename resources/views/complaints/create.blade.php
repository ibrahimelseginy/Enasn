@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">إضافة شكوى</h5>
<form method="POST" action="{{ route('complaints.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">المصدر</label><select name="source_type" class="form-select" required><option value="donor">متبرع</option><option value="beneficiary">مستفيد</option><option value="employee">موظف</option></select></div>
<div class="col-md-6"><label class="form-label">رقم المصدر</label><input name="source_id" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">المسؤول</label><select name="against_user_id" class="form-select"><option value="">—</option>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div>
<div class="col-md-12"><label class="form-label">العنوان</label><input name="subject" class="form-control" required></div>
<div class="col-md-12"><label class="form-label">النص</label><textarea name="message" class="form-control" rows="3" required></textarea></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('complaints.index') }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
