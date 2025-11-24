@extends('app')

@section('title', 'Dashboard - ChatterBox')

@section('content')
<!-- FULL LAYOUT WITH ACCURATE SIDEBARS ADDED -->
<div class="min-h-screen bg-gray-100">
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-4">
                    <!--
                        PLACE YOUR LOGO HERE:
                        Replace the <img> below with your logo file.
                        The file path used in this example points to the uploaded asset on the container:
                        /mnt/data/A_vector_graphic_logo_features_a_stylized_bird_ins.png
                        You can replace that src with: resource_path('assets/images/Vector.svg') or asset('images/bird-logo.png') in production.
                        The example image is square (1:1). If your logo isn't square, adjust the CSS (width/height) to keep correct aspect ratio.
                    -->
                    <img src="{{ asset('images/Vector.png') }}" alt="ChatterBox Logo"
                         class="w-10 h-10 rounded-full object-contain" />

                    <h1 class="text-2xl font-bold">CHATTERBOX</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700">Welcome, {{ Auth::user()->name }}!</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-full hover:bg-gray-800 transition">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-2xl font-bold mb-4">Home</h2>
                <p class="text-gray-600 mb-6">You're successfully logged in to ChatterBox!</p>

                <!-- Composer -->
                <div class="mb-6 bg-gray-50 rounded-lg p-4">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="flex gap-3">
                            <img src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : asset('images/Vector.png') }}" class="w-12 h-12 rounded-full object-cover" alt="You">
                            <div class="flex-1">
                                <textarea name="body" required maxlength="280" placeholder="What's happening?" class="w-full p-3 rounded-md border resize-none" rows="3">{{ old('body') }}</textarea>
                                <div class="mt-2 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <label class="cursor-pointer text-sm text-gray-600 hover:text-gray-800">
                                            <input type="file" name="image" id="postImage" class="hidden" accept="image/*">
                                            <span class="px-3 py-1 rounded bg-white border">Attach image</span>
                                        </label>
                                        <span id="imageName" class="text-sm text-gray-500"></span>
                                    </div>
                                    <button type="submit" class="px-4 py-2 bg-black text-white rounded-full">Post</button>
                                </div>
                                <div id="imagePreview" class="mt-3 hidden">
                                    <img src="#" id="imagePreviewImg" class="w-full rounded-lg object-cover" style="max-height:360px;">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Feed container -->
                <div id="feed" class="divide-y divide-gray-200">
                    @if(isset($posts) && $posts->count())
                        @foreach($posts as $post)
                            <article class="py-6">
                                <div class="max-w-3xl mx-auto">
                                    <div class="flex items-center gap-3 mb-3">
                                        <a href="{{ route('profile', $post->user->username) }}">
                                            <img src="{{ $post->user->avatar ? asset($post->user->avatar) : asset('images/Vector.png') }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-full object-cover" />
                                        </a>
                                        <div>
                                            <a href="{{ route('profile', $post->user->username) }}" class="font-semibold">{{ $post->user->name }}</a>
                                            <div class="text-gray-500 text-sm">@{{ $post->user->username }} · {{ $post->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>

                                    <div class="bg-white rounded-lg p-4">
                                        <p class="text-gray-800 mb-4">{{ $post->body }}</p>

                                        <!-- Large post image (16:9) -->
                                        <div class="w-full rounded-lg overflow-hidden bg-gray-100">
                                            <div style="position:relative;padding-bottom:56.25%;height:0;">
                                                @php
                                                    $img = $post->image ?? null;
                                                    if ($img) {
                                                        $src = (strpos($img, 'http') === 0) ? $img : asset($img);
                                                    } else {
                                                        $src = 'https://picsum.photos/seed/post-' . $post->id . '/1200/675';
                                                    }
                                                @endphp
                                                <img src="{{ $src }}" alt="Post image" style="position:absolute;top:0;left:0;width:100%;height:100%;object-fit:cover;" />
                                            </div>
                                        </div>

                                        <div class="mt-3 flex items-center gap-6 text-sm text-gray-500">
                                            <button class="reply-btn flex items-center gap-2 hover:text-blue-600" data-post-id="{{ $post->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 9l-5 5m0 0l5 5m-5-5h12"/></svg>
                                                <span>{{ rand(0,120) }}</span>
                                            </button>

                                            <button class="repost-btn flex items-center gap-2 hover:text-green-600">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7V3m0 0h4M20 17v4m0 0h-4M7 7h10a2 2 0 012 2v6"/></svg>
                                                <span>{{ rand(0,200) }}</span>
                                            </button>

                                            <button class="like-btn flex items-center gap-2 hover:text-red-600" data-post-id="{{ $post->id }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 like-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                                <span class="likes-count">{{ $post->likes_count }}</span>
                                            </button>

                                            <button class="share-btn flex items-center gap-2 hover:text-gray-700">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 12v.01M12 12v.01M20 12v.01M4 12h16"/></svg>
                                                Share
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach

                        <div class="mt-6">{{ $posts->links() }}</div>
                    @else
                        <p class="text-gray-500">No posts yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </main>
</div>

<!-- Comment modal (hidden by default) -->
<div id="commentModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg w-full max-w-2xl p-4">
        <div class="flex justify-between items-center mb-3">
            <h3 class="text-lg font-semibold">Comments</h3>
            <button id="closeComments" class="text-gray-600">Close</button>
        </div>
        <div id="commentsList" class="space-y-3 max-h-60 overflow-auto mb-3">
            <!-- Comments injected here -->
        </div>
        <div class="flex gap-2">
            <input id="commentInput" type="text" placeholder="Write a comment..." class="flex-1 px-3 py-2 border rounded-lg" />
            <button id="postCommentBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Post</button>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Like button handler (AJAX toggle)
    document.querySelectorAll('.like-btn').forEach(btn => {
        btn.addEventListener('click', async (e) => {
            const postId = btn.getAttribute('data-post-id');
            try {
                const res = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                });
                if (!res.ok) {
                    if (res.status === 401) {
                        window.location.href = '/signin';
                        return;
                    }
                    throw new Error('Network response was not ok');
                }
                const data = await res.json();
                const countEl = btn.querySelector('.likes-count');
                if (countEl) countEl.textContent = data.likes_count;
                if (data.liked) btn.classList.add('text-red-600'); else btn.classList.remove('text-red-600');
            } catch (err) {
                console.error(err);
            }
        });
    });

    // Reply button opens comment modal (local only)
    const commentModal = document.getElementById('commentModal');
    const commentsList = document.getElementById('commentsList');
    const commentInput = document.getElementById('commentInput');
    const postCommentBtn = document.getElementById('postCommentBtn');
    let currentPostId = null;

    document.querySelectorAll('.reply-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            currentPostId = btn.getAttribute('data-post-id');
            commentsList.innerHTML = '<p class="text-gray-500">Comments are demo-only in this build.</p>';
            commentModal.classList.remove('hidden');
            commentModal.classList.add('flex');
        });
    });

    document.getElementById('closeComments').addEventListener('click', () => {
        commentModal.classList.add('hidden');
        commentModal.classList.remove('flex');
        commentInput.value = '';
    });

    postCommentBtn.addEventListener('click', () => {
        const text = commentInput.value.trim();
        if (!text) return;
        const div = document.createElement('div');
        div.className = 'flex items-start gap-3';
        div.innerHTML = `<img src='{{ asset('images/Vector.png') }}' class='w-8 h-8 rounded-full object-cover' alt=''> <div><strong>You</strong> <p class='text-sm text-gray-700'>${text}</p></div>`;
        commentsList.prepend(div);
        commentInput.value = '';
    });

    // Image preview for composer
    const postImageInput = document.getElementById('postImage');
    const imageName = document.getElementById('imageName');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewImg = document.getElementById('imagePreviewImg');
    if (postImageInput) {
        postImageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) {
                imageName.textContent = '';
                imagePreview.classList.add('hidden');
                return;
            }
            imageName.textContent = file.name;
            const reader = new FileReader();
            reader.onload = function(ev) {
                imagePreviewImg.src = ev.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endsection

@endsection
