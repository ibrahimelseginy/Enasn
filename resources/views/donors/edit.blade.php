@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">تعديل متبرع</h5>
  <form method="POST" action="{{ route('donors.update',$donor) }}">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">الاسم</label>
        <input name="name" class="form-control" value="{{ $donor->name }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">النوع</label>
        <select name="type" class="form-select">
          <option value="individual" @selected($donor->type==='individual')>فرد</option>
          <option value="organization" @selected($donor->type==='organization')>منظمة</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">الهاتف</label>
        <input name="phone" class="form-control" value="{{ $donor->phone }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">البريد</label>
        <input name="email" type="email" class="form-control" value="{{ $donor->email }}">
      </div>
      <div class="col-12">
        <label class="form-label">العنوان</label>
        <input name="address" class="form-control" value="{{ $donor->address }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">تصنيف</label>
        <select name="classification" class="form-select">
          <option value="one_time" @selected($donor->classification==='one_time')>مرة واحدة</option>
          <option value="recurring" @selected($donor->classification==='recurring')>متكرر</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">دورة التكرار</label>
        <select name="recurring_cycle" class="form-select">
          <option value="" @selected(!$donor->recurring_cycle)>—</option>
          <option value="monthly" @selected($donor->recurring_cycle==='monthly')>شهري</option>
          <option value="yearly" @selected($donor->recurring_cycle==='yearly')>سنوي</option>
        </select>
      </div>
      <div class="col-12">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="active" value="1" @checked($donor->active)>
          <label class="form-check-label">نشط</label>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label">نوع الكفالة/الصدقة</label>
        <select name="sponsorship_type" class="form-select" id="sType">
          <option value="none" @selected($donor->sponsorship_type==='none' || !$donor->sponsorship_type)>—</option>
          <option value="monthly_sponsor" @selected($donor->sponsorship_type==='monthly_sponsor')>كافل شهري</option>
          <option value="sadaqa_jariya" @selected($donor->sponsorship_type==='sadaqa_jariya')>صدقات جارية</option>
        </select>
      </div>
      <div class="col-md-6 s-fields" style="display:none">
        <label class="form-label">المشروع</label>
        <select name="sponsorship_project_id" class="form-select">
          @foreach($projects as $p)
            <option value="{{ $p->id }}" @selected($donor->sponsorship_project_id==$p->id)>{{ $p->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6 s-fields" style="display:none">
        <label class="form-label">مبلغ الكفالة الشهري</label>
        <input name="sponsorship_monthly_amount" class="form-control" value="{{ $donor->sponsorship_monthly_amount }}" placeholder="مثال: 500.00">
      </div>
      <div class="col-md-6 s-fields" style="display:none">
        <label class="form-label">الطفل المكفول</label>
        <select name="sponsored_beneficiary_id" class="form-select">
          <option value="">—</option>
          @foreach($beneficiaries as $b)
            <option value="{{ $b->id }}" @selected($donor->sponsored_beneficiary_id==$b->id)>{{ $b->full_name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('donors.show',$donor) }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
</div>
<script>
  (function(){ var s=document.getElementById('sType'); function t(){ var on=s.value!=='none'; document.querySelectorAll('.s-fields').forEach(e=>e.style.display=on?'block':'none'); } t(); s.addEventListener('change',t); })();
</script>
@endsection
