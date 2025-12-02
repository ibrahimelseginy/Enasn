@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">إدارة الحملات</h4>
  <a href="{{ route('campaigns.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة حملة</a>
</div>
<form method="GET" class="card p-3 mb-3">
  <div class="row g-2 align-items-end">
    <div class="col-md-4">
      <label class="form-label">بحث بالاسم</label>
      <input name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="حملة...">
    </div>
    <div class="col-md-3">
      <label class="form-label">الحالة</label>
      <select name="status" class="form-select">
        <option value="">الكل</option>
        <option value="active" @selected(($status ?? '')==='active')>نشط</option>
        <option value="archived" @selected(($status ?? '')==='archived')>مؤرشف</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">السنة</label>
      <input name="season_year" value="{{ $year ?? '' }}" class="form-control" type="number" placeholder="2025">
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">تصفية</button>
    </div>
  </div>
</form>
<div class="row g-3">
@foreach($campaigns as $c)
  <div class="col-md-4">
    <div class="card p-3">
      <div class="fw-bold">{{ $c->name }} <span class="text-muted">({{ $c->season_year }})</span></div>
      <div class="text-muted small">الحالة: {{ $c->status }}</div>
      <div class="text-muted small">من {{ $c->start_date?->format('Y-m-d') ?? '—' }} إلى {{ $c->end_date?->format('Y-m-d') ?? '—' }}</div>
      <div class="mt-3 d-flex gap-2">
        <a class="btn btn-outline-primary btn-sm" href="{{ route('campaigns.show',$c) }}">عرض</a>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('campaigns.edit',$c) }}">تعديل</a>
        <form method="POST" action="{{ route('campaigns.destroy',$c) }}" onsubmit="return confirm('حذف الحملة؟');">
          @csrf @method('DELETE')
          <button class="btn btn-outline-danger btn-sm">حذف</button>
        </form>
      </div>
    </div>
  </div>
@endforeach
</div>
<div class="mt-3">{{ $campaigns->links() }}</div>
@endsection
