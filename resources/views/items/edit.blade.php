@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">تعديل صنف</h5>
  <form method="POST" action="{{ route('items.update',$item) }}">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">الاسم</label>
        <input name="name" class="form-control" value="{{ $item->name }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">SKU</label>
        <input name="sku" class="form-control" value="{{ $item->sku }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">الوحدة</label>
        <input name="unit" class="form-control" value="{{ $item->unit }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">القيمة التقديرية</label>
        <input name="estimated_value" class="form-control" value="{{ $item->estimated_value }}">
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('items.show',$item) }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
</div>
@endsection
