@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">تعديل تبرع</h5>
  <form method="POST" action="{{ route('donations.update',$donation) }}" id="donationForm">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">المتبرع</label>
        <select name="donor_id" class="form-select" disabled>
          @foreach($donors as $dn)
            <option value="{{ $dn->id }}" @selected($donation->donor_id==$dn->id)>{{ $dn->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">النوع</label>
        <select name="type" class="form-select" id="donationType">
          <option value="cash" @selected($donation->type==='cash')>نقدي</option>
          <option value="in_kind" @selected($donation->type==='in_kind')>عيني</option>
        </select>
      </div>
      <div class="col-md-6 cash-only">
        <label class="form-label">المبلغ</label>
        <input name="amount" class="form-control" value="{{ $donation->amount }}">
      </div>
      <div class="col-md-6 cash-only">
        <label class="form-label">طريقة الدفع</label>
        <select name="cash_channel" class="form-select">
          <option value="cash" @selected($donation->cash_channel==='cash')>نقدي</option>
          <option value="instapay" @selected($donation->cash_channel==='instapay')>انستا باي</option>
          <option value="vodafone_cash" @selected($donation->cash_channel==='vodafone_cash')>فودافون كاش</option>
        </select>
      </div>
      <div class="col-md-6 cash-only">
        <label class="form-label">رقم الإيصال</label>
        <input name="receipt_number" class="form-control" value="{{ $donation->receipt_number }}" placeholder="مثال: RC-2025-000123">
      </div>
      <div class="col-md-6">
        <label class="form-label">العملة</label>
        <input name="currency" class="form-control" value="{{ $donation->currency }}">
      </div>
      <div class="col-md-6 in-kind-only">
        <label class="form-label">القيمة التقديرية</label>
        <input name="estimated_value" class="form-control" value="{{ $donation->estimated_value }}">
      </div>
      <div class="col-md-6 in-kind-only">
        <label class="form-label">المخزن</label>
        <select name="warehouse_id" class="form-select">
          @foreach($warehouses as $w)
            <option value="{{ $w->id }}" @selected($donation->warehouse_id==$w->id)>{{ $w->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">المشروع</label>
        <select name="project_id" class="form-select">
          <option value="">—</option>
          @foreach($projects as $p)
            <option value="{{ $p->id }}" @selected($donation->project_id==$p->id)>{{ $p->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">الحملة</label>
        <select name="campaign_id" class="form-select">
          <option value="">—</option>
          @foreach($campaigns as $c)
            <option value="{{ $c->id }}" @selected($donation->campaign_id==$c->id)>{{ $c->name }} ({{ $c->season_year }})</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">المندوب</label>
        <select name="delegate_id" class="form-select">
          <option value="">—</option>
          @foreach($delegates as $d)
            <option value="{{ $d->id }}" @selected($donation->delegate_id==$d->id)>{{ $d->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">خط السير</label>
        <select name="route_id" class="form-select">
          <option value="">—</option>
          @foreach($routes as $r)
            <option value="{{ $r->id }}" @selected($donation->route_id==$r->id)>{{ $r->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">ملاحظة تخصيص</label>
        <textarea name="allocation_note" class="form-control" rows="2">{{ $donation->allocation_note }}</textarea>
      </div>
      <div class="col-md-6">
        <label class="form-label">تاريخ الاستلام</label>
        <input name="received_at" type="date" class="form-control" value="{{ optional($donation->received_at)->format('Y-m-d') }}">
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('donations.show',$donation) }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
</div>
<script>
const t=document.getElementById('donationType');
function toggle(){
  const cash=document.querySelectorAll('.cash-only');
  const kind=document.querySelectorAll('.in-kind-only');
  const isCash=t.value==='cash';
  cash.forEach(e=>e.style.display=isCash?'block':'none');
  kind.forEach(e=>e.style.display=isCash?'none':'block');
}
toggle();
t.addEventListener('change',toggle);
</script>
@endsection
