@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">إغلاق مالي يومي</h5>
  <form method="POST" action="{{ route('closures.store') }}">@csrf
    <div class="row g-3">
      <div class="col-md-6"><label class="form-label">التاريخ</label><input type="date" name="date" class="form-control" value="{{ now()->format('Y-m-d') }}" required></div>
      <div class="col-md-6"><label class="form-label">الفرع</label><input name="branch" class="form-control"></div>
    </div>
    <div class="mt-3"><button class="btn btn-primary">إغلاق</button><a href="{{ route('closures.index') }}" class="btn btn-light">رجوع</a></div>
  </form>
</div>
@endsection
