@extends('layouts.app')
@section('content')
<div class="card p-4">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="mb-0">تفاصيل المصروف</h5>
    <a class="btn btn-secondary" href="{{ route('expenses.edit',$expense) }}">تعديل</a>
  </div>
  <div class="mt-3">
    <div>النوع: {{ $expense->type }}</div>
    <div>المبلغ: {{ $expense->amount }} {{ $expense->currency }}</div>
    <div>المستفيد: {{ $expense->beneficiary?->full_name ?? '—' }}</div>
    <div>المشروع: {{ $expense->project?->name ?? '—' }}</div>
    <div>الحملة: {{ $expense->campaign?->name ?? '—' }}</div>
    <div>الوصف: {{ $expense->description ?? '—' }}</div>
  </div>
  <div class="mt-3"><a href="{{ route('expenses.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection
