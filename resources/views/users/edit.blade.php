@extends('layouts.app')
@section('content')
<div class="card p-4"><h5 class="mb-3">تعديل مستخدم</h5>
<form method="POST" action="{{ route('users.update',$user) }}">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label">الاسم</label><input name="name" class="form-control" value="{{ $user->name }}"></div>
<div class="col-md-6"><label class="form-label">البريد</label><input name="email" type="email" class="form-control" value="{{ $user->email }}"></div>
<div class="col-md-6"><label class="form-label">كلمة المرور (اختياري)</label><input name="password" type="password" class="form-control"></div>
<div class="col-md-6"><label class="form-label">الهاتف</label><input name="phone" class="form-control" value="{{ $user->phone }}"></div>
<div class="col-md-6"><label class="form-label">الأدوار</label><select name="roles[]" class="form-select" multiple>@foreach($roles as $r)<option value="{{ $r->id }}" @selected($user->roles->pluck('id')->contains($r->id))>{{ $r->name }}</option>@endforeach</select></div>
<div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="active" value="1" @checked($user->active)><label class="form-check-label">نشط</label></div></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('users.show',$user) }}" class="btn btn-light">رجوع</a></div>
</form></div>
@endsection
