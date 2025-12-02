@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">إضافة حملة</h5>
  <form method="POST" action="{{ route('campaigns.store') }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">الاسم</label>
        <input name="name" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">السنة</label>
        <input name="season_year" class="form-control" type="number" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">تاريخ البداية</label>
        <input name="start_date" class="form-control" type="date">
      </div>
      <div class="col-md-6">
        <label class="form-label">تاريخ النهاية</label>
        <input name="end_date" class="form-control" type="date">
      </div>
      <div class="col-md-6">
        <label class="form-label">الحالة</label>
        <select name="status" class="form-select" required>
          <option value="active">نشط</option>
          <option value="archived">مؤرشف</option>
        </select>
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('campaigns.index') }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
</div>
@endsection

