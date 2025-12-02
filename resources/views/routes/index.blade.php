@extends('layouts.app')
@section('content')
<style>
.route-card{border:none;border-radius:16px;overflow:hidden;box-shadow:0 10px 24px rgba(13,110,253,.08);background:linear-gradient(135deg,#f8fbff,#eef5ff)}
.route-card .header{display:flex;align-items:center;gap:.75rem;padding:1rem;background:linear-gradient(90deg, var(--primary), var(--accent));color:#fff}
.route-chip{width:40px;height:40px;border-radius:12px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-weight:700}
.route-body{padding:1rem}
.route-actions{padding:1rem;border-top:1px solid #e9eef7;display:flex;gap:.5rem;justify-content:flex-end}
.routes-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px}
.search-wrap{background:#fff;box-shadow:0 8px 18px rgba(0,0,0,.06);border-radius:12px}
</style>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">خطوط السير</h4>
  <a href="{{ route('travel-routes.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة خط</a>
</div>
<form method="GET" class="search-wrap p-3 mb-3">
  <div class="row g-2 align-items-end">
    <div class="col-md-6">
      <label class="form-label">بحث بالاسم</label>
      <input name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="القاهرة، الجيزة...">
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">تصفية</button>
    </div>
  </div>
</form>
<div class="routes-grid">
@foreach($routes as $r)
  <div class="route-card">
    <div class="header">
      <div class="route-chip">{{ mb_substr($r->name,0,1) }}</div>
      <div>
        <div class="fw-bold">{{ $r->name }}</div>
        <div class="small" style="opacity:.9">{{ $r->description ?? '—' }}</div>
      </div>
    </div>
    <div class="route-body">
      <div class="small text-muted">أُضيفت: {{ optional($r->created_at)->format('Y-m-d') }}</div>
    </div>
    <div class="route-actions">
      <a class="btn btn-outline-light" href="{{ route('travel-routes.show',$r) }}"><i class="bi bi-eye"></i> عرض</a>
      <a class="btn btn-outline-light" href="{{ route('travel-routes.edit',$r) }}"><i class="bi bi-pencil"></i> تعديل</a>
      <form class="d-inline" method="POST" action="{{ route('travel-routes.destroy',$r) }}" onsubmit="return confirm('حذف خط السير؟');">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> حذف</button>
      </form>
    </div>
  </div>
@endforeach
</div>
<div class="mt-3 text-muted small">الإجمالي: {{ count($routes) }}</div>
@endsection
