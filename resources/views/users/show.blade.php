@extends('layouts.app')
@section('content')
<div class="card p-4"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">{{ $user->name }}</h5><a class="btn btn-secondary" href="{{ route('users.edit',$user) }}">تعديل</a></div>
<div class="mt-3"><div>البريد: {{ $user->email }}</div><div>الهاتف: {{ $user->phone ?? '—' }}</div><div>الأدوار: {{ implode(', ', $user->roles->pluck('name')->all()) }}</div><div>الحالة: {{ $user->active ? 'نشط' : 'غير نشط' }}</div></div>
<div class="mt-3"><a href="{{ route('users.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection
