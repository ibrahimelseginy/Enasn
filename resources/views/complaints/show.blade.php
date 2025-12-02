@extends('layouts.app')
@section('content')
<div class="card p-4"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">{{ $complaint->subject }}</h5><a class="btn btn-secondary" href="{{ route('complaints.edit',$complaint) }}">تعديل</a></div>
<div class="mt-3"><div>المصدر: {{ $complaint->source_type }} #{{ $complaint->source_id }}</div><div>الحالة: {{ $complaint->status }}</div><div>المسؤول: {{ $complaint->against?->name ?? '—' }}</div><div>النص: {{ $complaint->message }}</div></div>
<div class="mt-3"><a href="{{ route('complaints.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection
