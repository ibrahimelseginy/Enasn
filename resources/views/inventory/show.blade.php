@extends('layouts.app')
@section('content')
<div class="card p-4">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="mb-0">تفاصيل حركة</h5>
    <a class="btn btn-secondary" href="{{ route('inventory-transactions.edit',$t) }}">تعديل</a>
  </div>
  <div class="mt-3">
    <div>الصنف: {{ $t->item?->name }}</div>
    <div>المخزن: {{ $t->warehouse?->name }}</div>
    <div>النوع: {{ $t->type }}</div>
    <div>الكمية: {{ $t->quantity }}</div>
    <div>المستفيد: {{ $t->beneficiary?->full_name ?? '—' }}</div>
    <div>المشروع: {{ $t->project?->name ?? '—' }}</div>
    <div>الحملة: {{ $t->campaign?->name ?? '—' }}</div>
    <div>مرجع: {{ $t->reference ?? '—' }}</div>
  </div>
  <div class="mt-3">
    <a href="{{ route('inventory-transactions.index') }}" class="btn btn-light">رجوع</a>
  </div>
</div>
@endsection
