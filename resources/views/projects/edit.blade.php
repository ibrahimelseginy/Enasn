@extends('layouts.app')
@section('content')
<div class="card p-4">
  <h5 class="mb-3">تعديل مشروع</h5>
  <form method="POST" action="{{ route('projects.update',$project) }}">
    @csrf @method('PUT')
    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">الاسم</label>
        <input name="name" class="form-control" value="{{ $project->name }}">
      </div>
      <div class="col-md-6">
        <label class="form-label">الحالة</label>
        <select name="status" class="form-select">
          <option value="active" @selected($project->status==='active')>نشط</option>
          <option value="archived" @selected($project->status==='archived')>مؤرشف</option>
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">ثابت</label>
        <select name="fixed" class="form-select">
          <option value="1" @selected($project->fixed)>نعم</option>
          <option value="0" @selected(!$project->fixed)>لا</option>
        </select>
      </div>
      <div class="col-12">
        <label class="form-label">وصف</label>
        <textarea name="description" class="form-control" rows="3">{{ $project->description }}</textarea>
      </div>
    </div>
    <div class="mt-3">
      <button class="btn btn-primary">حفظ</button>
      <a href="{{ route('projects.show',$project) }}" class="btn btn-light">رجوع</a>
    </div>
  </form>
</div>
@endsection

