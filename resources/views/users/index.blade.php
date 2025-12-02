@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="mb-0">المستخدمون</h4><a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة مستخدم</a></div>
<div class="table-responsive"><table class="table table-striped"><thead><tr><th>الاسم</th><th>البريد</th><th>الأدوار</th><th>نشط</th><th></th></tr></thead><tbody>
@foreach($users as $u)
<tr><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ implode(', ', $u->roles->pluck('name')->all()) }}</td><td>{{ $u->active ? 'نعم' : 'لا' }}</td><td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('users.show',$u) }}">عرض</a><a class="btn btn-outline-secondary btn-sm" href="{{ route('users.edit',$u) }}">تعديل</a><form class="d-inline" method="POST" action="{{ route('users.destroy',$u) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form></td></tr>
@endforeach
</tbody></table></div>
<div class="mt-3">{{ $users->links() }}</div>
@endsection
