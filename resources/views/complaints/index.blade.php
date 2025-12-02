@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3"><h4 class="mb-0">الشكاوى</h4><a href="{{ route('complaints.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> إضافة شكوى</a></div>
<table class="table table-striped"><thead><tr><th>#</th><th>المصدر</th><th>العنوان</th><th>الحالة</th><th></th></tr></thead><tbody>@foreach($complaints as $c)<tr><td>{{ $c->id }}</td><td>{{ $c->source_type }} #{{ $c->source_id }}</td><td>{{ $c->subject }}</td><td>{{ $c->status }}</td><td class="text-end"><a class="btn btn-outline-primary btn-sm" href="{{ route('complaints.show',$c) }}">عرض</a><a class="btn btn-outline-secondary btn-sm" href="{{ route('complaints.edit',$c) }}">تعديل</a><form class="d-inline" method="POST" action="{{ route('complaints.destroy',$c) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form></td></tr>@endforeach</tbody></table>
<div class="mt-3">{{ $complaints->links() }}</div>
@endsection
