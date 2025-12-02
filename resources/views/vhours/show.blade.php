@extends('layouts.app')
@section('content')
<div class="card p-4"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">ساعات متطوع</h5><a class="btn btn-secondary" href="{{ route('volunteer-hours.edit',$vh) }}">تعديل</a></div>
<div class="mt-3"><div>المتطوع: {{ $vh->user?->name }}</div><div>التاريخ: {{ $vh->date->format('Y-m-d') }}</div><div>الساعات: {{ $vh->hours }}</div><div>المهمة: {{ $vh->task ?? '—' }}</div></div>
<div class="mt-3"><a href="{{ route('volunteer-hours.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection
