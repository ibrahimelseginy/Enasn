@extends('layouts.app')
@section('content')
<div class="card p-4"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">تفاصيل حضور</h5><a class="btn btn-secondary" href="{{ route('volunteer-attendance.edit',$rec) }}">تعديل</a></div>
<div class="mt-3"><div>المتطوع: {{ $rec->user?->name }}</div><div>التاريخ: {{ $rec->date->format('Y-m-d') }}</div><div>الدخول: {{ $rec->check_in_at ?? '—' }}</div><div>الخروج: {{ $rec->check_out_at ?? '—' }}</div><div>ملاحظات: {{ $rec->notes ?? '—' }}</div></div>
<div class="mt-3"><a href="{{ route('volunteer-attendance.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection

