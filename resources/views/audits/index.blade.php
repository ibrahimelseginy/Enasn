@extends('layouts.app')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4 class="mb-0">سجلات النظام</h4>
  <div>
    <a class="btn btn-outline-secondary" href="{{ route('audits.index', array_merge(request()->query(), ['export' => 'csv'])) }}">تصدير CSV</a>
  </div>
  </div>

<form method="GET" class="card p-3 mb-3">
  <div class="row g-3">
    <div class="col-md-2">
      <label class="form-label">الأيام</label>
      <input type="number" name="days" class="form-control" value="{{ $days }}" min="1">
    </div>
    <div class="col-md-2">
      <label class="form-label">الطريقة</label>
      <select name="method" class="form-select">
        <option value="">الكل</option>
        @foreach(['POST','PUT','PATCH','DELETE'] as $m)
          <option value="{{ $m }}" @selected($method===$m)>{{ $m }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">المستخدم</label>
      <input type="number" name="user_id" class="form-control" value="{{ $uid }}">
    </div>
    <div class="col-md-3">
      <label class="form-label">بحث في المسار</label>
      <input type="text" name="q" class="form-control" value="{{ $q }}" placeholder="/api/items">
    </div>
    <div class="col-md-2 d-flex align-items-end">
      <button class="btn btn-primary w-100">تصفية</button>
    </div>
  </div>
</form>

<div class="row g-3 mb-3">
  <div class="col-md-3">
    <div class="card p-3 text-center">
      <div class="small text-muted">إجمالي السجلات</div>
      <div class="display-6">{{ $stats['total'] }}</div>
    </div>
  </div>
  @foreach(['POST','PUT','PATCH','DELETE'] as $m)
  <div class="col-md-2">
    <div class="card p-3 text-center">
      <div class="small text-muted">{{ $m }}</div>
      <div class="h4 mb-0">{{ $stats[$m] }}</div>
    </div>
  </div>
  @endforeach
  <div class="col-md-5">
    <div class="card p-3">
      <div class="small text-muted">أكثر المسارات تكرارًا</div>
      <ul class="mb-0">
        @foreach($topPaths as $tp)
          <li class="small">{{ $tp->path }} <span class="badge bg-light text-dark">{{ $tp->c }}</span></li>
        @endforeach
      </ul>
    </div>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>التاريخ</th>
        <th>المستخدم</th>
        <th>الطريقة</th>
        <th>المسار</th>
        <th>الحالة</th>
        <th>IP</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      @foreach($audits as $a)
      <tr>
        <td>{{ $a->id }}</td>
        <td>{{ optional($a->created_at)->format('Y-m-d H:i') }}</td>
        <td>{{ optional($usersMap->get($a->user_id))->name ?? '—' }}</td>
        <td>{{ $a->method }}</td>
        <td class="small">/{{ $a->path }}</td>
        <td>{{ $a->status_code ?? '—' }}</td>
        <td><span class="badge bg-light text-dark">{{ $a->ip ?? '—' }}</span></td>
        <td class="text-end">
          <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#payload{{ $a->id }}">الحمولة</button>
        </td>
      </tr>
      <tr class="collapse" id="payload{{ $a->id }}">
        <td colspan="8">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="card p-3">
                <div class="small text-muted">Payload</div>
                <pre class="mb-0 small">{{ json_encode($a->payload, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) }}</pre>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card p-3">
                <div class="small text-muted">cURL</div>
                @php
                  $curlUrl = url('/'.$a->path);
                  $curlMethod = $a->method;
                  $curlPayload = $a->payload ? json_encode($a->payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '';
                  $curlUa = $a->user_agent ?: 'Mozilla/5.0';
                  $curl = $curlPayload !== ''
                    ? "curl -X $curlMethod '$curlUrl' -H 'Content-Type: application/json' -H 'User-Agent: $curlUa' -d '$curlPayload'"
                    : "curl -X $curlMethod '$curlUrl' -H 'User-Agent: $curlUa'";
                @endphp
                <pre class="mb-0 small">{{ $curl }}</pre>
              </div>
            </div>
          </div>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<div class="mt-3">{{ $audits->links() }}</div>
@endsection

