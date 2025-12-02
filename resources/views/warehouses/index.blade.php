@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">المخازن</h4>
  <a href="{{ route('warehouses.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة مخزن</a>
</div>
<div class="row g-3">
@foreach($warehouses as $w)
  <div class="col-md-4">
    <div class="card p-3">
      <div class="fw-bold">{{ $w->name }}</div>
      <div class="text-muted small">{{ $w->location ?? '—' }}</div>
      <div class="mt-3 d-flex gap-2">
        <a class="btn btn-outline-primary btn-sm" href="{{ route('warehouses.show',$w) }}">عرض</a>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('warehouses.edit',$w) }}">تعديل</a>
        <form method="POST" action="{{ route('warehouses.destroy',$w) }}" onsubmit="return confirm('حذف المخزن؟');">
          @csrf @method('DELETE')
          <button class="btn btn-outline-danger btn-sm">حذف</button>
        </form>
      </div>
    </div>
  </div>
@endforeach
</div>
<div class="mt-3">{{ $warehouses->links() }}</div>
@endsection
