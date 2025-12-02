@extends('layouts.app')
@section('content')
<div class="card p-4"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">{{ $role->name }}</h5><a class="btn btn-secondary" href="{{ route('roles.edit',$role) }}">تعديل</a></div>
<div class="mt-3"><div>المعرف: {{ $role->key }}</div></div>
<div class="mt-3"><a href="{{ route('roles.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection
