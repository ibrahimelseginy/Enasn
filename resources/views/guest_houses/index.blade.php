@extends('layouts.app')
@section('content')
<style>
.gh-card{border:none;border-radius:16px;overflow:hidden;box-shadow:0 10px 24px rgba(13,110,253,.08);background:linear-gradient(135deg,#f8fbff,#eef5ff)}
.gh-header{display:flex;align-items:center;justify-content:space-between;padding:1rem;background:linear-gradient(90deg, var(--primary), var(--accent));color:#fff}
.gh-title{display:flex;align-items:center;gap:.75rem}
.gh-chip{width:40px;height:40px;border-radius:12px;background:rgba(255,255,255,.2);display:flex;align-items:center;justify-content:center;font-weight:700}
.gh-body{padding:1rem}
.gh-body .kv{display:flex;justify-content:space-between;margin-bottom:.5rem}
.gh-actions{padding:1rem;border-top:1px solid #e9eef7;display:flex;gap:.5rem;justify-content:flex-end}
.gh-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:16px}
.gh-search{background:#fff;box-shadow:0 8px 18px rgba(0,0,0,.06);border-radius:12px}
</style>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">إدارة دار الضيافة</h4>
  <a href="{{ route('guest-houses.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة دار</a>
</div>
<form method="GET" class="gh-search p-3 mb-3">
  <div class="row g-2 align-items-end">
    <div class="col-md-5">
      <label class="form-label">بحث بالاسم أو الموقع</label>
      <input name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="طنطا، كفر الشيخ...">
    </div>
    <div class="col-md-3">
      <label class="form-label">الحالة</label>
      <select name="status" class="form-select">
        <option value="">الكل</option>
        <option value="active" @selected(($status ?? '')==='active')>نشط</option>
        <option value="archived" @selected(($status ?? '')==='archived')>مؤرشف</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">تصفية</button>
    </div>
  </div>
</form>
<div class="gh-grid">
@foreach($houses as $h)
  <div class="gh-card">
    <div class="gh-header">
      <div class="gh-title">
        <div class="gh-chip">{{ mb_substr($h->name,0,1) }}</div>
        <div>
          <div class="fw-bold">{{ $h->name }}</div>
          <div class="small" style="opacity:.9">{{ $h->location ?? '—' }}</div>
        </div>
      </div>
      <span class="badge {{ $h->status==='active'?'bg-success':'bg-secondary' }}">{{ $h->status==='active'?'نشط':'مؤرشف' }}</span>
    </div>
    <div class="gh-body">
      <div class="kv"><span class="text-muted small">السعة</span><span class="fw-bold">{{ $h->capacity ?? '—' }}</span></div>
      <div class="kv"><span class="text-muted small">الهاتف</span><span class="fw-bold">{{ $h->phone ?? '—' }}</span></div>
      <div class="small text-muted">أُضيفت: {{ optional($h->created_at)->format('Y-m-d') }}</div>
    </div>
    <div class="gh-actions">
      <a class="btn btn-outline-light" href="{{ route('guest-houses.show',$h) }}"><i class="bi bi-eye"></i> عرض</a>
      <a class="btn btn-outline-light" href="{{ route('guest-houses.edit',$h) }}"><i class="bi bi-pencil"></i> تعديل</a>
      <form method="POST" action="{{ route('guest-houses.destroy',$h) }}" onsubmit="return confirm('حذف الدار؟');">
        @csrf @method('DELETE')
        <button class="btn btn-outline-danger"><i class="bi bi-trash"></i> حذف</button>
      </form>
    </div>
  </div>
@endforeach
</div>
<div class="mt-3">{{ $houses->links() }}</div>
@endsection
