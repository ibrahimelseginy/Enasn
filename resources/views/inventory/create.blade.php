@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">إضافة حركة مخزون</h5>
  <form method="POST" action="{{ route('inventory-transactions.store') }}" id="invForm">
    @csrf
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">الصنف</label>
        <select name="item_id" class="form-select" required>
          @foreach($items as $i)
            <option value="{{ $i->id }}">{{ $i->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">المخزن</label>
        <select name="warehouse_id" class="form-select" required>
          @foreach($warehouses as $w)
            <option value="{{ $w->id }}">{{ $w->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">النوع</label>
        <select name="type" class="form-select" required id="invType">
          <option value="in">إدخال</option>
          <option value="transfer">تحويل</option>
          <option value="out">صرف</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">الكمية</label>
        <input name="quantity" class="form-control" required>
      </div>
      <div class="col-md-4 in-only">
        <label class="form-label">مصدر التبرع العيني</label>
        <select name="source_donation_id" class="form-select">
          <option value="">—</option>
          @foreach($donations as $d)
            <option value="{{ $d->id }}">#{{ $d->id }} - {{ $d->donor?->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4 out-only">
        <label class="form-label">المستفيد</label>
        <select name="beneficiary_id" class="form-select">
          <option value="">—</option>
          @foreach($beneficiaries as $b)
            <option value="{{ $b->id }}">{{ $b->full_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">المشروع</label>
        <select name="project_id" class="form-select">
          <option value="">—</option>
          @foreach($projects as $p)
            <option value="{{ $p->id }}">{{ $p->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">الحملة</label>
        <select name="campaign_id" class="form-select">
          <option value="">—</option>
          @foreach($campaigns as $c)
            <option value="{{ $c->id }}">{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">مرجع</label>
        <input name="reference" class="form-control">
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('inventory-transactions.index') }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
</div>
<script>
const t=document.getElementById('invType');
function toggle(){
  document.querySelectorAll('.in-only').forEach(e=>e.style.display=t.value==='in'?'block':'none');
  document.querySelectorAll('.out-only').forEach(e=>e.style.display=t.value==='out'?'block':'none');
}
toggle(); t.addEventListener('change',toggle);
</script>
@endsection
