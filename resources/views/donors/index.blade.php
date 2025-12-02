@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">المتبرعون</h4>
  <a href="{{ route('donors.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة متبرع</a>
  </div>
<div class="card p-3 mb-3">
  <form method="GET" class="row g-2 align-items-end">
    <div class="col-md-4">
      <label class="form-label">بحث</label>
      <input name="q" value="{{ $q }}" class="form-control" placeholder="اسم/هاتف/بريد">
    </div>
    <div class="col-md-2">
      <label class="form-label">النوع</label>
      <select name="type" class="form-select">
        <option value="">الكل</option>
        <option value="individual" @selected($type==='individual')>فرد</option>
        <option value="organization" @selected($type==='organization')>منظمة</option>
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label">تصنيف</label>
      <select name="classification" class="form-select">
        <option value="">الكل</option>
        <option value="one_time" @selected($classification==='one_time')>مرة واحدة</option>
        <option value="recurring" @selected($classification==='recurring')>متكرر</option>
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label">الحالة</label>
      <select name="active" class="form-select">
        <option value="">الكل</option>
        <option value="1" @selected($active==='1')>نشط</option>
        <option value="0" @selected($active==='0')>غير نشط</option>
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">تصفية</button>
    </div>
  </form>
  <div class="mt-2 d-flex gap-2">
    <span class="badge bg-primary">الكل: {{ $totals['all'] }}</span>
    <span class="badge bg-success">نشط: {{ $totals['active'] }}</span>
    <span class="badge bg-info">متكرر: {{ $totals['recurring'] }}</span>
    <span class="badge bg-secondary">مرة واحدة: {{ $totals['one_time'] }}</span>
  </div>
