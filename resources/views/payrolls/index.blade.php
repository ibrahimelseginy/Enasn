@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="mb-0">الرواتب</h4><a href="{{ route('payrolls.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة</a></div>
<table class="table table-striped"><thead><tr><th>الموظف</th><th>الشهر</th><th>المبلغ</th><th>تاريخ الدفع</th><th></th></tr></thead><tbody>@foreach($payrolls as $p)<tr><td>{{ $p->user?->name }}</td><td>{{ $p->month }}</td><td>{{ $p->amount }} {{ $p->currency }}</td><td>{{ optional($p->paid_at)->format('Y-m-d') ?? '—' }}</td><td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('payrolls.show',$p) }}">عرض</a><a class="btn btn-outline-secondary btn-sm" href="{{ route('payrolls.edit',$p) }}">تعديل</a><form class="d-inline" method="POST" action="{{ route('payrolls.destroy',$p) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form></td></tr>@endforeach</tbody></table>
<div class="mt-3">{{ $payrolls->links() }}</div>
@endsection
