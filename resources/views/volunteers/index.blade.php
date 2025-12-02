@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="mb-0">إدارة المتطوعين</h4><a href="{{ route('volunteers.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة</a></div>
<table class="table table-striped"><thead><tr><th>الاسم</th><th>البريد</th><th>الهاتف</th><th>نشط</th><th></th></tr></thead><tbody>@foreach($volunteers as $v)<tr><td>{{ $v->name }}</td><td>{{ $v->email }}</td><td>{{ $v->phone ?? '—' }}</td><td>{{ $v->active ? 'نعم' : 'لا' }}</td><td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('volunteers.show',$v) }}">عرض</a><a class="btn btn-outline-secondary btn-sm" href="{{ route('volunteers.edit',$v) }}">تعديل</a><form class="d-inline" method="POST" action="{{ route('volunteers.destroy',$v) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form></td></tr>@endforeach</tbody></table>
<div class="mt-3">{{ $volunteers->links() }}</div>
@endsection

