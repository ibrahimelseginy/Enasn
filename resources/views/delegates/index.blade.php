@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="mb-0">المندوبون</h4><a href="{{ route('delegates.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة مندوب</a></div>
<div class="table-responsive"><table class="table table-striped"><thead><tr><th>الاسم</th><th>الهاتف</th><th>البريد</th><th>خط السير</th><th></th></tr></thead><tbody>
@foreach($delegates as $d)
<tr><td>{{ $d->name }}</td><td>{{ $d->phone ?? '—' }}</td><td>{{ $d->email ?? '—' }}</td><td>{{ $d->route?->name ?? '—' }}</td><td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('delegates.show',$d) }}">عرض</a><a class="btn btn-outline-secondary btn-sm" href="{{ route('delegates.edit',$d) }}">تعديل</a><form class="d-inline" method="POST" action="{{ route('delegates.destroy',$d) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form></td></tr>
@endforeach
</tbody></table></div>
<div class="mt-3">{{ $delegates->links() }}</div>
@endsection
