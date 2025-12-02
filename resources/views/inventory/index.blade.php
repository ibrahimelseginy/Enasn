@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">حركات المخزون</h4>
  <a href="{{ route('inventory-transactions.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة حركة</a>
</div>
<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr><th>#</th><th>الصنف</th><th>المخزن</th><th>النوع</th><th>الكمية</th><th>المستفيد</th><th>المشروع</th><th>الحملة</th><th></th></tr>
    </thead>
    <tbody>
      @foreach($transactions as $t)
      <tr>
        <td>{{ $t->id }}</td>
        <td>{{ $t->item?->name }}</td>
        <td>{{ $t->warehouse?->name }}</td>
        <td>{{ $t->type }}</td>
        <td>{{ $t->quantity }}</td>
        <td>{{ $t->beneficiary?->full_name ?? '—' }}</td>
        <td>{{ $t->project?->name ?? '—' }}</td>
        <td>{{ $t->campaign?->name ?? '—' }}</td>
        <td class="text-end">
          <a class="btn btn-outline-primary btn-sm" href="{{ route('inventory-transactions.show',$t) }}">عرض</a>
          <a class="btn btn-outline-secondary btn-sm" href="{{ route('inventory-transactions.edit',$t) }}">تعديل</a>
          <form class="d-inline" method="POST" action="{{ route('inventory-transactions.destroy',$t) }}" onsubmit="return confirm('حذف الحركة؟');">
            @csrf @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">حذف</button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
<div class="mt-3">{{ $transactions->links() }}</div>
@endsection
