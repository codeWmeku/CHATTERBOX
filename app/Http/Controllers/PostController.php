<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(20);
        return view('dashboard', compact('posts'));
    }

    public function profile($username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $posts = $user->posts()->latest()->paginate(20);
        return view('profile', compact('user','posts'));
    }

    public function like(Post $post)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Unauthenticated'], 401);
        }

        // toggle like
        $exists = $post->likes()->where('user_id', $user->id)->exists();
        if ($exists) {
            $post->likes()->where('user_id', $user->id)->delete();
            $post->decrement('likes_count');
            return response()->json(['liked' => false, 'likes_count' => $post->likes_count]);
        }

        $post->likes()->create(['user_id' => $user->id]);
        $post->increment('likes_count');
        return response()->json(['liked' => true, 'likes_count' => $post->likes_count]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string|max:280',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = ['body' => $request->body, 'user_id' => Auth::id()];

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::random(16) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('images/posts');
            if (!file_exists($dest)) mkdir($dest, 0755, true);
            $file->move($dest, $filename);
            $data['image'] = 'images/posts/' . $filename;
        }

        $post = Post::create($data + ['likes_count' => 0]);

        return redirect()->route('dashboard');
    }
}
