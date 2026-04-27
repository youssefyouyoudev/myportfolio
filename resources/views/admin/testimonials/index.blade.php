@extends('layouts.admin')

@section('title', 'Testimonials')
@section('admin_title', 'Testimonials')
@section('admin_copy', 'Curate proof, publish the strongest client quotes, and control which testimonials deserve featured visibility.')

@section('content')
    <div class="admin-toolbar">
        <div>
            <span class="eyebrow">Trust module</span>
            <h2 class="section-title">Testimonials</h2>
            <p class="section-copy">Keep social proof organized so the best quotes are ready when you want to surface them publicly.</p>
        </div>
        <div class="admin-toolbar-actions">
            <a class="btn btn-primary btn-compact" href="{{ route('admin.testimonials.create', app()->getLocale()) }}">New testimonial</a>
        </div>
    </div>

    <div class="surface admin-list-shell">
        <div class="admin-list-meta">
            <div>
                <span class="eyebrow">Proof library</span>
                <h3 class="admin-list-title">{{ $testimonials->total() }} testimonials</h3>
            </div>
            <p>Keep your strongest social proof easy to scan, edit, and publish when it is ready.</p>
        </div>

        @if($testimonials->count())
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Person</th>
                            <th>Status</th>
                            <th>Featured</th>
                            <th>Company</th>
                            <th>Position</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($testimonials as $testimonial)
                            <tr>
                                <td>
                                    <div class="admin-table-primary">
                                        <strong>{{ $testimonial->display_name }}</strong>
                                        <div class="admin-field-help">{{ \Illuminate\Support\Str::limit($testimonial->quote, 80) }}</div>
                                    </div>
                                </td>
                                <td><span @class(['admin-badge', 'is-muted' => $testimonial->status !== 'published'])>{{ ucfirst($testimonial->status) }}</span></td>
                                <td>{{ $testimonial->display_featured ? 'Yes' : 'No' }}</td>
                                <td class="text-[var(--muted)]">{{ $testimonial->display_company ?: 'Independent' }}</td>
                                <td class="text-[var(--muted)]">{{ $testimonial->position ?: 'Not set' }}</td>
                                <td class="text-right">
                                    <div class="admin-actions-inline">
                                        <a class="btn btn-secondary btn-compact" href="{{ route('admin.testimonials.edit', [app()->getLocale(), $testimonial]) }}">Edit</a>
                                        <form method="post" action="{{ route('admin.testimonials.destroy', [app()->getLocale(), $testimonial]) }}" onsubmit="return confirm('Delete this testimonial?');">
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
            <div class="admin-empty">No testimonials yet. Add proof assets here so they are ready for future public placement.</div>
        @endif
    </div>

    <div class="mt-4 text-sm text-[var(--muted)]">{{ $testimonials->links() }}</div>
@endsection
