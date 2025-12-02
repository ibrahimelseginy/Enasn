@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">تعديل مستفيد</h5>
  <form method="POST" action="{{ route('beneficiaries.update',$beneficiary) }}">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">الاسم</label><input name="full_name" class="form-control" value="{{ $beneficiary->full_name }}"></div>
      <div class="col-md-6"><label class="form-label">رقم قومي</label><input name="national_id" class="form-control" value="{{ $beneficiary->national_id }}"></div>
      <div class="col-md-6"><label class="form-label">الهاتف</label><input name="phone" class="form-control" value="{{ $beneficiary->phone }}"></div>
      <div class="col-md-6"><label class="form-label">العنوان</label><input name="address" class="form-control" value="{{ $beneficiary->address }}"></div>
      <div class="col-md-6"><label class="form-label">نوع المساعدة</label>
        <select name="assistance_type" class="form-select">
          <option value="financial" @selected($beneficiary->assistance_type==='financial')>مالية</option>
          <option value="in_kind" @selected($beneficiary->assistance_type==='in_kind')>عينية</option>
          <option value="service" @selected($beneficiary->assistance_type==='service')>خدمة</option>
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">الحالة</label>
        <select name="status" class="form-select">
          <option value="new" @selected($beneficiary->status==='new')>جديد</option>
          <option value="under_review" @selected($beneficiary->status==='under_review')>تحت المراجعة</option>
          <option value="accepted" @selected($beneficiary->status==='accepted')>مقبول</option>
        </select>
      </div>
      <div class="col-md-6"><label class="form-label">المشروع</label>
        <select name="project_id" class="form-select"><option value="">—</option>@foreach($projects as $p)<option value="{{ $p->id }}" @selected($beneficiary->project_id==$p->id)>{{ $p->name }}</option>@endforeach</select>
      </div>
      <div class="col-md-6"><label class="form-label">الحملة</label>
        <select name="campaign_id" class="form-select"><option value="">—</option>@foreach($campaigns as $c)<option value="{{ $c->id }}" @selected($beneficiary->campaign_id==$c->id)>{{ $c->name }} ({{ $c->season_year }})</option>@endforeach</select>
      </div>
    </div>
    <div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('beneficiaries.show',$beneficiary) }}" class="btn btn-light">رجوع</a></div>
  </form>
</div>
@endsection
