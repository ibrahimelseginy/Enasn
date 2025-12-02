@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">إضافة مستخدم</h5>
<form method="POST" action="{{ route('users.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">الاسم</label><input name="name" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">البريد</label><input name="email" type="email" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">كلمة المرور</label><input name="password" type="password" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">الهاتف</label><input name="phone" class="form-control"></div>
<div class="col-md-6"><label class="form-label">الأدوار</label><select name="roles[]" class="form-select" multiple>@foreach($roles as $r)<option value="{{ $r->id }}">{{ $r->name }}</option>@endforeach</select></div>
<div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="active" value="1" checked><label class="form-check-label">نشط</label></div></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('users.index') }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
