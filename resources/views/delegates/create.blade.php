@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">إضافة مندوب</h5>
<form method="POST" action="{{ route('delegates.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">الاسم</label><input name="name" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">الهاتف</label><input name="phone" class="form-control"></div>
<div class="col-md-6"><label class="form-label">البريد</label><input name="email" class="form-control"></div>
<div class="col-md-6"><label class="form-label">خط السير</label><select name="route_id" class="form-select"><option value="">—</option>@foreach($routes as $r)<option value="{{ $r->id }}">{{ $r->name }}</option>@endforeach</select></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('delegates.index') }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
