@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">إدارة المشاريع</h4>
  <a href="{{ route('projects.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة مشروع</a>
</div>
<form method="GET" class="card p-3 mb-3">
  <div class="row g-2 align-items-end">
    <div class="col-md-4">
      <label class="form-label">بحث بالاسم</label>
      <input name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="مشروع...">
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
      <label class="form-label">ثابت فقط</label>
      <select name="fixed" class="form-select">
        <option value="">الكل</option>
        <option value="1" @selected(($fixed ?? null)===true)>نعم</option>
        <option value="0" @selected(($fixed ?? null)===false)>لا</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">تصفية</button>
    </div>
  </div>
</form>
<div class="row g-3">
@foreach($projects as $p)
  <div class="col-md-4">
    <div class="card p-3">
      <div class="d-flex align-items-center gap-3">
        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:56px;height:56px">
          <i class="bi bi-kanban" style="font-size:1.4rem"></i>
        </div>
        <div class="flex-grow-1">
          <div class="d-flex justify-content-between align-items-center">
            <div class="fw-bold">{{ $p->name }}</div>
            <div class="d-flex align-items-center gap-2">
              <span class="badge {{ $p->status==='active' ? 'bg-success' : 'bg-secondary' }}">{{ $p->status==='active' ? 'نشط' : 'مؤرشف' }}</span>
              <span class="badge {{ $p->fixed ? 'bg-info' : 'bg-light text-dark' }}">{{ $p->fixed ? 'ثابت' : 'غير ثابت' }}</span>
            </div>
          </div>
          <div class="mt-1 text-muted small">{{ $p->description }}</div>
        </div>
      </div>
      <div class="mt-3 d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
          <img src="{{ $p->manager_photo_url ?? 'https://via.placeholder.com/32x32?text=M' }}" alt="manager" width="32" height="32" class="rounded-circle">
          <img src="{{ $p->deputy_photo_url ?? 'https://via.placeholder.com/32x32?text=D' }}" alt="deputy" width="32" height="32" class="rounded-circle">
          <span class="badge bg-light text-dark">المتطوعون: {{ $p->volunteers()->count() }}</span>
        </div>
        <div class="d-flex gap-2">
          <a class="btn btn-outline-primary btn-sm" href="{{ route('projects.show',$p) }}">عرض</a>
          <a class="btn btn-outline-secondary btn-sm" href="{{ route('projects.edit',$p) }}">تعديل</a>
          <form method="POST" action="{{ route('projects.destroy',$p) }}" onsubmit="return confirm('حذف المشروع؟');">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">حذف</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endforeach
</div>
<div class="mt-3">{{ $projects->links() }}</div>
@endsection
