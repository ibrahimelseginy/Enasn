@extends('layouts.app')
@section('content')
<div class="card p-4">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="mb-0">{{ $item->name }}</h5>
    <a class="btn btn-secondary" href="{{ route('items.edit',$item) }}">تعديل</a>
  </div>
  <div class="mt-3">
    <div>SKU: {{ $item->sku ?? '—' }}</div>
    <div>الوحدة: {{ $item->unit ?? '—' }}</div>
    <div>القيمة التقديرية: {{ $item->estimated_value ?? '—' }}</div>
  </div>
  <div class="mt-3">
    <a href="{{ route('items.index') }}" class="btn btn-light">رجوع</a>
  </div>
</div>
@endsection
