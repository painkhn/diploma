<?php

namespace App\Http\Controllers;

use App\Models\Friend;
use App\Http\Requests\StoreFriendRequest;
use App\Http\Requests\UpdateFriendRequest;
use App\Models\ProjectInvitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class FriendController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $users = User::whereNot('id', $id)->get();
        $user = User::findOrFail($id);
        $invitations = ProjectInvitation::where('recipient_id', $id)
            ->where('status', 'pending')
            ->get();
        $friend_invitations = Friend::with('sender', 'receiver')->where('receiver_id', $id)->where('status', 'pending')->get();
        $friends = Friend::where('status', 'accepted')
            ->where(function($query) use ($id) {
                $query->where('receiver_id', $id)
                    ->orWhere('sender_id', $id);
                })
            ->with('sender', 'receiver')
            ->get();
        // dd($friends);

        return Inertia::render('Profile/Friends', [
            'users' => $users,
            'user' => $user,
            'invitations' => $invitations,
            'friends' => $friends,
            'friendInvitations' => $friend_invitations
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFriendRequest $request)
    {
        $friend = Friend::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'status' => 'pending'
        ]);
    }

    public function accept($id)
    {
        $invitation = Friend::findOrFail($id);
        // dd($invitation);
        $invitation->update([
            'status' => 'accepted'
        ]);
    }

    public function reject($id)
    {
        $invitation = Friend::findOrFail($id);
        // dd($invitation);
        $invitation->update([
            'status' => 'rejected'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Friend $friend)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Friend $friend)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFriendRequest $request, Friend $friend)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Friend $friend)
    {
        //
    }
}
