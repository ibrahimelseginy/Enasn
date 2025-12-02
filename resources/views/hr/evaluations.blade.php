@extends('layouts.app')
@section('content')
<div class="card p-4">
<h4 class="mb-3">التقييمات (HR)</h4>
<p>هذه الصفحة مخصّصة لتقييمات المتطوعين/الموظفين. يمكن إضافة نماذج تقييم ومعايير لاحقًا حسب احتياجك.</p>
<div class="mt-2"><a href="{{ route('tasks.index') }}" class="btn btn-primary btn-sm"><i class="bi bi-list-task"></i> إدارة المهام</a> <a href="{{ route('volunteer-attendance.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-clipboard-check"></i> الحضور والانصراف</a> <a href="{{ route('payrolls.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-wallet2"></i> الرواتب</a></div>
</div>
@endsection

