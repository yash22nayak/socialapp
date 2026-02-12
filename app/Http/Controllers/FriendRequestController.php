<?php

namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = FriendRequest::with('sender', 'receiver')
            ->where(function ($query) {
                $query->where('receiver_id', Auth::id())
                    ->orWhere('sender_id', Auth::id());
            })
            ->where('status', 'sent')
            ->get();

        return view('friend-requests.index', compact('requests'));
    }

    public function sent(User $user)
    {
        FriendRequest::create([
            'receiver_id' => $user->id,
        ]);

        return to_route('home')->with('success', 'Request sent successfully!');
    }

    public function accept(FriendRequest $friendRequest)
    {
        $friendRequest->update([
            'status' => FriendRequest::ACCEPT,
        ]);

        return to_route('home')->with('success', 'Request accepted successfully!');
    }

    public function reject(FriendRequest $friendRequest)
    {
        $friendRequest->update([
            'status' => FriendRequest::REJECT,
        ]);

        return to_route('home')->with('success', 'Request rejected successfully!');
    }

    public function unfriend(User $user)
    {
        FriendRequest::where('status', 'accept')
            ->where(function ($query) use ($user) {
                $query->where('sender_id', $user->id)
                    ->orWhere('receiver_id', $user->id);
            })
            ->orWhere(function ($query) {
                $query->where('sender_id', Auth::id())
                    ->orWhere('receiver_id', Auth::id());
            })
            ->limit(1)
            ->delete();

        return to_route('home')->with('success', 'Unfriended successfully!');
    }

    public function searchUsers(Request $request)
    {
        $searchText = $request->input('search');
        $users = [];

        if ($searchText) {
            $users = User::where('name', 'LIKE', "%{$searchText}%")
                ->whereNot('id', Auth::id())
                ->get();
        }

        return view('friend-requests.search-users', compact('users'));
    }
}
