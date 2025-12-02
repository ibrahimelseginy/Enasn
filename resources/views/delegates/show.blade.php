@extends('layouts.app')
@section('content')
<div class="card p-4"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">{{ $delegate->name }}</h5><a class="btn btn-secondary" href="{{ route('delegates.edit',$delegate) }}">تعديل</a></div>
<div class="mt-3"><div>الهاتف: {{ $delegate->phone ?? '—' }}</div><div>البريد: {{ $delegate->email ?? '—' }}</div><div>خط السير: {{ $delegate->route?->name ?? '—' }}</div></div>
<div class="mt-3"><a href="{{ route('delegates.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection
