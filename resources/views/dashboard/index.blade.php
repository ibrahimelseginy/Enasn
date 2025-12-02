@extends('layouts.app')
@section('content')
<style>
.kpi-card{border:none;border-radius:16px;box-shadow:0 10px 24px rgba(13,110,253,.08)}
.chart-wrap{border:none;border-radius:16px;box-shadow:0 10px 24px rgba(13,110,253,.08)}
.bar-grid{display:flex;align-items:flex-end;gap:8px;height:180px;padding:12px;background:#f8fbff;border-radius:12px}
.bar{width:18px;border-radius:6px 6px 0 0}
.bar.cash{background:var(--primary)}
.bar.kind{background:var(--accent)}
.bar-labels{display:flex;gap:8px;justify-content:space-between}
.chip{display:inline-block;padding:.25rem .5rem;border-radius:999px;background:#eef5ff;color:#0b5ed7;font-weight:600}
.list-simple li{display:flex;justify-content:space-between}
</style>
<div class="row g-3 mb-3">
  <div class="col-md-3"><div class="card kpi-card p-3 text-center"><div class="small text-muted">المتبرعون</div><div class="display-6">{{ $donorsCount }}</div></div></div>
  <div class="col-md-3"><div class="card kpi-card p-3 text-center"><div class="small text-muted">المستفيدون</div><div class="display-6">{{ $beneficiariesCount }}</div></div></div>
  <div class="col-md-3"><div class="card kpi-card p-3 text-center"><div class="small text-muted">المخازن</div><div class="display-6">{{ $warehousesCount }}</div></div></div>
  <div class="col-md-3"><div class="card kpi-card p-3 text-center"><div class="small text-muted">المتطوعون</div><div class="display-6">{{ $volunteersCount }}</div></div></div>
</div>
<div class="row g-3 mb-3">
  <div class="col-md-3"><div class="card kpi-card p-3 text-center"><div class="small text-muted">تبرعات نقدية (هذا الشهر)</div><div class="h4 mb-0">{{ number_format($cashMonth,2) }}</div></div></div>
  <div class="col-md-3"><div class="card kpi-card p-3 text-center"><div class="small text-muted">تبرعات عينية (هذا الشهر)</div><div class="h4 mb-0">{{ number_format($inKindMonth,2) }}</div></div></div>
  <div class="col-md-3"><div class="card kpi-card p-3 text-center"><div class="small text-muted">مصروفات (هذا الشهر)</div><div class="h4 mb-0">{{ number_format($expensesMonth,2) }}</div></div></div>
  <div class="col-md-3"><div class="card kpi-card p-3 text-center"><div class="small text-muted">صافي التدفق</div><div class="h4 mb-0">{{ number_format($netFlowMonth,2) }}</div></div></div>
</div>
@php $maxVal = max(array_merge($cashSeries,$inKindSeries)); $maxVal = $maxVal > 0 ? $maxVal : 1; @endphp
<div class="row g-3 mb-3">
  <div class="col-md-8">
    <div class="card chart-wrap p-3">
      <div class="d-flex justify-content-between align-items-center mb-2"><h5 class="mb-0">توزيع التبرعات آخر 12 شهرًا</h5><span class="chip">نقدي مقابل عيني</span></div>
      <div class="bar-grid">
        @for($i=0;$i<count($months);$i++)
          @php $cm = $cashSeries[$i]; $km = $inKindSeries[$i]; $ch = max(round(($cm/$maxVal)*180), 4); $kh = max(round(($km/$maxVal)*180), 4); @endphp
          <div style="display:flex;gap:4px;align-items:flex-end">
            <div class="bar cash" style="height:{{ $ch }}px" title="{{ $months[$i] }}: {{ number_format($cm,2) }}"></div>
            <div class="bar kind" style="height:{{ $kh }}px" title="{{ $months[$i] }}: {{ number_format($km,2) }}"></div>
          </div>
        @endfor
      </div>
      <div class="bar-labels mt-2 small text-muted">
        @foreach($months as $m)<span>{{ $m }}</span>@endforeach
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card kpi-card p-3">
      <h5 class="mb-2">حالة المستفيدين</h5>
      <ul class="list-unstyled list-simple mb-0">
        @foreach($beneficiaryStatus as $s)
          <li><span>{{ $s['status'] }}</span><span class="chip">{{ $s['count'] }}</span></li>
        @endforeach
      </ul>
    </div>
  </div>
</div>

<div class="row g-3">
  <div class="col-md-8">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 class="mb-0">آخر سجلات النظام</h5>
        <a class="btn btn-sm btn-outline-secondary" href="{{ route('audits.index') }}">عرض الكل</a>
      </div>
      @if($isAdmin)
      <div class="table-responsive">
        <table class="table table-striped mb-0">
          <thead>
            <tr><th>#</th><th>التاريخ</th><th>المستخدم</th><th>الطريقة</th><th>المسار</th><th>الحالة</th><th>IP</th></tr>
          </thead>
          <tbody>
            @foreach($audits as $a)
            <tr>
              <td>{{ $a->id }}</td>
              <td>{{ optional($a->created_at)->format('Y-m-d H:i') }}</td>
              <td>{{ optional($audUserMap->get($a->user_id))->name ?? '—' }}</td>
              <td>{{ $a->method }}</td>
              <td class="small">/{{ $a->path }}</td>
              <td>{{ $a->status_code ?? '—' }}</td>
              <td><span class="badge bg-light text-dark">{{ $a->ip ?? '—' }}</span></td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      @else
        <div class="text-muted">لا تُعرض السجلات إلا للمسؤولين</div>
      @endif
    </div>
  </div>
  <div class="col-md-4">
    <div class="card p-3">
      <h5 class="mb-3">التنبيهات</h5>
      @forelse($notifications as $n)
        <div class="alert alert-{{ $n['type'] }} py-2 mb-2">{{ $n['text'] }}</div>
      @empty
        <div class="text-muted">لا توجد تنبيهات</div>
      @endforelse
    </div>
  </div>
</div>
<div class="row g-3 mt-3">
  <div class="col-md-6">
    <div class="card kpi-card p-3">
      <div class="d-flex justify-content-between align-items-center mb-2"><h5 class="mb-0">آخر التبرعات</h5><a class="btn btn-sm btn-outline-secondary" href="{{ route('donations.index') }}">عرض الكل</a></div>
      <ul class="list-unstyled list-simple mb-0">
        @foreach($latestDonations as $d)
          <li><span>{{ $d->donor?->name ?? '—' }} — {{ $d->type==='cash'?'نقدي':'عيني' }}</span><span class="chip">{{ ($d->type==='cash')?number_format($d->amount,2):number_format($d->estimated_value,2) }}</span></li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card kpi-card p-3">
      <div class="d-flex justify-content-between align-items-center mb-2"><h5 class="mb-0">آخر المهام</h5><a class="btn btn-sm btn-outline-secondary" href="{{ route('tasks.index') }}">عرض الكل</a></div>
      <ul class="list-unstyled list-simple mb-0">
        @foreach($latestTasks as $t)
          <li><span>{{ $t->title ?? ('مهمة #'.$t->id) }}</span><span class="chip">{{ $t->status ?? '—' }}</span></li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="col-md-3">
    <div class="card kpi-card p-3">
      <div class="d-flex justify-content-between align-items-center mb-2"><h5 class="mb-0">حضور اليوم</h5><a class="btn btn-sm btn-outline-secondary" href="{{ route('volunteer-attendance.index') }}">عرض الكل</a></div>
      <ul class="list-unstyled list-simple mb-0">
        @foreach($latestAttendance as $a)
          <li><span>{{ $a->user?->name ?? '—' }}</span><span class="chip">{{ $a->date?->format('Y-m-d') ?? '—' }}</span></li>
        @endforeach
      </ul>
    </div>
  </div>
</div>
<div class="row g-3 mt-3">
  <div class="col-md-6">
    <div class="card kpi-card p-3">
      <h5 class="mb-2">أفضل المتبرعين (هذا الشهر)</h5>
      <ul class="list-unstyled list-simple mb-0">
        @foreach($topDonors as $td)
          <li><span>{{ $td['name'] }}</span><span class="chip">{{ number_format($td['total'],2) }}</span></li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="col-md-6">
    <div class="card kpi-card p-3">
      <h5 class="mb-2">توزيع هذا الشهر</h5>
      <div class="d-flex gap-2 align-items-center">
        <span class="chip">نقدي: {{ $cashMonthPct }}%</span>
        <span class="chip">عيني: {{ $inKindMonthPct }}%</span>
      </div>
    </div>
  </div>
</div>
@endsection
