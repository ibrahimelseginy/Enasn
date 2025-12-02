@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">إضافة تبرع</h5>
  <form method="POST" action="{{ route('donations.store') }}" id="donationForm">
    @csrf
    <div class="row g-3">
      <div class="col-md-6" id="donorSelectWrap">
        <label class="form-label">المتبرع</label>
        <select name="donor_id" class="form-select" required id="donorSel">
          @foreach($donors as $dn)
            <option value="{{ $dn->id }}" @selected(request('donor_id')==$dn->id) 
              data-name="{{ $dn->name }}" 
              data-sptype="{{ $dn->sponsorship_type ?? 'none' }}" 
              data-spproject="{{ $dn->sponsorship_project_id ?? '' }}" 
              data-spbeneficiary="{{ $dn->sponsored_beneficiary_id ?? '' }}"
              data-spamount="{{ $dn->sponsorship_monthly_amount ?? '' }}"
            >{{ $dn->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">النوع</label>
        <select name="type" class="form-select" required id="donationType">
          <option value="cash">نقدي</option>
          <option value="in_kind">عيني</option>
        </select>
      </div>
      <div class="col-md-6 cash-only">
        <label class="form-label">المبلغ</label>
        <input name="amount" class="form-control">
      </div>
      <div class="col-md-6 cash-only">
        <label class="form-label">طريقة الدفع</label>
        <select name="cash_channel" class="form-select">
          <option value="cash">نقدي</option>
          <option value="instapay">انستا باي</option>
          <option value="vodafone_cash">فودافون كاش</option>
        </select>
      </div>
      <div class="col-md-6 cash-only">
        <label class="form-label">رقم الإيصال</label>
        <input name="receipt_number" class="form-control" placeholder="مثال: RC-2025-000123">
      </div>
      <div class="col-md-6">
        <label class="form-label">العملة</label>
        <input name="currency" class="form-control" value="EGP">
      </div>
      <div class="col-md-6 in-kind-only">
        <label class="form-label">القيمة التقديرية</label>
        <input name="estimated_value" class="form-control">
      </div>
      <div class="col-md-6 in-kind-only">
        <label class="form-label">المخزن</label>
        <select name="warehouse_id" class="form-select">
          @foreach($warehouses as $w)
            <option value="{{ $w->id }}">{{ $w->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">المشروع</label>
        <select name="project_id" class="form-select" id="projectSel">
          <option value="">—</option>
          @foreach($projects as $p)
            <option value="{{ $p->id }}">{{ $p->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12" id="sponsorInfo" style="display:none">
        <div class="alert alert-info d-flex justify-content-between align-items-center">
          <div>
            <div>الكافل: <span id="sponsorName"></span></div>
            <div>يكفل الطفل: <span id="sponsorChild"></span></div>
            <div>المبلغ الشهري: <span id="sponsorAmount"></span></div>
          </div>
          <div class="small">مشروع بعثاء الامل</div>
        </div>
      </div>
      <div class="col-md-6">
        <label class="form-label">الحملة</label>
        <select name="campaign_id" class="form-select">
          <option value="">—</option>
          @foreach($campaigns as $c)
            <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->season_year }})</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">المندوب</label>
        <select name="delegate_id" class="form-select">
          <option value="">—</option>
          @foreach($delegates as $d)
            <option value="{{ $d->id }}">{{ $d->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">خط السير</label>
        <select name="route_id" class="form-select">
          <option value="">—</option>
          @foreach($routes as $r)
            <option value="{{ $r->id }}">{{ $r->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">ملاحظة تخصيص</label>
        <textarea name="allocation_note" class="form-control" rows="2"></textarea>
      </div>
      <div class="col-md-6">
        <label class="form-label">تاريخ الاستلام</label>
        <input name="received_at" type="date" class="form-control" value="{{ now()->format('Y-m-d') }}">
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('donations.index') }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
</div>
<script>
const beneficiariesMap = {
@foreach($beneficiaries as $b)
  "{{ $b->id }}": "{{ $b->full_name }}",
@endforeach
};
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
const donorSel=document.getElementById('donorSel');
const projectSel=document.getElementById('projectSel');
const sponsorInfo=document.getElementById('sponsorInfo');
const sponsorName=document.getElementById('sponsorName');
const sponsorChild=document.getElementById('sponsorChild');
const sponsorAmount=document.getElementById('sponsorAmount');
function updateSponsor(){
  const opt=donorSel.options[donorSel.selectedIndex];
  const sptype=opt.getAttribute('data-sptype');
  const sprj=opt.getAttribute('data-spproject')||'';
  const spchild=opt.getAttribute('data-spbeneficiary')||'';
  const spamount=opt.getAttribute('data-spamount')||'';
  const prj=projectSel.value||'';
  const show= sptype && sptype!=='none' && sprj && prj && sprj===prj;
  if(show){
    sponsorInfo.style.display='block';
    sponsorName.textContent=opt.getAttribute('data-name')||'';
    sponsorChild.textContent=beneficiariesMap[spchild]||'—';
    sponsorAmount.textContent=spamount?Number(spamount).toFixed(2):'—';
  } else {
    sponsorInfo.style.display='none';
  }
}
donorSel.addEventListener('change',updateSponsor);
projectSel.addEventListener('change',updateSponsor);
updateSponsor();
</script>
@endsection
  <div class="card p-3 mb-3">
    <div class="d-flex gap-3">
      <div class="form-check">
        <input class="form-check-input" type="radio" name="donorMode" id="modeExisting" value="existing" @if(request('donor_id')) checked @endif>
        <label class="form-check-label" for="modeExisting">متبرع قديم</label>
      </div>
      <div class="form-check">
        <input class="form-check-input" type="radio" name="donorMode" id="modeNew" value="new" @if(!request('donor_id')) checked @endif>
        <label class="form-check-label" for="modeNew">متبرع جديد</label>
      </div>
    </div>
    <div id="existingDonorPanel" class="mt-3">
      <div class="row g-2 align-items-end">
        <div class="col-md-6">
          <label class="form-label">ابحث عن المتبرع</label>
          <input type="text" id="donorSearch" class="form-control" placeholder="اكتب اسم المتبرع">
        </div>
      </div>
    </div>
    <div id="newDonorPanel" class="mt-3" style="display:none">
      <a class="btn btn-outline-primary" href="{{ route('donors.create',['return_to'=>'donations.create']) }}">إنشاء متبرع جديد والانتقال للإضافة</a>
    </div>
  </div>
const modeExisting=document.getElementById('modeExisting');
const modeNew=document.getElementById('modeNew');
const existingPanel=document.getElementById('existingDonorPanel');
const newPanel=document.getElementById('newDonorPanel');
const donorSelectWrap=document.getElementById('donorSelectWrap');
const donationFields=document.querySelector('form[action*="donations.store"]')?document.querySelector('form[action*="donations.store"]').closest('.card'):document.querySelector('.card');
function toggleMode(){
  const isExisting=modeExisting.checked;
  existingPanel.style.display=isExisting?'block':'none';
  donorSelectWrap.style.display=isExisting?'block':'none';
  newPanel.style.display=isExisting?'none':'block';
}
modeExisting.addEventListener('change',toggleMode);
modeNew.addEventListener('change',toggleMode);
toggleMode();
const donorSearch=document.getElementById('donorSearch');
if(donorSearch){ donorSearch.addEventListener('input', function(){
  const sel=donorSel; const term=this.value.trim().toLowerCase();
  for(let i=0;i<sel.options.length;i++){ const opt=sel.options[i]; const name=opt.text.toLowerCase(); opt.hidden= term && !name.includes(term); }
}); }
