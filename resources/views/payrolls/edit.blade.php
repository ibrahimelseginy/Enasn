@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">تعديل راتب</h5>
<form method="POST" action="{{ route('payrolls.update',$payroll) }}">@csrf @method('PUT')
<div class="row g-3"><div class="col-md-6"><label class="form-label">الموظف</label><select class="form-select" disabled><option>{{ $payroll->user?->name }}</option></select></div><div class="col-md-6"><label class="form-label">الشهر</label><input name="month" class="form-control" value="{{ $payroll->month }}"></div><div class="col-md-6"><label class="form-label">المبلغ</label><input name="amount" class="form-control" value="{{ $payroll->amount }}"></div><div class="col-md-6"><label class="form-label">العملة</label><input name="currency" class="form-control" value="{{ $payroll->currency }}"></div><div class="col-md-6"><label class="form-label">تاريخ الدفع</label><input type="date" name="paid_at" class="form-control" value="{{ optional($payroll->paid_at)->format('Y-m-d') }}"></div></div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('payrolls.show',$payroll) }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
