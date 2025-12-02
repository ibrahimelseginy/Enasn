@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">تعديل مصروف</h5>
  <form method="POST" action="{{ route('expenses.update',$expense) }}">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">النوع</label><select name="type" class="form-select"><option value="operational" @selected($expense->type==='operational')>تشغيلي</option><option value="aid" @selected($expense->type==='aid')>مساعدات</option><option value="logistics" @selected($expense->type==='logistics')>لوجستي</option></select></div>
      <div class="col-md-6"><label class="form-label">المبلغ</label><input name="amount" class="form-control" value="{{ $expense->amount }}"></div>
      <div class="col-md-6"><label class="form-label">العملة</label><input name="currency" class="form-control" value="{{ $expense->currency }}"></div>
      <div class="col-md-6"><label class="form-label">المستفيد</label><select name="beneficiary_id" class="form-select"><option value="">—</option>@foreach($beneficiaries as $b)<option value="{{ $b->id }}" @selected($expense->beneficiary_id==$b->id)>{{ $b->full_name }}</option>@endforeach</select></div>
      <div class="col-md-6"><label class="form-label">المشروع</label><select name="project_id" class="form-select"><option value="">—</option>@foreach($projects as $p)<option value="{{ $p->id }}" @selected($expense->project_id==$p->id)>{{ $p->name }}</option>@endforeach</select></div>
      <div class="col-md-6"><label class="form-label">الحملة</label><select name="campaign_id" class="form-select"><option value="">—</option>@foreach($campaigns as $c)<option value="{{ $c->id }}" @selected($expense->campaign_id==$c->id)>{{ $c->name }}</option>@endforeach</select></div>
      <div class="col-12"><label class="form-label">وصف</label><textarea name="description" class="form-control" rows="2">{{ $expense->description }}</textarea></div>
    </div>
    <div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('expenses.show',$expense) }}" class="btn btn-light">رجوع</a></div>
  </form>
</div>
@endsection
