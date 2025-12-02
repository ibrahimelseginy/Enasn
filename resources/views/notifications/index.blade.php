@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">الإشعارات</h4>
  <form method="GET" class="d-flex gap-2 align-items-end">
    <div>
      <label class="form-label">الفئة</label>
      <select name="category" class="form-select">
        <option value="">الكل</option>
        <option value="complaints" @selected($category==='complaints')>الشكاوى</option>
        <option value="tasks" @selected($category==='tasks')>المهام</option>
        <option value="attendance" @selected($category==='attendance')>الحضور</option>
        <option value="finance" @selected($category==='finance')>المالية</option>
        <option value="beneficiaries" @selected($category==='beneficiaries')>المستفيدون</option>
      </select>
    </div>
    <div>
      <label class="form-label">النوع</label>
      <select name="type" class="form-select">
        <option value="">الكل</option>
        <option value="success" @selected($type==='success')>نجاح</option>
        <option value="info" @selected($type==='info')>معلومة</option>
        <option value="warning" @selected($type==='warning')>تحذير</option>
        <option value="danger" @selected($type==='danger')>هام</option>
        <option value="secondary" @selected($type==='secondary')>عام</option>
      </select>
    </div>
    <div>
      <button class="btn btn-primary">تصفية</button>
      <a href="{{ route('notifications.index') }}" class="btn btn-light">إعادة</a>
    </div>
  </form>
</div>

<div class="card mb-4 p-3">
  <h6 class="mb-2">الاقتراحات</h6>
  @if(!empty($suggestions))
    <div class="row g-2">
      @foreach($suggestions as $s)
        <div class="col-md-6">
          <div class="d-flex justify-content-between align-items-center border rounded p-2 bg-light">
            <div>{{ $s['text'] }}</div>
            <a href="{{ $s['link'] }}" class="btn btn-outline-primary btn-sm">تنفيذ</a>
          </div>
        </div>
      @endforeach
    </div>
  @else
    <div class="alert alert-secondary mb-0">لا توجد اقتراحات حالية</div>
  @endif
</div>

<div class="row g-3">
  @forelse($items as $n)
    <div class="col-md-6">
      <div class="alert alert-{{ $n['type'] }} d-flex justify-content-between align-items-center">
        <div>{{ $n['text'] }}</div>
        <a href="{{ $n['link'] }}" class="btn btn-outline-dark btn-sm">فتح</a>
      </div>
    </div>
  @empty
    <div class="col-12"><div class="alert alert-secondary">لا توجد إشعارات</div></div>
  @endforelse
</div>
@endsection
