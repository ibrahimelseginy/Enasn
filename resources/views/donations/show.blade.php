@extends('layouts.app')
@section('content')
<div class="card p-4">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="mb-0">تفاصيل التبرع</h5>
    <a class="btn btn-secondary" href="{{ route('donations.edit',$donation) }}">تعديل</a>
  </div>
  <div class="mt-3">
    <div>المتبرع: {{ $donation->donor?->name ?? '—' }}</div>
    <div>النوع: {{ $donation->type==='cash'?'نقدي':'عيني' }}</div>
    @if($donation->type==='cash')
      <div>طريقة الدفع: {{ $donation->cash_channel==='instapay'?'انستا باي':($donation->cash_channel==='vodafone_cash'?'فودافون كاش':'نقدي') }}</div>
      <div>رقم الإيصال: {{ $donation->receipt_number ?? '—' }}</div>
      <div>المبلغ: {{ number_format($donation->amount,2) }} {{ $donation->currency }}</div>
    @else
      <div>القيمة التقديرية: {{ number_format($donation->estimated_value,2) }} {{ $donation->currency }}</div>
      <div>المخزن: {{ $donation->warehouse?->name ?? '—' }}</div>
    @endif
    <div>المشروع: {{ $donation->project?->name ?? '—' }}</div>
    <div>الحملة: {{ $donation->campaign?->name ?? '—' }}</div>
    <div>تاريخ الاستلام: {{ optional($donation->received_at)->format('Y-m-d') ?? '—' }}</div>
    <div>ملاحظة: {{ $donation->allocation_note ?? '—' }}</div>
  </div>
  <div class="mt-3">
    <a href="{{ route('donations.index') }}" class="btn btn-light">رجوع</a>
  </div>
</div>
@endsection
