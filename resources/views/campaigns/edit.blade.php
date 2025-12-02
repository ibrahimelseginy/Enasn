@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">تعديل حملة</h5>
  <form method="POST" action="{{ route('campaigns.update',$campaign) }}">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">الاسم</label>
        <input name="name" class="form-control" value="{{ $campaign->name }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">السنة</label>
        <input name="season_year" class="form-control" type="number" value="{{ $campaign->season_year }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">تاريخ البداية</label>
        <input name="start_date" class="form-control" type="date" value="{{ $campaign->start_date?->format('Y-m-d') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">تاريخ النهاية</label>
        <input name="end_date" class="form-control" type="date" value="{{ $campaign->end_date?->format('Y-m-d') }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">الحالة</label>
        <select name="status" class="form-select">
          <option value="active" @selected($campaign->status==='active')>نشط</option>
          <option value="archived" @selected($campaign->status==='archived')>مؤرشف</option>
        </select>
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('campaigns.show',$campaign) }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
</div>
@endsection

