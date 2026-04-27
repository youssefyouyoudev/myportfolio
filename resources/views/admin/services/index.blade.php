@extends('layouts.admin')

@section('title', 'Services')
@section('admin_title', 'Services')
@section('admin_copy', 'Manage service positioning, publishing status, featured placement, media, and offer details for the public site.')

@section('content')
    <div class="admin-toolbar">
        <div>
            <span class="eyebrow">Offer management</span>
            <h2 class="section-title">Services</h2>
            <p class="section-copy">Keep your public offer pages aligned with what you actually want to sell right now.</p>
        </div>
        <div class="admin-toolbar-actions">
            <a class="btn btn-primary btn-compact" href="{{ route('admin.services.create', app()->getLocale()) }}">New service</a>
        </div>
    </div>

    <div class="surface admin-list-shell">
        <div class="admin-list-meta">
            <div>
                <span class="eyebrow">Offer stack</span>
                <h3 class="admin-list-title">{{ $services->total() }} services</h3>
            </div>
            <p>Keep the services library focused, current, and easy to update as your positioning evolves.</p>
        </div>

        @if($services->count())
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Price</th>
                            <th>Position</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($services as $service)
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        <strong>{{ $service->title }}</strong>
                                        <div class="admin-field-help">{{ $service->slug }}</div>
                                    </div>
                                </td>
                                <td><span @class(['admin-badge', 'is-muted' => $service->status !== 'published'])>{{ ucfirst($service->status) }}</span></td>
                                <td>{{ $service->featured ? 'Yes' : 'No' }}</td>
                                <td class="text-[var(--muted)]">{{ $service->price_from ? number_format((float) $service->price_from, 2).' MAD' : 'Custom' }}</td>
                                <td class="text-[var(--muted)]">{{ $service->position ?: 'Not set' }}</td>
                                <td class="text-right">
                                    <div class="admin-actions-inline">
                                        <a class="btn btn-secondary btn-compact" href="{{ route('admin.services.edit', [app()->getLocale(), $service]) }}">Edit</a>
                                        <form method="post" action="{{ route('admin.services.destroy', [app()->getLocale(), $service]) }}" onsubmit="return confirm('Delete this service?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="admin-empty">No services yet. Create your first offer to power the public services pages dynamically.</div>
        @endif
    </div>

    <div class="mt-4 text-sm text-[var(--muted)]">{{ $services->links() }}</div>
@endsection
