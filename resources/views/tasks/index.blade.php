@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="mb-0">مهام المتطوعين</h4><a href="{{ route('tasks.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة</a></div>
<table class="table table-striped"><thead><tr><th>العنوان</th><th>المكلّف</th><th>المكلِّف</th><th>تاريخ الاستحقاق</th><th>الحالة</th><th></th></tr></thead><tbody>@foreach($tasks as $t)<tr><td>{{ $t->title }}</td><td>{{ $t->assignee?->name ?? '—' }}</td><td>{{ $t->assigner?->name ?? '—' }}</td><td>{{ $t->due_date?->format('Y-m-d') ?? '—' }}</td><td>{{ $t->status }}</td><td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('tasks.show',$t) }}">عرض</a><a class="btn btn-outline-secondary btn-sm" href="{{ route('tasks.edit',$t) }}">تعديل</a><form class="d-inline" method="POST" action="{{ route('tasks.destroy',$t) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form></td></tr>@endforeach</tbody></table>
<div class="mt-3">{{ $tasks->links() }}</div>
@endsection

