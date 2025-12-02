@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">تعديل حركة مخزون</h5>
  <form method="POST" action="{{ route('inventory-transactions.update',$t) }}" id="invForm">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">الصنف</label>
        <select class="form-select" disabled>
          @foreach($items as $i)
            <option value="{{ $i->id }}" @selected($t->item_id==$i->id)>{{ $i->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">المخزن</label>
        <select class="form-select" disabled>
          @foreach($warehouses as $w)
            <option value="{{ $w->id }}" @selected($t->warehouse_id==$w->id)>{{ $w->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">النوع</label>
        <select name="type" class="form-select" id="invType">
          <option value="in" @selected($t->type==='in')>إدخال</option>
          <option value="transfer" @selected($t->type==='transfer')>تحويل</option>
          <option value="out" @selected($t->type==='out')>صرف</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">الكمية</label>
        <input name="quantity" class="form-control" value="{{ $t->quantity }}">
      </div>
      <div class="col-md-4 out-only">
        <label class="form-label">المستفيد</label>
        <select name="beneficiary_id" class="form-select">
          <option value="">—</option>
          @foreach($beneficiaries as $b)
            <option value="{{ $b->id }}" @selected($t->beneficiary_id==$b->id)>{{ $b->full_name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">المشروع</label>
        <select name="project_id" class="form-select">
          <option value="">—</option>
          @foreach($projects as $p)
            <option value="{{ $p->id }}" @selected($t->project_id==$p->id)>{{ $p->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">الحملة</label>
        <select name="campaign_id" class="form-select">
          <option value="">—</option>
          @foreach($campaigns as $c)
            <option value="{{ $c->id }}" @selected($t->campaign_id==$c->id)>{{ $c->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">مرجع</label>
        <input name="reference" class="form-control" value="{{ $t->reference }}">
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('inventory-transactions.show',$t) }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
</div>
<script>
const t=document.getElementById('invType');
function toggle(){
  document.querySelectorAll('.out-only').forEach(e=>e.style.display=t.value==='out'?'block':'none');
}
toggle(); t.addEventListener('change',toggle);
</script>
@endsection
