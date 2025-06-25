<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the messages.
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())
            ->withCount(['receivedMessages as unread_count' => function($query) {
                $query->whereNull('read_at')
                    ->where('recipient_id', Auth::id());
            }])
            ->with(['latestMessageWith' => function($query) {
                $query->where(function($q) {
                    $q->where('sender_id', Auth::id())
                      ->orWhere('recipient_id', Auth::id());
                });
            }])
            ->get();

        if (request()->wantsJson()) {
            return response()->json(['users' => $users]);
        }

        return view('messages.index', compact('users'));
    }

    /**
     * Show conversation with a specific user.
     */
    public function show(User $recipient)
    {
        $messages = Message::where(function($query) use ($recipient) {
            $query->where('sender_id', Auth::id())
                  ->where('recipient_id', $recipient->id)
                  ->where('deleted_by_sender', false);
        })->orWhere(function($query) use ($recipient) {
            $query->where('sender_id', $recipient->id)
                  ->where('recipient_id', Auth::id())
                  ->where('deleted_by_recipient', false);
        })
        ->with(['sender', 'recipient'])
        ->orderBy('created_at', 'asc')
        ->get();

        // Mark messages as read
        Message::where('sender_id', $recipient->id)
              ->where('recipient_id', Auth::id())
              ->whereNull('read_at')
              ->update(['read_at' => now()]);

        if (request()->wantsJson()) {
            return response()->json([
                'messages' => $messages,
                'recipient' => $recipient
            ]);
        }

        return view('messages.show', compact('messages', 'recipient'));
    }

    /**
     * Store a newly created message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'content' => 'required|string|max:1000',
        ]);

        $message = Message::create([
            'sender_id' => Auth::id(),
            'recipient_id' => $request->recipient_id,
            'content' => $request->content,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Message sent successfully',
                'data' => $message->load(['sender', 'recipient'])
            ]);
        }

        return redirect()->back()->with('success', 'Message sent successfully');
    }

    /**
     * Delete a message.
     */
    public function destroy(Message $message)
    {
        if ($message->sender_id === Auth::id()) {
            $message->update(['deleted_by_sender' => true]);
        } elseif ($message->recipient_id === Auth::id()) {
            $message->update(['deleted_by_recipient' => true]);
        }

        // If both sender and recipient have deleted the message, remove it from database
        if ($message->deleted_by_sender && $message->deleted_by_recipient) {
            $message->delete();
        }

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Message deleted successfully']);
        }

        return redirect()->back()->with('success', 'Message deleted successfully');
    }

    /**
     * Get unread messages count.
     */
    public function unreadCount()
    {
        $count = Message::where('recipient_id', Auth::id())
                       ->whereNull('read_at')
                       ->count();

        return response()->json(['unread_count' => $count]);
    }

    /**
     * Search users by name or email.
     */
    public function searchUsers(Request $request)
    {
        $query = $request->input('query');
        
        $users = User::where('id', '!=', Auth::id())
            ->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->withCount(['receivedMessages as unread_count' => function($q) {
                $q->whereNull('read_at')
                  ->where('recipient_id', Auth::id());
            }])
            ->with(['latestMessageWith' => function($q) {
                $q->where(function($subq) {
                    $subq->where('sender_id', Auth::id())
                         ->orWhere('recipient_id', Auth::id());
                });
            }])
            ->get();

        return response()->json(['users' => $users]);
    }

    /**
     * Get new messages since a given timestamp.
     */
    public function getNewMessages(Request $request)
    {
        $request->validate([
            'last_message_at' => 'required|date',
            'recipient_id' => 'required|exists:users,id'
        ]);

        $messages = Message::where(function($query) use ($request) {
            $query->where('sender_id', Auth::id())
                  ->where('recipient_id', $request->recipient_id)
                  ->where('deleted_by_sender', false);
        })->orWhere(function($query) use ($request) {
            $query->where('sender_id', $request->recipient_id)
                  ->where('recipient_id', Auth::id())
                  ->where('deleted_by_recipient', false);
        })
        ->where('created_at', '>', $request->last_message_at)
        ->with(['sender', 'recipient'])
        ->orderBy('created_at', 'asc')
        ->get();

        return response()->json(['messages' => $messages]);
    }
} 