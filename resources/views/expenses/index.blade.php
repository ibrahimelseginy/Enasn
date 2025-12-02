@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">المصروفات</h4>
  <a href="{{ route('expenses.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة مصروف</a>
</div>
<div class="table-responsive">
<table class="table table-striped"><thead><tr><th>#</th><th>النوع</th><th>المبلغ</th><th>المستفيد</th><th>المشروع</th><th>الحملة</th><th></th></tr></thead><tbody>
@foreach($expenses as $e)
<tr>
  <td>{{ $e->id }}</td><td>{{ $e->type }}</td><td>{{ $e->amount }} {{ $e->currency }}</td><td>{{ $e->beneficiary?->full_name ?? '—' }}</td><td>{{ $e->project?->name ?? '—' }}</td><td>{{ $e->campaign?->name ?? '—' }}</td>
  <td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('expenses.show',$e) }}">عرض</a><a class="btn btn-outline-secondary btn-sm" href="{{ route('expenses.edit',$e) }}">تعديل</a><form class="d-inline" method="POST" action="{{ route('expenses.destroy',$e) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form></td>
</tr>
@endforeach
</tbody></table>
</div>
<div class="mt-3">{{ $expenses->links() }}</div>
@endsection
