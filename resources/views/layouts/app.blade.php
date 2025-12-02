<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>مؤسسة إنسان</title>
    <link rel="icon" href="{{ asset('logo.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary:#0d6efd; --primary-dark:#0b5ed7; --accent:#00c2a8; --bg:#f5f7fb; --text:#1b1f24; --nav-height:64px; }
        body { background:var(--bg); color:var(--text); }
        .navbar { background:linear-gradient(90deg, var(--primary), var(--accent)); position: sticky; top:0; z-index:1050; box-shadow:0 6px 18px rgba(0,0,0,.08); min-height: var(--nav-height); }
        .navbar .nav-link, .navbar .navbar-brand { color:#fff; }
        .navbar .nav-link:hover { color:#e6f8f5; }
        .navbar-brand { font-weight:700; letter-spacing:.5px; display:flex; align-items:center; gap:.5rem; }
        .navbar-brand img { height:32px; width:auto; object-fit:contain; }
        .card { border:none; box-shadow:0 8px 24px rgba(13,110,253,.08); border-radius:12px; }
        .sidebar-fixed { position: fixed; right: 0; top: var(--nav-height); width: 280px; height: calc(100vh - var(--nav-height)); overflow-y: auto; z-index: 1030; }
        .list-group-item { display:flex; align-items:center; gap:.5rem; padding:.75rem 1rem; border:0; }
        .list-group-item .bi { font-size:1.1rem; color:var(--primary); }
        .list-group-item:hover { background:#eef5ff; }
        .list-group-item.active { background:linear-gradient(90deg, var(--primary), var(--primary-dark)); color:#fff; }
        .list-group-item.active .bi { color:#fff; }
        .list-group-title { font-weight:700; color:#0b5ed7; background:#eef5ff; }
        .btn-primary { background:var(--primary); border-color:var(--primary); }
        .btn-primary:hover { background:var(--primary-dark); border-color:var(--primary-dark); }
        .table thead { background:#f0f6ff; }
        h1,h2,h3,h4,h5 { color:#111827; }
        .content-wrapper { margin-right: 300px; }
        .nav-actions .form-control { background: rgba(255,255,255,.15); color:#fff; }
        .nav-actions .form-control::placeholder { color:#e6f8f5; }
        .nav-actions .input-group-text { background: transparent; border:0; color:#e6f8f5; }
        .nav-actions .btn-outline-light { border-color: rgba(255,255,255,.5); color:#fff; }
        .nav-actions .btn-outline-light:hover { background: rgba(255,255,255,.2); }
        .list-group .sub-list { background:#f8fbff; }
        .list-group .sub-list .list-group-item { padding:.5rem 1.25rem; }
        @media (max-width: 991.98px){ .sidebar-fixed{ position:static; width:auto; height:auto; margin-bottom:1rem; } .content-wrapper{ margin-right:0; } }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark border-bottom">
  <div class="container">
    <a class="navbar-brand" href="/">
      @if(file_exists(public_path('logo.png')))
        <img src="{{ asset('logo.png') }}" alt="إنسان" loading="lazy" decoding="async" onerror="this.remove()">
      @endif
      <span>إنسان</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="nav">
      <div class="ms-auto d-flex align-items-center gap-3 nav-actions">
        @php $navUser = request()->user(); $navIsAdmin = $navUser && $navUser->roles()->where('key','admin')->exists(); @endphp
        <form action="{{ route('reports.index') }}" method="GET" class="d-none d-lg-block">
          <div class="input-group input-group-sm">
            <span class="input-group-text"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control form-control-sm" name="q" placeholder="ابحث...">
          </div>
        </form>
        <a href="{{ route('reports.index') }}" class="btn btn-outline-light btn-sm d-none d-lg-inline-flex"><i class="bi bi-graph-up"></i> التقارير</a>
        @if($navIsAdmin)
        <button class="btn btn-outline-light btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#notifOffcanvas" aria-controls="notifOffcanvas"><i class="bi bi-bell"></i></button>
        @endif
        @if(session()->has('user_id'))
        <div class="dropdown">
          <button class="btn btn-light btn-sm dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-person-circle"></i> حسابي</button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('users.show', session('user_id')) }}">الملف الشخصي</a></li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <form method="POST" action="{{ route('logout') }}">@csrf<button class="dropdown-item text-danger">خروج</button></form>
            </li>
          </ul>
        </div>
        @else
        <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">دخول</a>
        @endif
      </div>
    </div>
  </div>
</nav>
<div class="card sidebar-fixed">
  <div class="list-group list-group-flush">
          <a href="{{ route('dashboard.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('dashboard.*') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i><span>لوحة التحكم</span></a>
          <a href="{{ route('donors.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('donors.*') ? 'active' : '' }}"><i class="bi bi-people"></i><span>المتبرعون</span></a>
          <a href="{{ route('donations.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('donations.*') ? 'active' : '' }}"><i class="bi bi-gift"></i><span>التبرعات</span></a>
          <a href="{{ route('beneficiaries.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('beneficiaries.*') ? 'active' : '' }}"><i class="bi bi-person-heart"></i><span>المستفيدون</span></a>

          <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#delegatesCollapse" role="button" aria-expanded="{{ (request()->routeIs('delegates.*') || request()->routeIs('travel-routes.*')) ? 'true' : 'false' }}" aria-controls="delegatesCollapse">
            <span><i class="bi bi-signpost-2"></i> المناديب وخطوط السير</span>
            <i class="bi bi-caret-down"></i>
          </a>
          <div class="collapse {{ (request()->routeIs('delegates.*') || request()->routeIs('travel-routes.*')) ? 'show' : '' }} sub-list" id="delegatesCollapse">
            <a href="{{ route('delegates.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('delegates.*') ? 'active' : '' }}"><i class="bi bi-person-badge"></i><span>المندوبون</span></a>
            <a href="{{ route('travel-routes.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('travel-routes.*') ? 'active' : '' }}"><i class="bi bi-geo"></i><span>خطوط السير</span></a>
          </div>
          <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#hrCollapse" role="button" aria-expanded="{{ (request()->routeIs('volunteers.*') || request()->routeIs('volunteer-attendance.*') || request()->routeIs('tasks.*') || request()->routeIs('volunteer-hours.*') || request()->routeIs('payrolls.*') || request()->routeIs('roles.*') || request()->routeIs('hr.evaluations') || request()->routeIs('reports.*')) ? 'true' : 'false' }}" aria-controls="hrCollapse">
            <span><i class="bi bi-people"></i> الموارد البشرية HR</span>
            <i class="bi bi-caret-down"></i>
          </a>
          <div class="collapse {{ (request()->routeIs('volunteers.*') || request()->routeIs('volunteer-attendance.*') || request()->routeIs('tasks.*') || request()->routeIs('volunteer-hours.*') || request()->routeIs('payrolls.*') || request()->routeIs('roles.*') || request()->routeIs('hr.evaluations') || request()->routeIs('reports.*')) ? 'show' : '' }} sub-list" id="hrCollapse">
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#volunteersGroup" role="button" aria-expanded="{{ (request()->routeIs('volunteers.*') || request()->routeIs('volunteer-attendance.*') || request()->routeIs('tasks.*') || request()->routeIs('volunteer-hours.*') || request()->routeIs('hr.evaluations') || request()->routeIs('reports.*')) ? 'true' : 'false' }}" aria-controls="volunteersGroup">
              <span><i class="bi bi-person-lines-fill"></i> إدارة المتطوعين</span>
              <i class="bi bi-caret-down"></i>
            </a>
            <div class="collapse {{ (request()->routeIs('volunteers.*') || request()->routeIs('volunteer-attendance.*') || request()->routeIs('tasks.*') || request()->routeIs('volunteer-hours.*') || request()->routeIs('hr.evaluations') || request()->routeIs('reports.*')) ? 'show' : '' }} sub-list" id="volunteersGroup">
              <a href="{{ route('volunteers.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('volunteers.*') ? 'active' : '' }}"><i class="bi bi-person"></i><span>الملفّات</span></a>
              <a href="{{ route('tasks.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('tasks.*') ? 'active' : '' }}"><i class="bi bi-list-task"></i><span>مهام المتطوعين</span></a>
              <a href="{{ route('volunteer-hours.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('volunteer-hours.*') ? 'active' : '' }}"><i class="bi bi-clock-history"></i><span>ساعات المتطوعين</span></a>
              <a href="{{ route('hr.evaluations') }}" class="list-group-item list-group-item-action {{ request()->routeIs('hr.evaluations') ? 'active' : '' }}"><i class="bi bi-award"></i><span>التقييمات</span></a>
              <a href="{{ route('volunteers.reports') }}" class="list-group-item list-group-item-action {{ request()->routeIs('volunteers.reports') ? 'active' : '' }}"><i class="bi bi-person-lines-fill"></i><span>تقارير المتطوعين</span></a>
            </div>
            <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#employeesGroup" role="button" aria-expanded="{{ (request()->routeIs('users.*') || request()->routeIs('payrolls.*') || request()->routeIs('roles.*') || request()->routeIs('volunteer-attendance.*') || request()->routeIs('hr.evaluations') || request()->routeIs('reports.*')) ? 'true' : 'false' }}" aria-controls="employeesGroup">
              <span><i class="bi bi-briefcase"></i> إدارة الموظفين</span>
              <i class="bi bi-caret-down"></i>
            </a>
            <div class="collapse {{ (request()->routeIs('users.*') || request()->routeIs('payrolls.*') || request()->routeIs('roles.*') || request()->routeIs('volunteer-attendance.*') || request()->routeIs('hr.evaluations') || request()->routeIs('reports.*')) ? 'show' : '' }} sub-list" id="employeesGroup">
              <a href="{{ route('users.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('users.*') ? 'active' : '' }}"><i class="bi bi-people"></i><span>الموظفون</span></a>
              <a href="{{ route('volunteer-attendance.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('volunteer-attendance.*') ? 'active' : '' }}"><i class="bi bi-clipboard-check"></i><span>الحضور والانصراف</span></a>
              <a href="{{ route('payrolls.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('payrolls.*') ? 'active' : '' }}"><i class="bi bi-wallet2"></i><span>الرواتب</span></a>
              <a href="{{ route('roles.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('roles.*') ? 'active' : '' }}"><i class="bi bi-shield-lock"></i><span>الأدوار</span></a>
              <a href="{{ route('hr.evaluations') }}" class="list-group-item list-group-item-action {{ request()->routeIs('hr.evaluations') ? 'active' : '' }}"><i class="bi bi-award"></i><span>التقييمات</span></a>
              <a href="{{ route('reports.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('reports.*') ? 'active' : '' }}"><i class="bi bi-bar-chart"></i><span>تقارير الموظفين</span></a>
            </div>
          @php $u = request()->user(); $isAdmin = $u && $u->roles()->where('key','admin')->exists(); @endphp
          </div>

          <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#accCollapse" role="button" aria-expanded="{{ (request()->routeIs('expenses.*') || request()->routeIs('closures.*')) ? 'true' : 'false' }}" aria-controls="accCollapse">
            <span><i class="bi bi-calculator"></i> الحسابات</span>
            <i class="bi bi-caret-down"></i>
          </a>
          <div class="collapse {{ (request()->routeIs('expenses.*') || request()->routeIs('closures.*')) ? 'show' : '' }} sub-list" id="accCollapse">
            <a href="{{ route('expenses.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('expenses.*') ? 'active' : '' }}"><i class="bi bi-cash-coin"></i><span>المصروفات</span></a>
            <a href="{{ route('closures.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('closures.*') ? 'active' : '' }}"><i class="bi bi-lock"></i><span>الإغلاق المالي</span></a>
          </div>

          <a class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#invCollapse" role="button" aria-expanded="{{ (request()->routeIs('warehouses.*') || request()->routeIs('items.*') || request()->routeIs('inventory-transactions.*')) ? 'true' : 'false' }}" aria-controls="invCollapse">
            <span><i class="bi bi-building"></i> إدارة المخازن</span>
            <i class="bi bi-caret-down"></i>
          </a>
          <div class="collapse {{ (request()->routeIs('warehouses.*') || request()->routeIs('items.*') || request()->routeIs('inventory-transactions.*')) ? 'show' : '' }} sub-list" id="invCollapse">
            <a href="{{ route('warehouses.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('warehouses.*') ? 'active' : '' }}"><i class="bi bi-building"></i><span>المخازن</span></a>
            <a href="{{ route('items.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('items.*') ? 'active' : '' }}"><i class="bi bi-box"></i><span>الأصناف</span></a>
            <a href="{{ route('inventory-transactions.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('inventory-transactions.*') ? 'active' : '' }}"><i class="bi bi-arrow-left-right"></i><span>حركات المخزون</span></a>
          </div>
          @if($isAdmin)
          <a href="{{ route('audits.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('audits.*') ? 'active' : '' }}"><i class="bi bi-activity"></i><span>السجلات Logs</span></a>
          @endif
          <a href="{{ route('projects.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('projects.*') ? 'active' : '' }}"><i class="bi bi-kanban"></i><span>إدارة المشاريع</span></a>
          <a href="{{ route('campaigns.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('campaigns.*') ? 'active' : '' }}"><i class="bi bi-megaphone"></i><span>إدارة الحملات</span></a>
          <a href="{{ route('guest-houses.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('guest-houses.*') ? 'active' : '' }}"><i class="bi bi-house"></i><span>إدارة دار الضيافة</span></a>
          @php $u2 = request()->user(); $isAdmin2 = $u2 && $u2->roles()->where('key','admin')->exists(); @endphp
          @if($isAdmin2)
          <a href="{{ route('notifications.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('notifications.*') ? 'active' : '' }}"><i class="bi bi-bell"></i><span>الإشعارات</span></a>
          @endif
          <a href="{{ route('complaints.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('complaints.*') ? 'active' : '' }}"><i class="bi bi-chat-dots"></i><span>الشكاوى</span></a>
  </div>
</div>
<div class="container py-4 content-wrapper">
  @yield('content')
</div>
@if($navIsAdmin)
<div class="offcanvas offcanvas-end" tabindex="-1" id="notifOffcanvas" aria-labelledby="notifOffcanvasLabel">
  <div class="offcanvas-header">
    <h5 id="notifOffcanvasLabel" class="mb-0">الإشعارات</h5>
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div class="d-flex gap-2 mb-2">
      <select id="notifSideFilter" class="form-select form-select-sm" style="width:auto">
        <option value="">الكل</option>
        <option value="success">نجاح</option>
        <option value="info">معلومة</option>
        <option value="warning">تحذير</option>
        <option value="danger">هام</option>
        <option value="secondary">عام</option>
      </select>
      <a href="{{ route('notifications.index') }}" class="btn btn-light btn-sm">عرض الكل</a>
    </div>
    <div id="notifSideList" class="d-flex flex-column gap-2"></div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function(){
  var off = document.getElementById('notifOffcanvas');
  var list = document.getElementById('notifSideList');
  var filter = document.getElementById('notifSideFilter');
  var fKey = 'sidebar.notifications.filter';
  var render = function(items){
    list.innerHTML = '';
    if (!items || !items.length){ list.innerHTML = '<div class="alert alert-secondary">لا توجد إشعارات</div>'; return; }
    var val = filter.value;
    items.forEach(function(n){
      if (val && n.type !== val) return;
      var div = document.createElement('div');
      div.className = 'alert alert-'+n.type+' d-flex justify-content-between align-items-center';
      var span = document.createElement('div'); span.textContent = n.text; div.appendChild(span);
      var a = document.createElement('a'); a.href = n.link; a.className = 'btn btn-outline-dark btn-sm'; a.textContent = 'فتح'; div.appendChild(a);
      list.appendChild(div);
    });
  };
  var load = function(){
    fetch('{{ route('notifications.index') }}?format=json').then(function(r){return r.json()}).then(function(d){ render(d.items || []); }).catch(function(){ render([]); });
  };
  off.addEventListener('shown.bs.offcanvas', load);
  filter.addEventListener('change', function(){ localStorage.setItem(fKey, filter.value || ''); load(); });
  var saved = localStorage.getItem(fKey); if (saved !== null) filter.value = saved;
});
</script>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
