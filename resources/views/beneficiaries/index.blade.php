@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">المستفيدون</h4>
  <a href="{{ route('beneficiaries.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة مستفيد</a>
</div>
<div class="row g-3 mb-3">
  <div class="col-md-3">
    <div class="card p-3"><div class="small text-muted">إجمالي</div><div class="fs-5 fw-bold">{{ $stats['total'] }}</div></div>
  </div>
  <div class="col-md-3">
    <div class="card p-3"><div class="small text-muted">جديد</div><div class="fs-5 fw-bold">{{ $stats['new'] }}</div></div>
  </div>
  <div class="col-md-3">
    <div class="card p-3"><div class="small text-muted">تحت المراجعة</div><div class="fs-5 fw-bold">{{ $stats['under_review'] }}</div></div>
  </div>
  <div class="col-md-3">
    <div class="card p-3"><div class="small text-muted">مقبول</div><div class="fs-5 fw-bold">{{ $stats['accepted'] }}</div></div>
  </div>
</div>
<form method="GET" class="card p-3 mb-3">
  <div class="row g-2 align-items-end">
    <div class="col-md-4">
      <label class="form-label">بحث بالاسم/الهاتف/الرقم القومي</label>
      <input name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="ابحث...">
    </div>
    <div class="col-md-3">
      <label class="form-label">الحالة</label>
      <select name="status" class="form-select">
        <option value="">الكل</option>
        <option value="new" @selected(($status ?? '')==='new')>جديد</option>
        <option value="under_review" @selected(($status ?? '')==='under_review')>تحت المراجعة</option>
        <option value="accepted" @selected(($status ?? '')==='accepted')>مقبول</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">نوع المساعدة</label>
      <select name="assistance_type" class="form-select">
        <option value="">الكل</option>
        <option value="financial" @selected(($atype ?? '')==='financial')>مالية</option>
        <option value="in_kind" @selected(($atype ?? '')==='in_kind')>عينية</option>
        <option value="service" @selected(($atype ?? '')==='service')>خدمية</option>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">المشروع</label>
      <select name="project_id" class="form-select">
        <option value="">الكل</option>
        @foreach($projects as $p)
          <option value="{{ $p->id }}" @selected(($projectId ?? '')==$p->id)>{{ $p->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">الحملة</label>
      <select name="campaign_id" class="form-select">
        <option value="">الكل</option>
        @foreach($campaigns as $c)
          <option value="{{ $c->id }}" @selected(($campaignId ?? '')==$c->id)>{{ $c->name }} ({{ $c->season_year }})</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-2">
      <button class="btn btn-primary w-100">تصفية</button>
    </div>
  </div>
</form>
<div class="table-responsive">
<table class="table table-striped"><thead><tr><th>#</th><th>الاسم</th><th>الهاتف</th><th>الحالة</th><th>المساعدة</th><th>المشروع</th><th>الحملة</th><th></th></tr></thead><tbody>
@foreach($beneficiaries as $b)
<tr>
  <td>{{ $b->id }}</td>
  <td>{{ $b->full_name }}</td>
  <td>{{ $b->phone ?? '—' }}</td>
  <td>
    @php $s=$b->status; $cls = $s==='accepted' ? 'success' : ($s==='under_review' ? 'warning' : 'secondary'); @endphp
    <span class="badge bg-{{ $cls }}">{{ $b->status }}</span>
  </td>
  <td>
    @php $t=$b->assistance_type; $tcls = $t==='financial' ? 'primary' : ($t==='in_kind' ? 'info' : 'dark'); @endphp
    <span class="badge bg-{{ $tcls }}">{{ $b->assistance_type }}</span>
  </td>
  <td>{{ $b->project?->name ?? '—' }}</td>
  <td>{{ $b->campaign?->name ? ($b->campaign->name . ' (' . $b->campaign->season_year . ')') : '—' }}</td>
  <td class="text-end">
    <a class="btn btn-outline-primary btn-sm" href="{{ route('beneficiaries.show',$b) }}">عرض</a>
    <a class="btn btn-outline-secondary btn-sm" href="{{ route('beneficiaries.edit',$b) }}">تعديل</a>
    <form class="d-inline" method="POST" action="{{ route('beneficiaries.destroy',$b) }}" onsubmit="return confirm('حذف المستفيد؟');">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form>
  </td>
</tr>
@endforeach
</tbody></table>
</div>
<div class="mt-3">{{ $beneficiaries->links() }}</div>
@endsection
