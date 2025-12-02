@extends('layouts.app')
@section('content')
<div class="card p-4">
<h5 class="mb-3">إضافة حضور</h5>
<form method="POST" action="{{ route('volunteer-attendance.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">المتطوع</label><select name="user_id" class="form-select">@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div>
<div class="col-md-6"><label class="form-label">التاريخ</label><input type="date" name="date" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">وقت الدخول</label><input type="time" name="check_in_at" class="form-control"></div>
<div class="col-md-6"><label class="form-label">وقت الخروج</label><input type="time" name="check_out_at" class="form-control"></div>
<div class="col-12"><label class="form-label">ملاحظات</label><input type="text" name="notes" class="form-control"></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('volunteer-attendance.index') }}" class="btn btn-light">إلغاء</a></div>
</form>
</div>
@endsection

