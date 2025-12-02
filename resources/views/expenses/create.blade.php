@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">إضافة مصروف</h5>
  <form method="POST" action="{{ route('expenses.store') }}">
    @csrf
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">النوع</label><select name="type" class="form-select" required><option value="operational">تشغيلي</option><option value="aid">مساعدات</option><option value="logistics">لوجستي</option></select></div>
      <div class="col-md-6"><label class="form-label">المبلغ</label><input name="amount" class="form-control" required></div>
      <div class="col-md-6"><label class="form-label">العملة</label><input name="currency" class="form-control" value="EGP"></div>
      <div class="col-md-6"><label class="form-label">المستفيد</label><select name="beneficiary_id" class="form-select"><option value="">—</option>@foreach($beneficiaries as $b)<option value="{{ $b->id }}">{{ $b->full_name }}</option>@endforeach</select></div>
      <div class="col-md-6"><label class="form-label">المشروع</label><select name="project_id" class="form-select"><option value="">—</option>@foreach($projects as $p)<option value="{{ $p->id }}">{{ $p->name }}</option>@endforeach</select></div>
      <div class="col-md-6"><label class="form-label">الحملة</label><select name="campaign_id" class="form-select"><option value="">—</option>@foreach($campaigns as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach</select></div>
      <div class="col-12"><label class="form-label">وصف</label><textarea name="description" class="form-control" rows="2"></textarea></div>
    </div>
    <div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('expenses.index') }}" class="btn btn-light">رجوع</a></div>
  </form>
</div>
@endsection
