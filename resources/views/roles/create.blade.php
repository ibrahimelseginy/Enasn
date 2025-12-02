@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">إضافة دور</h5>
<form method="POST" action="{{ route('roles.store') }}">@csrf
<div class="row g-3"><div class="col-md-6"><label class="form-label">الاسم</label><input name="name" class="form-control" required></div><div class="col-md-6"><label class="form-label">المعرف</label><input name="key" class="form-control" required></div></div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('roles.index') }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
