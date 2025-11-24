@extends('app')

@section('title', $user->name . ' - Profile')

@section('content')
<div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold">CHATTERBOX</a>
                </div>
                <div class="flex items-center">
                    @auth
                        <form action="{{ route('logout') }}" method="POST">@csrf<button class="px-3 py-1 bg-black text-white rounded">Logout</button></form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center gap-4">
                <img src="{{ $user->avatar ? asset($user->avatar) : asset('images/Vector.png') }}" class="w-20 h-20 rounded-full object-cover" alt="{{ $user->name }}">
                <div>
                    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
                    <p class="text-gray-500">@{{ $user->username }}</p>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                @if($posts->count())
                    @foreach($posts as $post)
                        <article class="p-4 border rounded">
                            <div class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
                            <p class="mt-2">{{ $post->body }}</p>
                        </article>
                    @endforeach
                    <div class="mt-4">{{ $posts->links() }}</div>
                @else
                    <p class="text-gray-500">No posts yet.</p>
                @endif
            </div>
        </div>
    </main>
</div>
@endsection
