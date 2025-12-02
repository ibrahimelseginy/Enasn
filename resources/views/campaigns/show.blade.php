@extends('layouts.app')
@section('content')
<div class="card p-4">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="mb-0">{{ $campaign->name }} ({{ $campaign->season_year }})</h5>
    <a class="btn btn-secondary" href="{{ route('campaigns.edit',$campaign) }}">تعديل</a>
  </div>
  <div class="mt-3">
    <div>الحالة: {{ $campaign->status }}</div>
    <div>البداية: {{ $campaign->start_date?->format('Y-m-d') ?? '—' }}</div>
    <div>النهاية: {{ $campaign->end_date?->format('Y-m-d') ?? '—' }}</div>
  </div>
  <div class="row g-3 mt-3">
    <div class="col-md-3"><div class="card p-3"><div class="small text-muted">التبرعات</div><div class="fs-5 fw-bold">{{ $donationsCount }}</div></div></div>
    <div class="col-md-3"><div class="card p-3"><div class="small text-muted">نقدية</div><div class="fs-5 fw-bold">{{ number_format($cashSum,2) }}</div></div></div>
    <div class="col-md-3"><div class="card p-3"><div class="small text-muted">عينية (قيمة)</div><div class="fs-5 fw-bold">{{ number_format($inKindSum,2) }}</div></div></div>
    <div class="col-md-3"><div class="card p-3"><div class="small text-muted">المستفيدون</div><div class="fs-5 fw-bold">{{ $beneficiariesCount }}</div></div></div>
    <div class="col-md-3"><div class="card p-3"><div class="small text-muted">المصروفات</div><div class="fs-5 fw-bold">{{ $expensesCount }}</div></div></div>
  </div>
  <div class="mt-4">
    <h6>أحدث التحركات</h6>
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card p-3">
          <div class="fw-bold mb-2">تبرعات</div>
          <ul class="mb-0">
            @foreach($latestDonations as $d)
            <li>#{{ $d->id }} • {{ $d->type==='cash' ? ('نقدي: ' . $d->amount) : ('عيني: ' . $d->estimated_value) }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <div class="fw-bold mb-2">مصروفات</div>
          <ul class="mb-0">
            @foreach($latestExpenses as $e)
            <li>#{{ $e->id }} • {{ $e->type }} • {{ $e->amount }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <div class="fw-bold mb-2">مستفيدون</div>
          <ul class="mb-0">
            @foreach($latestBeneficiaries as $b)
            <li>#{{ $b->id }} • {{ $b->full_name }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="mt-3">
    <a href="{{ route('campaigns.index') }}" class="btn btn-light">رجوع</a>
  </div>
</div>
@endsection
