@extends('layouts.app')
@section('content')
<style>
.gh-form{border:none;border-radius:16px;overflow:hidden;box-shadow:0 10px 24px rgba(13,110,253,.08)}
.gh-form .hdr{padding:1rem;background:linear-gradient(90deg, var(--primary), var(--accent));color:#fff}
.gh-form .body{padding:1rem}
</style>
<div class="gh-form">
  <div class="hdr"><h5 class="mb-0">تعديل دار ضيافة</h5></div>
  <div class="body">
  <form method="POST" action="{{ route('guest-houses.update',$guest_house) }}">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">الاسم</label>
        <input name="name" class="form-control" value="{{ $guest_house->name }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">الموقع</label>
        <input name="location" class="form-control" value="{{ $guest_house->location }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">الهاتف</label>
        <input name="phone" class="form-control" value="{{ $guest_house->phone }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">السعة</label>
        <input name="capacity" type="number" class="form-control" value="{{ $guest_house->capacity }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">الحالة</label>
        <select name="status" class="form-select">
          <option value="active" @selected($guest_house->status==='active')>نشط</option>
          <option value="archived" @selected($guest_house->status==='archived')>مؤرشف</option>
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">وصف</label>
        <textarea name="description" class="form-control" rows="3">{{ $guest_house->description }}</textarea>
      </div>
    </div>
    <div class="mt-3 d-flex gap-2">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('guest-houses.show',$guest_house) }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
  </div>
</div>
@endsection
