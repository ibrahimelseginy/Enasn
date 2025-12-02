@extends('layouts.app')
@section('content')
<div class="card p-4">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="mb-0">{{ $donor->name }}</h5>
    <a class="btn btn-secondary" href="{{ route('donors.edit',$donor) }}">تعديل</a>
  </div>
  <div class="mt-3">
    <div>النوع: {{ $donor->type==='individual' ? 'فرد' : 'منظمة' }}</div>
    <div>التصنيف: {{ $donor->classification==='recurring' ? 'متكرر' : 'مرة واحدة' }}</div>
    <div>الدورة: {{ $donor->recurring_cycle ?? '—' }}</div>
    <div>الهاتف: {{ $donor->phone ?? '—' }}</div>
    
    <div>العنوان: {{ $donor->address ?? '—' }}</div>
    <div>الحالة: {{ $donor->active ? 'نشط' : 'غير نشط' }}</div>
    <div>نوع الكفالة/الصدقة: {{ $donor->sponsorship_type==='monthly_sponsor' ? 'كافل شهري' : ($donor->sponsorship_type==='sadaqa_jariya' ? 'صدقات جارية' : '—') }}</div>
    <div>المشروع: {{ optional(\App\Models\Project::find($donor->sponsorship_project_id))->name ?? '—' }}</div>
    <div>الطفل المكفول: {{ optional(\App\Models\Beneficiary::find($donor->sponsored_beneficiary_id))->full_name ?? '—' }}</div>
    <div>المبلغ الشهري المستهدف: {{ $donor->sponsorship_monthly_amount ? number_format($donor->sponsorship_monthly_amount,2) : '—' }}</div>
    <div>المدفوع فعليًا هذا الشهر: {{ number_format($paidThisMonth,2) }}</div>
    <div>عدد التبرعات: {{ (int) ($stats->count ?? 0) }}</div>
    <div>إجمالي التبرعات: {{ number_format((float) ($stats->total ?? 0),2) }}</div>
  </div>
  <div class="mt-3">
    <a href="{{ route('donors.index') }}" class="btn btn-light">رجوع</a>
    <a href="{{ route('donations.create', ['donor_id' => $donor->id]) }}" class="btn btn-success">تبرع جديد</a>
  </div>
</div>
<div class="card p-4 mt-3">
  <div class="d-flex justify-content-between align-items-center">
    <h6 class="mb-0">سجل التبرعات</h6>
    <span class="text-muted small">إجمالي: {{ count($history) }}</span>
  </div>
  <div class="mt-2">
    <table class="table">
      <thead>
        <tr>
          <th>التاريخ</th>
          <th>النوع</th>
          <th>القيمة/المبلغ</th>
          <th>القناة/الإيصال</th>
          <th>المشروع</th>
          <th>الحملة</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach($history as $d)
          <tr>
            <td>{{ optional($d->received_at)->format('Y-m-d') ?? '—' }}</td>
            <td>{{ $d->type==='cash'?'نقدي':'عيني' }}</td>
            <td>
              @if($d->type==='cash')
                {{ number_format($d->amount,2) }} {{ $d->currency }}
              @else
                {{ number_format($d->estimated_value,2) }} {{ $d->currency }}
              @endif
            </td>
            <td>
              @if($d->type==='cash')
                {{ $d->cash_channel==='instapay'?'انستا باي':($d->cash_channel==='vodafone_cash'?'فودافون كاش':'نقدي') }} / {{ $d->receipt_number ?? '—' }}
              @else
                —
              @endif
            </td>
            <td>{{ $d->project?->name ?? '—' }}</td>
            <td>{{ $d->campaign?->name ?? '—' }}</td>
            <td class="text-end"><a href="{{ route('donations.show',$d) }}" class="btn btn-outline-primary btn-sm">عرض</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection
