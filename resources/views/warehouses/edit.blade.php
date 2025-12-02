@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">تعديل مخزن</h5>
  <form method="POST" action="{{ route('warehouses.update',$warehouse) }}">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">الاسم</label>
        <input name="name" class="form-control" value="{{ $warehouse->name }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">الموقع</label>
        <input name="location" class="form-control" value="{{ $warehouse->location }}">
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('warehouses.show',$warehouse) }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
</div>
@endsection
