@extends('layouts.app')
@section('content')
<div class="card p-4">
  <div class="d-flex justify-content-between align-items-center">
    <h5 class="mb-0">{{ $beneficiary->full_name }}</h5>
    <a class="btn btn-secondary" href="{{ route('beneficiaries.edit',$beneficiary) }}">تعديل</a>
  </div>
  <div class="mt-3">
    <div>الحالة: {{ $beneficiary->status }}</div>
    <div>نوع المساعدة: {{ $beneficiary->assistance_type }}</div>
    <div>الهاتف: {{ $beneficiary->phone ?? '—' }}</div>
    <div>العنوان: {{ $beneficiary->address ?? '—' }}</div>
  </div>
  <hr>
  <h6>المرفقات</h6>
  <form method="POST" action="{{ route('attachments.store') }}" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
    @csrf
    <input type="hidden" name="entity_type" value="App\\Models\\Beneficiary">
    <input type="hidden" name="entity_id" value="{{ $beneficiary->id }}">
    <input type="file" name="file" class="form-control" required>
    <button class="btn btn-primary">رفع</button>
  </form>
  <div class="mt-3">
    @php($atts = \App\Models\Attachment::where('entity_type', 'App\\Models\\Beneficiary')->where('entity_id', $beneficiary->id)->get())
    <ul class="list-group">
      @foreach($atts as $a)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <a href="{{ asset('storage/'.$a->path) }}" target="_blank">{{ basename($a->path) }}</a>
          <form method="POST" action="{{ route('attachments.destroy',$a) }}">@csrf @method('DELETE')<button class="btn btn-outline-danger btn-sm">حذف</button></form>
        </li>
      @endforeach
    </ul>
  </div>
  <div class="mt-3">
    <a href="{{ route('beneficiaries.index') }}" class="btn btn-light">رجوع</a>
  </div>
</div>
@endsection
