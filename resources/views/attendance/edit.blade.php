@extends('layouts.app')
@section('content')
<div class="card p-4">
<div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">تعديل حضور</h5><a class="btn btn-light" href="{{ route('volunteer-attendance.show',$rec) }}">عرض</a></div>
<form method="POST" action="{{ route('volunteer-attendance.update',$rec) }}">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label">التاريخ</label><input type="date" name="date" class="form-control" value="{{ $rec->date->format('Y-m-d') }}"></div>
<div class="col-md-6"><label class="form-label">وقت الدخول</label><input type="time" name="check_in_at" class="form-control" value="{{ $rec->check_in_at }}"></div>
<div class="col-md-6"><label class="form-label">وقت الخروج</label><input type="time" name="check_out_at" class="form-control" value="{{ $rec->check_out_at }}"></div>
<div class="col-12"><label class="form-label">ملاحظات</label><input type="text" name="notes" class="form-control" value="{{ $rec->notes }}"></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('volunteer-attendance.index') }}" class="btn btn-light">رجوع</a></div>
</form>
</div>
@endsection

