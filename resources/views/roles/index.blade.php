@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="mb-0">الأدوار</h4><a href="{{ route('roles.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة دور</a></div>
<table class="table table-striped"><thead><tr><th>الاسم</th><th>المعرف</th><th></th></tr></thead><tbody>@foreach($roles as $r)<tr><td>{{ $r->name }}</td><td>{{ $r->key }}</td><td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('roles.show',$r) }}">عرض</a><a class="btn btn-outline-secondary btn-sm" href="{{ route('roles.edit',$r) }}">تعديل</a><form class="d-inline" method="POST" action="{{ route('roles.destroy',$r) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form></td></tr>@endforeach</tbody></table>
<div class="mt-3">{{ $roles->links() }}</div>
@endsection
