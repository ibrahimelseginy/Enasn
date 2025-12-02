@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">إضافة مستفيد</h5>
  <form method="POST" action="{{ route('beneficiaries.store') }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">الاسم</label><input name="full_name" class="form-control" required></div>
      <div class="col-md-6"><label class="form-label">رقم قومي</label><input name="national_id" class="form-control"></div>
      <div class="col-md-6"><label class="form-label">الهاتف</label><input name="phone" class="form-control"></div>
      <div class="col-md-6"><label class="form-label">العنوان</label><input name="address" class="form-control"></div>
      <div class="col-md-6"><label class="form-label">نوع المساعدة</label>
        <select name="assistance_type" class="form-select" required>
          <option value="financial">مالية</option><option value="in_kind">عينية</option><option value="service">خدمة</option>
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">المشروع</label>
        <select name="project_id" class="form-select"><option value="">—</option>@foreach($projects as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select>
      </div>
      <div class="col-md-6"><label class="form-label">الحملة</label>
        <select name="campaign_id" class="form-select"><option value="">—</option>@foreach($campaigns as $c)<option value="{{ $c->id }}">{{ $c->name }} ({{ $c->season_year }})</option>@endforeach</select>
      </div>
    </div>
    <div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('beneficiaries.index') }}" class="btn btn-light">رجوع</a></div>
  </form>
</div>
@endsection
