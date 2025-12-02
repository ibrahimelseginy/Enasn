@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">التبرعات</h4>
  <a href="{{ route('donations.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة تبرع</a>
</div>
<div class="row g-3">
  <div class="col-12">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">اليومية المالية للتبرعات النقدية</h5>
        <span class="text-muted small">آخر 14 يوم</span>
      </div>
      <table class="table mb-0">
        <thead>
          <tr>
            <th>اليوم</th>
            <th>عدد العمليات</th>
            <th>الإجمالي</th>
          </tr>
        </thead>
        <tbody>
          @foreach($dailyCashSummary as $row)
            <tr>
              <td>{{ $row['day'] }}</td>
              <td>{{ $row['count'] }}</td>
              <td>{{ number_format($row['total'],2) }}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="col-12">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">ملخص اليوم حسب القناة</h5>
        <span class="text-muted small">{{ now()->format('Y-m-d') }}</span>
      </div>
      <div class="row g-3 mt-2">
        <div class="col-md-4">
          <div class="border rounded p-3 bg-light">
            <div class="fw-bold">نقدي</div>
            <div class="small text-muted">عدد: {{ $todayByChannel['cash']['count'] }}</div>
            <div>إجمالي: {{ number_format($todayByChannel['cash']['total'],2) }}</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="border rounded p-3 bg-light">
            <div class="fw-bold">فودافون كاش</div>
            <div class="small text-muted">عدد: {{ $todayByChannel['vodafone_cash']['count'] }}</div>
            <div>إجمالي: {{ number_format($todayByChannel['vodafone_cash']['total'],2) }}</div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="border rounded p-3 bg-light">
            <div class="fw-bold">انستا باي</div>
            <div class="small text-muted">عدد: {{ $todayByChannel['instapay']['count'] }}</div>
            <div>إجمالي: {{ number_format($todayByChannel['instapay']['total'],2) }}</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">تبرعات نقدية</h5>
        <span class="badge bg-primary">نقدي</span>
      </div>
      <div class="mt-2">
        @forelse($cashDonations as $d)
          <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
            <div>
              <div class="fw-bold">{{ $d->donor?->name ?? '—' }}</div>
              <div class="small text-muted">{{ $d->received_at?->format('Y-m-d') ?? '—' }}</div>
            </div>
            <div class="text-end">
              <div class="small">الطريقة: {{ $d->cash_channel==='instapay'?'انستا باي':($d->cash_channel==='vodafone_cash'?'فودافون كاش':'نقدي') }}</div>
              <div class="small">رقم الإيصال: {{ $d->receipt_number ?? '—' }}</div>
              <div>{{ number_format($d->amount,2) }} {{ $d->currency }}</div>
              <div class="small">المشروع: {{ $d->project?->name ?? '—' }}</div>
              <div class="small">الحملة: {{ $d->campaign?->name ?? '—' }}</div>
            </div>
            <div class="ms-2 d-flex gap-2">
              <a class="btn btn-outline-primary btn-sm" href="{{ route('donations.show',$d) }}">عرض</a>
              @if($d->donor)
                <a class="btn btn-outline-info btn-sm" href="{{ route('donors.show',$d->donor) }}">عرض المتبرع</a>
              @endif
              <a class="btn btn-outline-secondary btn-sm" href="{{ route('donations.edit',$d) }}">تعديل</a>
            </div>
          </div>
        @empty
          <div class="text-muted">لا توجد عمليات</div>
        @endforelse
      </div>
      <div class="mt-2">{{ $cashDonations->links('pagination::bootstrap-5') }}</div>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-center">
        <h5 class="mb-0">تبرعات عينية</h5>
        <span class="badge bg-success">عيني</span>
      </div>
      <div class="mt-2">
        @forelse($inKindDonations as $d)
          <div class="border-bottom py-2 d-flex justify-content-between align-items-center">
            <div>
              <div class="fw-bold">{{ $d->donor?->name ?? '—' }}</div>
              <div class="small text-muted">{{ $d->received_at?->format('Y-m-d') ?? '—' }}</div>
            </div>
            <div class="text-end">
              <div>{{ number_format($d->estimated_value,2) }} {{ $d->currency }}</div>
              <div class="small">المخزن: {{ $d->warehouse?->name ?? '—' }}</div>
              <div class="small">المشروع: {{ $d->project?->name ?? '—' }}</div>
              <div class="small">الحملة: {{ $d->campaign?->name ?? '—' }}</div>
            </div>
            <div class="ms-2 d-flex gap-2">
              <a class="btn btn-outline-primary btn-sm" href="{{ route('donations.show',$d) }}">عرض</a>
              @if($d->donor)
                <a class="btn btn-outline-info btn-sm" href="{{ route('donors.show',$d->donor) }}">عرض المتبرع</a>
              @endif
              <a class="btn btn-outline-secondary btn-sm" href="{{ route('donations.edit',$d) }}">تعديل</a>
            </div>
          </div>
        @empty
          <div class="text-muted">لا توجد عمليات</div>
        @endforelse
      </div>
      <div class="mt-2">{{ $inKindDonations->links('pagination::bootstrap-5') }}</div>
    </div>
  </div>
</div>
@endsection
