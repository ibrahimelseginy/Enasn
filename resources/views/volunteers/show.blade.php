@extends('layouts.app')
@section('content')
<div class="card p-4"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">تفاصيل متطوع</h5><a class="btn btn-secondary" href="{{ route('volunteers.edit',$volunteer) }}">تعديل</a></div>
<div class="mt-3"><div>الاسم: {{ $volunteer->name }}</div><div>البريد: {{ $volunteer->email }}</div><div>الهاتف: {{ $volunteer->phone ?? '—' }}</div><div>نشط: {{ $volunteer->active ? 'نعم' : 'لا' }}</div></div>
<div class="mt-3"><a href="{{ route('volunteers.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection

