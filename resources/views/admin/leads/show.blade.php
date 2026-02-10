@extends('layouts.admin')

@section('content')
<h1 class="mb-4 text-2xl font-semibold text-[var(--text-strong)]">Lead</h1>
<div class="surface space-y-2 p-5 text-sm text-[var(--text)]">
    <div><span class="font-semibold">Name:</span> {{ $lead->name }}</div>
    <div><span class="font-semibold">Email:</span> {{ $lead->email }}</div>
    <div><span class="font-semibold">Company:</span> {{ $lead->company }}</div>
    <div><span class="font-semibold">Budget:</span> {{ $lead->budget }}</div>
    <div><span class="font-semibold">Locale:</span> {{ $lead->locale }}</div>
    <div><span class="font-semibold">Message:</span><br>{{ $lead->message }}</div>
</div>
<form method="post" action="{{ route('admin.leads.destroy', [app()->getLocale(), $lead]) }}" class="mt-4">
    @csrf
    @method('DELETE')
    <button class="btn-danger" type="submit">Delete</button>
</form>
@endsection
