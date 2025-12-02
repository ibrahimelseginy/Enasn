@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">إضافة راتب</h5>
<form method="POST" action="{{ route('payrolls.store') }}">@csrf
<div class="row g-3"><div class="col-md-6"><label class="form-label">الموظف</label><select name="user_id" class="form-select" required>@foreach($users as $u)<option value="{{ $u->id }}">{{ $u->name }}</option>@endforeach</select></div><div class="col-md-6"><label class="form-label">الشهر</label><input name="month" class="form-control" required></div><div class="col-md-6"><label class="form-label">المبلغ</label><input name="amount" class="form-control" required></div><div class="col-md-6"><label class="form-label">العملة</label><input name="currency" class="form-control" value="EGP"></div><div class="col-md-6"><label class="form-label">تاريخ الدفع</label><input type="date" name="paid_at" class="form-control"></div></div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('payrolls.index') }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
