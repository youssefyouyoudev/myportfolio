<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $filter = (string) $request->query('filter', 'all');

        $messages = ContactMessage::query()
            ->when($filter === 'unread', fn ($query) => $query->unread())
            ->when($filter === 'read', fn ($query) => $query->read())
            ->orderByRaw('case when read_at is null then 0 else 1 end')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'filter' => $filter,
            'stats' => [
                'total' => ContactMessage::count(),
                'unread' => ContactMessage::unread()->count(),
                'read' => ContactMessage::read()->count(),
            ],
        ]);
    }

    public function show(ContactMessage $message): View
    {
        $message->markAsRead();

        return view('admin.messages.show', [
            'message' => $message->fresh(),
        ]);
    }

    public function toggleRead(Request $request, ContactMessage $message): RedirectResponse
    {
        if ($message->read_at) {
            $message->markAsUnread();
            $status = 'Message marked as unread';
        } else {
            $message->markAsRead();
            $status = 'Message marked as read';
        }

        return back()->with('status', $status);
    }

    public function destroy(Request $request, ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index', [$request->route('locale')])
            ->with('status', 'Message deleted');
    }
}
