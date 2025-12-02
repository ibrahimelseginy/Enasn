@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">تعديل دور</h5>
<form method="POST" action="{{ route('roles.update',$role) }}">@csrf @method('PUT')
<div class="row g-3"><div class="col-md-6"><label class="form-label">الاسم</label><input name="name" class="form-control" value="{{ $role->name }}"></div><div class="col-md-6"><label class="form-label">المعرف</label><input name="key" class="form-control" value="{{ $role->key }}"></div></div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('roles.show',$role) }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
