@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-center justify-between gap-3">
    <h1 class="text-2xl font-semibold text-[var(--text-strong)]">Services</h1>
    <a class="btn-primary text-sm" href="{{ route('admin.services.create', app()->getLocale()) }}">New service</a>
</div>
<div class="surface overflow-hidden">
    <table class="admin-table text-sm">
        <thead>
            <tr>
                <th class="text-left">Title</th>
                <th class="text-left">Status</th>
                <th class="text-left">Price</th>
                <th class="text-left">Position</th>
                <th class="text-left"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
                <tr>
                    <td>{{ $service->title }}</td>
                    <td>{{ $service->status }}</td>
                    <td>{{ $service->price_from }}</td>
                    <td>{{ $service->position }}</td>
                    <td class="space-x-3 text-right">
                        <a class="font-semibold text-[var(--accent-2)] hover:opacity-80" href="{{ route('admin.services.edit', [app()->getLocale(), $service]) }}">Edit</a>
                        <form method="post" action="{{ route('admin.services.destroy', [app()->getLocale(), $service]) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger text-sm" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="mt-4 text-sm text-[var(--muted)]">{{ $services->links() }}</div>
@endsection
