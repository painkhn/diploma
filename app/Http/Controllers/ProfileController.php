<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\{ Project, User };
use App\Models\Friend;
use App\Models\ProjectInvitation;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    public function show($id) 
    {
        $invitations = ProjectInvitation::where('recipient_id', $id)
            ->where('status', 'pending')
            ->get();

        $friend_invitations = Friend::with('sender', 'receiver')->where('receiver_id', $id)->where('status', 'pending')->get();
        // dd($friend_invitations);
        
        $user = User::findOrFail($id);
        
        // Получаем проекты, где пользователь либо владелец, либо участник
        $projects = Project::with(['projectUser' => function($query) use ($id) {
                $query->where('user_id', $id);
            }])
            ->where(function($query) use ($user, $id) {
                $query->where('user_id', $user->id) // проекты, где пользователь владелец
                    ->orWhereHas('projectUser', function($q) use ($id) {
                        $q->where('user_id', $id); // или участник
                    });
            })
            ->get();
        
        return Inertia::render('Profile/Index', [
            'user' => $user,
            'projects' => $projects,
            'invitations' => $invitations,
            'friendInvitations' => $friend_invitations
        ]);
    }

    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar_change' => 'required|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);
        
        $user = Auth::user();
        $avatarPath = public_path($user->avatar);
    
        // Удаляем старую аватарку, если она существует
        if ($user->avatar && file_exists($avatarPath)) {
            unlink($avatarPath);
        }
    
        // Сохраняем новую аватарку
        $name = time() . "." . $request->file('avatar_change')->extension();
        $destination = 'avatars'; // Путь для хранения аватарок
        $path = $request->file('avatar_change')->storeAs($destination, $name, 'public');
    
        // Обновляем путь к аватарке в базе данных
        $user->where('id', $user->id)->update([
            'avatar' => $path
        ]);
    
        return redirect()->back()->with('success', 'Аватарка успешно изменена!');
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('Profile/Edit', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => session('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
