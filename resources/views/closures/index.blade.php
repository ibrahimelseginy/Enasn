@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">الإغلاقات المالية</h4>
  <a href="{{ route('closures.create') }}" class="btn btn-primary">إغلاق يومي</a>
</div>
<table class="table table-striped"><thead><tr><th>التاريخ</th><th>الفرع</th><th>موافق</th><th></th></tr></thead><tbody>
@foreach($closures as $c)
<tr><td>{{ $c->date->format('Y-m-d') }}</td><td>{{ $c->branch ?? '—' }}</td><td>{{ $c->approved ? 'نعم' : 'لا' }}</td><td><form method="POST" action="{{ route('closures.approve',$c) }}">@csrf<button class="btn btn-outline-success btn-sm">موافقة</button></form></td></tr>
@endforeach
</tbody></table>
<div class="mt-3">{{ $closures->links() }}</div>
@endsection
