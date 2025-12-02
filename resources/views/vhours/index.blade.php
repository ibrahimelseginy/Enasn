@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="mb-0">ساعات المتطوعين</h4><a href="{{ route('volunteer-hours.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة</a></div>
<table class="table table-striped"><thead><tr><th>المتطوع</th><th>التاريخ</th><th>ساعات</th><th>المهمة</th><th></th></tr></thead><tbody>@foreach($hours as $h)<tr><td>{{ $h->user?->name }}</td><td>{{ $h->date->format('Y-m-d') }}</td><td>{{ $h->hours }}</td><td>{{ $h->task ?? '—' }}</td><td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('volunteer-hours.show',$h) }}">عرض</a><a class="btn btn-outline-secondary btn-sm" href="{{ route('volunteer-hours.edit',$h) }}">تعديل</a><form class="d-inline" method="POST" action="{{ route('volunteer-hours.destroy',$h) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form></td></tr>@endforeach</tbody></table>
<div class="mt-3">{{ $hours->links() }}</div>
@endsection