</div>
<div class="card p-3 mb-3">
  <div class="d-flex gap-3">
    <div class="form-check">
      <input class="form-check-input" type="radio" name="donorMode" id="modeNew" value="new" checked>
      <label class="form-check-label" for="modeNew">متبرع جديد</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="donorMode" id="modeExisting" value="existing">
      <label class="form-check-label" for="modeExisting">متبرع قديم</label>
    </div>
  </div>
  <div id="newDonorPanel" class="mt-3">
    <form method="POST" action="{{ route('donors.store') }}" class="row g-3">
      @csrf
      <div class="col-md-6"><label class="form-label">الاسم</label><input name="name" class="form-control" required></div>
      <div class="col-md-6"><label class="form-label">النوع</label><select name="type" class="form-select"><option value="individual">فرد</option><option value="organization">منظمة</option></select></div>
      <div class="col-md-6"><label class="form-label">الهاتف</label><input name="phone" class="form-control"></div>
      <div class="col-md-6"><label class="form-label">البريد</label><input name="email" type="email" class="form-control"></div>
      <div class="col-12"><label class="form-label">العنوان</label><input name="address" class="form-control"></div>
      <div class="col-md-6"><label class="form-label">تصنيف</label><select name="classification" class="form-select"><option value="one_time">مرة واحدة</option><option value="recurring">متكرر</option></select></div>
      <div class="col-md-6"><label class="form-label">دورية</label><select name="recurring_cycle" class="form-select"><option value="">—</option><option value="monthly">شهري</option><option value="yearly">سنوي</option></select></div>
      <div class="col-12"><button class="btn btn-success">حفظ المتبرع</button></div>
    </form>
  </div>
  <div id="existingDonorPanel" class="mt-3" style="display:none">
    <form method="GET" class="row g-3 align-items-end">
      <div class="col-md-6">
        <label class="form-label">اختر المتبرع</label>
        <select name="selected_donor_id" class="form-select" onchange="this.form.submit()">
          <option value="">—</option>
          @foreach($allDonors as $dn)
            <option value="{{ $dn->id }}" @selected($selectedDonorId==$dn->id)>{{ $dn->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6"><a href="{{ route('donations.create', ['donor_id' => $selectedDonorId]) }}" class="btn btn-primary" @if(!$selectedDonorId) disabled @endif>إضافة تبرع</a></div>
    </form>
    @if($selectedDonor)
      <div class="mt-3">
        <h6 class="mb-2">السجل</h6>
        <div class="list-group">
          @forelse($donationsHistory as $d)
            <div class="list-group-item d-flex justify-content-between align-items-center">
              <div>#{{ $d->id }} • {{ $d->received_at?->format('Y-m-d') ?? '—' }} • {{ $d->type==='cash' ? ('نقدي: ' . number_format($d->amount,2)) : ('عيني: ' . number_format($d->estimated_value,2)) }}</div>
              <div class="small">مشروع: {{ $d->project?->name ?? '—' }} | حملة: {{ $d->campaign?->name ?? '—' }}</div>
              <a class="btn btn-outline-secondary btn-sm" href="{{ route('donations.show',$d) }}">عرض</a>
            </div>
          @empty
            <div class="alert alert-secondary mb-0">لا يوجد تاريخ تبرعات</div>
          @endforelse
        </div>
      </div>
      <div class="mt-3">
        <h6 class="mb-2">تبرع سريع</h6>
        <form method="POST" action="{{ route('donations.store') }}" id="quickDonation" class="row g-3">
          @csrf
          <input type="hidden" name="donor_id" value="{{ $selectedDonor->id }}">
          <div class="col-md-4"><label class="form-label">النوع</label><select name="type" id="qdType" class="form-select"><option value="cash">نقدي</option><option value="in_kind">عيني</option></select></div>
          <div class="col-md-4 qd-cash"><label class="form-label">المبلغ</label><input name="amount" class="form-control"></div>
          <div class="col-md-4 qd-cash"><label class="form-label">طريقة الدفع</label><select name="cash_channel" class="form-select"><option value="cash">نقدي</option><option value="instapay">انستا باي</option><option value="vodafone_cash">فودافون كاش</option></select></div>
          <div class="col-md-4 qd-cash"><label class="form-label">رقم الإيصال</label><input name="receipt_number" class="form-control" placeholder="مثال: RC-2025-000123"></div>
          <div class="col-md-4"><label class="form-label">العملة</label><input name="currency" class="form-control" value="EGP"></div>
          <div class="col-md-4 qd-kind" style="display:none"><label class="form-label">القيمة التقديرية</label><input name="estimated_value" class="form-control"></div>
          <div class="col-md-4"><label class="form-label">تاريخ الاستلام</label><input name="received_at" type="date" class="form-control" value="{{ now()->format('Y-m-d') }}"></div>
          <div class="col-12"><button class="btn btn-success">حفظ التبرع</button></div>
        </form>
      </div>
    @endif
  </div>
  <script>
  (function(){
    var modeNew=document.getElementById('modeNew');
    var modeExisting=document.getElementById('modeExisting');
    var panelNew=document.getElementById('newDonorPanel');
    var panelExisting=document.getElementById('existingDonorPanel');
    function toggle(){ var isNew=modeNew.checked; panelNew.style.display=isNew?'block':'none'; panelExisting.style.display=isNew?'none':'block'; }
    modeNew.addEventListener('change',toggle); modeExisting.addEventListener('change',toggle); toggle();
    var t=document.getElementById('qdType'); if (t){ function tt(){ var isCash=t.value==='cash'; document.querySelectorAll('.qd-cash').forEach(function(e){ e.style.display=isCash?'block':'none'; }); document.querySelectorAll('.qd-kind').forEach(function(e){ e.style.display=isCash?'none':'block'; }); } tt(); t.addEventListener('change',tt); }
  })();
  </script>
</div>
<div class="row g-3">
@foreach($donors as $donor)
  <div class="col-md-4">
    <div class="card p-3">
      <div class="d-flex justify-content-between">
        <div>
          <div class="fw-bold">{{ $donor->name }}</div>
          <div class="text-muted small">{{ $donor->type === 'individual' ? 'فرد' : 'منظمة' }}</div>
        </div>
        <span class="badge bg-{{ $donor->classification==='recurring' ? 'success' : 'secondary' }}">{{ $donor->classification==='recurring' ? 'متكرر' : 'مرة واحدة' }}</span>
      </div>
      <div class="mt-2 small">
        @if($donor->phone) <div><i class="bi bi-telephone"></i> {{ $donor->phone }}</div> @endif
        @php $st = $donStats->get($donor->id); @endphp
        <div><i class="bi bi-gift"></i> تبرعات: {{ $st ? $st->count : 0 }} | إجمالي: {{ $st ? number_format($st->total,2) : '0.00' }}</div>
      </div>
      <div class="mt-3 d-flex gap-2">
        <a class="btn btn-outline-primary btn-sm" href="{{ route('donors.show',$donor) }}">عرض</a>
        <a class="btn btn-outline-secondary btn-sm" href="{{ route('donors.edit',$donor) }}">تعديل</a>
        <a class="btn btn-outline-success btn-sm" href="{{ route('donations.create', ['donor_id' => $donor->id]) }}">تبرع جديد</a>
        <form method="POST" action="{{ route('donors.destroy',$donor) }}" onsubmit="return confirm('حذف المتبرع؟');">
          @csrf @method('DELETE')
          <button class="btn btn-outline-danger btn-sm">حذف</button>
        </form>
      </div>
    </div>
  </div>
@endforeach
</div>
<div class="mt-3">{{ $donors->links() }}</div>
@endsection
