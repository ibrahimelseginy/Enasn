@extends('layouts.app')
@section('content')
<div class="card p-4"><div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">{{ $route->name }}</h5><a class="btn btn-secondary" href="{{ route('travel-routes.edit',$route) }}">تعديل</a></div>
<div class="mt-3"><div>الوصف: {{ $route->description ?? '—' }}</div></div>
<div class="mt-3"><a href="{{ route('travel-routes.index') }}" class="btn btn-light">رجوع</a></div>
</div>
@endsection
