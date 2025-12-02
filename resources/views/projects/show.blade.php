@extends('layouts.app')
@section('content')
<div class="card p-4">
  <div class="d-flex align-items-center justify-content-between">
    <div class="d-flex align-items-center gap-3">
      <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center" style="width:64px;height:64px">
        <i class="bi bi-kanban" style="font-size:1.6rem"></i>
      </div>
      <div>
        <h5 class="mb-1">{{ $project->name }}</h5>
        <div class="d-flex align-items-center gap-2">
          <span class="badge {{ $project->status==='active' ? 'bg-success' : 'bg-secondary' }}">{{ $project->status==='active' ? 'نشط' : 'مؤرشف' }}</span>
          <span class="badge {{ $project->fixed ? 'bg-info' : 'bg-light text-dark' }}">{{ $project->fixed ? 'ثابت' : 'غير ثابت' }}</span>
        </div>
      </div>
    </div>
    <a class="btn btn-secondary" href="{{ route('projects.edit',$project) }}">تعديل</a>
  </div>
  <div class="mt-3 text-muted">{{ $project->description }}</div>
  <div class="row g-3 mt-3">
    <div class="col-md-6">
      <div class="card p-3 d-flex flex-row gap-3 align-items-center">
        <img src="{{ $project->manager_photo_url ?? 'https://via.placeholder.com/64x64?text=Mgr' }}" alt="manager" width="64" height="64" class="rounded">
        <div>
          <div class="small text-muted">مدير المشروع</div>
          <div class="fs-6 fw-bold">{{ $project->manager?->name ?? '—' }}</div>
          <form method="POST" action="{{ route('projects.setManager',$project) }}" class="mt-2 d-flex gap-2">
            @csrf
            <select name="manager_user_id" class="form-select">
              <option value="">—</option>
              @foreach($volunteers as $v)
                <option value="{{ $v->id }}" @selected($project->manager_user_id==$v->id)>{{ $v->name }}</option>
              @endforeach
            </select>
            <input name="manager_photo_url" class="form-control" placeholder="رابط صورة المدير" value="{{ $project->manager_photo_url }}">
            <button class="btn btn-primary">حفظ</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card p-3 d-flex flex-row gap-3 align-items-center">
        <img src="{{ $project->deputy_photo_url ?? 'https://via.placeholder.com/64x64?text=Dep' }}" alt="deputy" width="64" height="64" class="rounded">
        <div>
          <div class="small text-muted">نائب المدير</div>
          <div class="fs-6 fw-bold">{{ $project->deputy?->name ?? '—' }}</div>
          <form method="POST" action="{{ route('projects.setDeputy',$project) }}" class="mt-2 d-flex gap-2">
            @csrf
            <select name="deputy_user_id" class="form-select">
              <option value="">—</option>
              @foreach($volunteers as $v)
                <option value="{{ $v->id }}" @selected($project->deputy_user_id==$v->id)>{{ $v->name }}</option>
              @endforeach
            </select>
            <input name="deputy_photo_url" class="form-control" placeholder="رابط صورة النائب" value="{{ $project->deputy_photo_url }}">
            <button class="btn btn-primary">حفظ</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="row g-3 mt-3">
    <div class="col-md-3"><div class="card p-3 text-center"><div class="small text-muted">التبرعات</div><div class="h4 mb-0">{{ $donationsCount }}</div><i class="bi bi-gift text-primary"></i></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><div class="small text-muted">نقدية</div><div class="h4 mb-0">{{ number_format($cashSum,2) }}</div><i class="bi bi-cash-coin text-success"></i></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><div class="small text-muted">عينية (قيمة)</div><div class="h4 mb-0">{{ number_format($inKindSum,2) }}</div><i class="bi bi-box-seam text-info"></i></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><div class="small text-muted">المستفيدون</div><div class="h4 mb-0">{{ $beneficiariesCount }}</div><i class="bi bi-person-heart text-danger"></i></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><div class="small text-muted">المصروفات</div><div class="h4 mb-0">{{ $expensesCount }}</div><i class="bi bi-receipt text-secondary"></i></div></div>
    <div class="col-md-3"><div class="card p-3 text-center"><div class="small text-muted">إجمالي التبرعات</div><div class="h4 mb-0">{{ number_format($donationsTotal,2) }}</div><i class="bi bi-graph-up text-primary"></i></div></div>
  </div>
  <div class="mt-3">
    <div class="card p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div class="small text-muted">تفصيل التبرعات</div>
        <div class="small">نقدي {{ $cashPct }}% • عيني {{ 100 - $cashPct }}%</div>
      </div>
      <div class="progress mt-2" style="height:10px">
        <div class="progress-bar bg-success" style="width: {{ $cashPct }}%"></div>
        <div class="progress-bar bg-info" style="width: {{ 100 - $cashPct }}%"></div>
      </div>
    </div>
  </div>
  <div class="mt-4">
    <div class="card p-3 mb-3">
      <div class="d-flex justify-content-between align-items-center">
        <h6 class="mb-0">متطوعو المشروع</h6>
        <span class="badge bg-info">{{ count($projectVolunteers) }}</span>
      </div>
      <div class="row g-2 mt-2">
        @foreach($projectVolunteers as $pv)
        <div class="col-md-4">
          <div class="d-flex justify-content-between align-items-center border rounded p-2">
            <div class="d-flex align-items-center gap-2">
              <span class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center" style="width:32px;height:32px">{{ mb_substr($pv->name,0,1) }}</span>
              <span>{{ $pv->name }}</span>
            </div>
            <form method="POST" action="{{ route('projects.detachVolunteer', ['project'=>$project->id,'user'=>$pv->id]) }}">
              @csrf @method('DELETE')
              <button class="btn btn-outline-danger btn-sm">حذف</button>
            </form>
          </div>
        </div>
        @endforeach
      </div>
      <form method="POST" action="{{ route('projects.attachVolunteer', $project) }}" class="mt-3">
        @csrf
        <div class="row g-2 align-items-end">
          <div class="col-md-3">
            <label class="form-label">المتطوع</label>
            <select name="user_id" class="form-select">
              @foreach($volunteers as $v)
                @if(!$projectVolunteers->contains('id',$v->id))
                  <option value="{{ $v->id }}">{{ $v->name }}</option>
                @endif
              @endforeach
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">الدور في المشروع</label>
            <input type="text" name="role" class="form-control" placeholder="مثال: منسّق">
          </div>
          <div class="col-md-3">
            <label class="form-label">البداية</label>
            <input type="date" name="started_at" class="form-control">
          </div>
          <div class="col-md-3">
            <label class="form-label">الحملة</label>
            <select name="campaign_id" class="form-select">
              <option value="">—</option>
              @foreach($campaigns as $c)
                <option value="{{ $c->id }}">{{ $c->name }} ({{ $c->season_year }})</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-12">
            <button class="btn btn-primary">إضافة متطوع</button>
          </div>
        </div>
      </form>
    </div>
    <h6>أحدث التحركات</h6>
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card p-3">
          <div class="fw-bold mb-2">تبرعات</div>
          <ul class="mb-0">
            @foreach($latestDonations as $d)
            <li>#{{ $d->id }} • {{ $d->type==='cash' ? ('نقدي: ' . $d->amount) : ('عيني: ' . $d->estimated_value) }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <div class="fw-bold mb-2">مصروفات</div>
          <ul class="mb-0">
            @foreach($latestExpenses as $e)
            <li>#{{ $e->id }} • {{ $e->type }} • {{ $e->amount }}</li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <div class="fw-bold mb-2">مستفيدون</div>
          <ul class="mb-0">
            @foreach($latestBeneficiaries as $b)
            <li>#{{ $b->id }} • {{ $b->full_name }}</li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>
  </div>
  <div class="mt-3">
    <a href="{{ route('projects.index') }}" class="btn btn-light">رجوع</a>
  </div>
</div>
@endsection
