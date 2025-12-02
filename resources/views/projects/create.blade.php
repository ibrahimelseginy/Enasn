@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">إضافة مشروع</h5>
  <form method="POST" action="{{ route('projects.store') }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">الاسم</label>
        <input name="name" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">الحالة</label>
        <select name="status" class="form-select" required>
          <option value="active">نشط</option>
          <option value="archived">مؤرشف</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">ثابت</label>
        <select name="fixed" class="form-select">
          <option value="1">نعم</option>
          <option value="0">لا</option>
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">وصف</label>
        <textarea name="description" class="form-control" rows="3"></textarea>
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('projects.index') }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
  </div>
@endsection

