@extends('layouts.app')
@section('content')
<div class="card p-4">
<div class="d-flex justify-content-between align-items-center"><h5 class="mb-0">تعديل متطوع</h5><a class="btn btn-light" href="{{ route('volunteers.show',$volunteer) }}">عرض</a></div>
<form method="POST" action="{{ route('volunteers.update',$volunteer) }}">@csrf @method('PUT')
<div class="row g-3">
<div class="col-md-6"><label class="form-label">الاسم</label><input type="text" name="name" class="form-control" value="{{ $volunteer->name }}"></div>
<div class="col-md-6"><label class="form-label">البريد الإلكتروني</label><input type="email" name="email" class="form-control" value="{{ $volunteer->email }}"></div>
<div class="col-md-6"><label class="form-label">كلمة المرور</label><input type="password" name="password" class="form-control"></div>
<div class="col-md-6"><label class="form-label">الهاتف</label><input type="text" name="phone" class="form-control" value="{{ $volunteer->phone }}"></div>
<div class="col-md-6"><div class="form-check mt-4"><input class="form-check-input" type="checkbox" name="active" value="1" id="active" @checked($volunteer->active)><label class="form-check-label" for="active">نشط</label></div></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('volunteers.index') }}" class="btn btn-light">رجوع</a></div>
</form>
</div>
@endsection

