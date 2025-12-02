@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="mb-0">الحضور والانصراف</h4><a href="{{ route('volunteer-attendance.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة</a></div>
<table class="table table-striped"><thead><tr><th>المتطوع</th><th>التاريخ</th><th>دخول</th><th>خروج</th><th>ملاحظات</th><th></th></tr></thead><tbody>@foreach($records as $r)<tr><td>{{ $r->user?->name }}</td><td>{{ $r->date->format('Y-m-d') }}</td><td>{{ $r->check_in_at ?? '—' }}</td><td>{{ $r->check_out_at ?? '—' }}</td><td>{{ $r->notes ?? '—' }}</td><td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('volunteer-attendance.show',$r) }}">عرض</a><a class="btn btn-outline-secondary btn-sm" href="{{ route('volunteer-attendance.edit',$r) }}">تعديل</a><form class="d-inline" method="POST" action="{{ route('volunteer-attendance.destroy',$r) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form></td></tr>@endforeach</tbody></table>
<div class="mt-3">{{ $records->links() }}</div>
@endsection

