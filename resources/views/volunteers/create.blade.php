@extends('layouts.app')
@section('content')
<div class="card p-4">
<h5 class="mb-3">إضافة متطوع</h5>
<form method="POST" action="{{ route('volunteers.store') }}">@csrf
<div class="row g-3">
<div class="col-md-6"><label class="form-label">الاسم</label><input type="text" name="name" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">البريد الإلكتروني</label><input type="email" name="email" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">كلمة المرور</label><input type="password" name="password" class="form-control" required></div>
<div class="col-md-6"><label class="form-label">الهاتف</label><input type="text" name="phone" class="form-control"></div>
<div class="col-md-6"><div class="form-check mt-4"><input class="form-check-input" type="checkbox" name="active" value="1" id="active" checked><label class="form-check-label" for="active">نشط</label></div></div>
</div>
<div class="mt-3"><button class="btn btn-primary">حفظ</button><a href="{{ route('volunteers.index') }}" class="btn btn-light">إلغاء</a></div>
</form>
</div>
@endsection

