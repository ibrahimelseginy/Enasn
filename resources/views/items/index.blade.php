@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">الأصناف</h4>
  <a href="{{ route('items.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة صنف</a>
</div>
<div class="row g-3">
@foreach($items as $i)
  <div class="col-md-4">
    <div class="card p-3">
      <div class="fw-bold">{{ $i->name }}</div>
      <div class="text-muted small">الوحدة: {{ $i->unit ?? '—' }}</div>
      <div class="text-muted small">القيمة التقديرية: {{ $i->estimated_value }}</div>
      <div class="mt-3 d-flex gap-2">
        <a class="btn btn-outline-primary btn-sm" href="{{ route('items.show',$i) }}">عرض</a>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('items.edit',$i) }}">تعديل</a>
        <form method="POST" action="{{ route('items.destroy',$i) }}" onsubmit="return confirm('حذف الصنف؟');">
          @csrf @method('DELETE')
          <button class="btn btn-outline-danger btn-sm">حذف</button>
        </form>
      </div>
    </div>
  </div>
@endforeach
</div>
<div class="mt-3">{{ $items->links() }}</div>
@endsection
