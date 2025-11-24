@extends('app')

@section('title', 'Sign in to ChatterBox')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-md w-full p-8 relative">
        <!-- Close Button -->
        <button onclick="window.location.href='/'" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/Vector.png') }}" alt="ChatterBox Logo" class="w-64 h-64 mx-auto">
            <!-- 
                ============================================
                MODAL LOGO - REPLACE WITH YOUR BIRD LOGO
                ============================================
            -->
           
        </div>

        <!-- Title -->
        <h2 class="text-3xl font-bold text-center mb-8">Sign in to ChatterBox</h2>

        <!-- OAuth Buttons -->
        <div class="space-y-3 mb-4">
            <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-full shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Sign in with Google
            </a>

            <a href="{{ route('auth.apple') }}" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-full shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.05 20.28c-.98.95-2.05.88-3.08.4-1.09-.5-2.08-.48-3.24 0-1.44.62-2.2.44-3.06-.4C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                </svg>
                Sign in with Apple
            </a>
        </div>

        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-2 bg-white text-gray-500">or</span>
            </div>
        </div>

        @if(request('mode') !== 'signup')
            <!-- Sign In Form -->
            <form action="{{ route('signin') }}" method="POST" class="space-y-4">
                @csrf
                
                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div>
                    <input type="text" name="login" placeholder="Phone, email, or username" required value="{{ old('login') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <button type="submit" class="w-full bg-black text-white py-3 rounded-full font-medium hover:bg-gray-800 transition">
                    Next
                </button>

                <button type="button" class="w-full border border-gray-300 text-gray-700 py-3 rounded-full font-medium hover:bg-gray-50 transition">
                    Forgot password?
                </button>
            </form>

            <!-- Sign Up Link -->
            <p class="mt-8 text-center text-gray-600">
                Don't have an account? 
                <a href="/?mode=signup" class="text-blue-600 hover:underline">Sign up</a>
            </p>
        @else
            <!-- Sign Up Form -->
            <form action="{{ route('signup') }}" method="POST" class="space-y-4">
                @csrf

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-3">
                    <input type="text" name="first_name" placeholder="First name" value="{{ old('first_name') }}" class="px-4 py-3 border border-gray-300 rounded-lg">
                    <input type="text" name="last_name" placeholder="Last name" value="{{ old('last_name') }}" class="px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <input type="text" name="name" placeholder="Full name (optional if you provided first/last)" value="{{ old('name') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <input type="text" name="username" placeholder="Username" required value="{{ old('username') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <input type="text" name="phone" placeholder="Phone (optional)" value="{{ old('phone') }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <input type="password" name="password" placeholder="Password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <div>
                    <input type="password" name="password_confirmation" placeholder="Confirm password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg">
                </div>

                <button type="submit" class="w-full bg-black text-white py-3 rounded-full font-medium hover:bg-gray-800 transition">Create account</button>

                <p class="mt-4 text-center text-sm text-gray-600">Already have an account? <a href="/signin" class="text-blue-600 hover:underline">Sign in</a></p>
            </form>
        @endif
    </div>
</div>
@endsection