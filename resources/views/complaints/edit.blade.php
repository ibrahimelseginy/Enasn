@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">تعديل شكوى</h5>
<form method="POST" action="{{ route('complaints.update',$complaint) }}">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label">الحالة</label><select name="status" class="form-select"><option value="open" @selected($complaint->status==='open')>مفتوحة</option><option value="in_progress" @selected($complaint->status==='in_progress')>جارية</option><option value="closed" @selected($complaint->status==='closed')>مغلقة</option></select></div>
<div class="col-md-6"><label class="form-label">المسؤول</label><select name="against_user_id" class="form-select"><option value="">—</option>@foreach($users as $u)<option value="{{ $u->id }}" @selected($complaint->against_user_id==$u->id)>{{ $u->name }}</option>@endforeach</select></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('complaints.show',$complaint) }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
