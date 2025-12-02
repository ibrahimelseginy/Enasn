@extends('layouts.app')
@section('content')
@if(!empty($q))
<div class="mb-3"><h4 class="mb-0">نتائج البحث عن: {{ $q }}</h4></div>
<div class="row g-4">
<div class="col-md-6"><div class="card p-3"><h6>المتبرعون</h6><ul class="list-group list-group-flush">@forelse($donors as $d)<li class="list-group-item"><a href="{{ route('donors.show',$d) }}">{{ $d->name }} - {{ $d->phone ?? $d->email ?? '' }}</a></li>@empty<li class="list-group-item">لا نتائج</li>@endforelse</ul></div></div>
<div class="col-md-6"><div class="card p-3"><h6>المستفيدون</h6><ul class="list-group list-group-flush">@forelse($beneficiaries as $b)<li class="list-group-item"><a href="{{ route('beneficiaries.show',$b) }}">{{ $b->full_name }} - {{ $b->phone ?? $b->national_id ?? '' }}</a></li>@empty<li class="list-group-item">لا نتائج</li>@endforelse</ul></div></div>
<div class="col-md-6"><div class="card p-3"><h6>المستخدمون</h6><ul class="list-group list-group-flush">@forelse($users as $u)<li class="list-group-item"><a href="{{ route('users.show',$u) }}">{{ $u->name }} - {{ $u->email }}</a></li>@empty<li class="list-group-item">لا نتائج</li>@endforelse</ul></div></div>
<div class="col-md-6"><div class="card p-3"><h6>العهد والأصناف</h6><ul class="list-group list-group-flush">@forelse($items as $i)<li class="list-group-item"><a href="{{ route('items.show',$i) }}">{{ $i->name }} - {{ $i->sku ?? '' }}</a></li>@empty<li class="list-group-item">لا نتائج</li>@endforelse</ul></div></div>
<div class="col-md-6"><div class="card p-3"><h6>المخازن</h6><ul class="list-group list-group-flush">@forelse($warehouses as $w)<li class="list-group-item"><a href="{{ route('warehouses.show',$w) }}">{{ $w->name }} - {{ $w->location ?? '' }}</a></li>@empty<li class="list-group-item">لا نتائج</li>@endforelse</ul></div></div>
<div class="col-md-6"><div class="card p-3"><h6>المندوبون</h6><ul class="list-group list-group-flush">@forelse($delegates as $dg)<li class="list-group-item"><a href="{{ route('delegates.show',$dg) }}">{{ $dg->name }} - {{ $dg->phone ?? $dg->email ?? '' }}</a></li>@empty<li class="list-group-item">لا نتائج</li>@endforelse</ul></div></div>
<div class="col-md-6"><div class="card p-3"><h6>خطوط السير</h6><ul class="list-group list-group-flush">@forelse($routes as $rt)<li class="list-group-item"><a href="{{ route('travel-routes.show',$rt) }}">{{ $rt->name }}</a></li>@empty<li class="list-group-item">لا نتائج</li>@endforelse</ul></div></div>
<div class="col-md-6"><div class="card p-3"><h6>مهام المتطوعين</h6><ul class="list-group list-group-flush">@forelse($tasks as $t)<li class="list-group-item"><a href="{{ route('tasks.show',$t) }}">{{ $t->title }}</a></li>@empty<li class="list-group-item">لا نتائج</li>@endforelse</ul></div></div>
<div class="col-md-6"><div class="card p-3"><h6>ساعات المتطوعين</h6><ul class="list-group list-group-flush">@forelse($vhours as $vh)<li class="list-group-item"><a href="{{ route('volunteer-hours.show',$vh) }}">{{ $vh->date->format('Y-m-d') }} - {{ $vh->hours }}h - {{ $vh->task }}</a></li>@empty<li class="list-group-item">لا نتائج</li>@endforelse</ul></div></div>
<div class="col-md-6"><div class="card p-3"><h6>الحضور والانصراف</h6><ul class="list-group list-group-flush">@forelse($attendance as $a)<li class="list-group-item"><a href="{{ route('volunteer-attendance.show',$a) }}">{{ $a->date->format('Y-m-d') }} - {{ $a->notes ?? '—' }}</a></li>@empty<li class="list-group-item">لا نتائج</li>@endforelse</ul></div></div>
</div>
@else
<div class="row g-4">
<div class="col-md-6"><div class="card p-4"><h5>المتبرعون</h5><div>الإجمالي: {{ $donorsCount }}</div><div>متكررون: {{ $donorsRecurring }}</div></div></div>
<div class="col-md-6"><div class="card p-4"><h5>التبرعات</h5><div>نقدي: {{ number_format($cash,2) }}</div><div>عينيات: {{ number_format($inKind,2) }}</div></div></div>
<div class="col-md-6"><div class="card p-4"><h5>المخزون</h5><div>صافي الكميات: {{ $inventoryNet }}</div></div></div>
<div class="col-md-6"><div class="card p-4"><h5>المستفيدون</h5><ul class="list-group list-group-flush">@foreach($beneficiariesByStatus as $s)<li class="list-group-item">{{ $s->status }}: {{ $s->count }}</li>@endforeach</ul></div></div>
<div class="col-md-6"><div class="card p-4"><h5>مالية</h5><div>مدين: {{ number_format($finance->debit,2) }}</div><div>دائن: {{ number_format($finance->credit,2) }}</div></div></div>
</div>
@endif
@endsection

