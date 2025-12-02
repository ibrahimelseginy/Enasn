@extends('layouts.app')
@section('content')
<style>
.gh-show{border:none;border-radius:16px;overflow:hidden;box-shadow:0 10px 24px rgba(13,110,253,.08)}
.gh-show .hdr{padding:1rem;background:linear-gradient(90deg, var(--primary), var(--accent));color:#fff;display:flex;justify-content:space-between;align-items:center}
.gh-show .body{padding:1rem}
.gh-show .kv{display:flex;justify-content:space-between;margin-bottom:.5rem}
</style>
<div class="gh-show">
  <div class="hdr">
    <h5 class="mb-0">{{ $guest_house->name }}</h5>
    <div class="d-flex align-items-center gap-2">
      <span class="badge {{ $guest_house->status==='active'?'bg-success':'bg-secondary' }}">{{ $guest_house->status==='active'?'نشط':'مؤرشف' }}</span>
      <a class="btn btn-light btn-sm" href="{{ route('guest-houses.edit',$guest_house) }}"><i class="bi bi-pencil"></i> تعديل</a>
    </div>
  </div>
  <div class="body">
    <div class="kv"><span class="text-muted">الموقع</span><span class="fw-bold">{{ $guest_house->location ?? '—' }}</span></div>
    <div class="kv"><span class="text-muted">الهاتف</span><span class="fw-bold">{{ $guest_house->phone ?? '—' }}</span></div>
    <div class="kv"><span class="text-muted">السعة</span><span class="fw-bold">{{ $guest_house->capacity ?? '—' }}</span></div>
    <div class="kv"><span class="text-muted">الوصف</span><span class="fw-bold">{{ $guest_house->description ?? '—' }}</span></div>
    <div class="text-muted small">أُضيفت: {{ optional($guest_house->created_at)->format('Y-m-d') }}</div>
    <div class="mt-3">
      <a href="{{ route('guest-houses.index') }}" class="btn btn-light">رجوع</a>
    </div>
  </div>
</div>
@endsection
