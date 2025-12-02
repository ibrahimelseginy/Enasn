@extends('layouts.app')
@section('content')
<div class="card p-4"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">تفاصيل راتب</h5><a class="btn btn-secondary" href="{{ route('payrolls.edit',$payroll) }}">تعديل</a></div>
<div class="mt-3"><div>الموظف: {{ $payroll->user?->name }}</div><div>الشهر: {{ $payroll->month }}</div><div>المبلغ: {{ $payroll->amount }} {{ $payroll->currency }}</div><div>تاريخ الدفع: {{ optional($payroll->paid_at)->format('Y-m-d') ?? '—' }}</div></div>
<div class="mt-3"><a href="{{ route('payrolls.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection
