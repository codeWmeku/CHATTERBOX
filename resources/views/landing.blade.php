@extends('app')

@section('title', 'ChatterBox - Happening now')

@section('content')
<div class="min-h-screen flex">
    <!-- Left Side - Branding -->
    <div class="hidden lg:flex lg:w-1/2 bg-white items-center justify-center">
        <div class="text-center">
            <div class="mb-8">
                <img src="{{ asset('images/Vector.png') }}" alt="ChatterBox Logo" class="w-64 h-64 mx-auto">
                <!-- 
                    ============================================
                    REPLACE THE SVG BELOW WITH YOUR BIRD LOGO
                    ============================================
                    Option 1: Use an image file
                    <img src="{{ asset('images/bird-logo.png') }}" alt="ChatterBox Logo" class="w-64 h-64 mx-auto">
                    
                    
                    Option 2: Paste your SVG code here
                    Replace the entire <svg>...</svg> tag below with your bird logo SVG
                    ============================================
                -->
               
            </div>
            <h1 class="text-6xl font-bold tracking-tight">CHATTERBOX</h1>
        </div>
    </div>

    <!-- Right Side - Sign Up Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
        <div class="max-w-md w-full">
            <div class="lg:hidden mb-8 text-center">
                <img src="{{ asset('images/Vector.png') }}" alt="ChatterBox Logo" class="w-64 h-64 mx-auto">
                <!-- 
                    ============================================
                    MOBILE LOGO - REPLACE WITH YOUR BIRD LOGO
                    ============================================
                -->
                <svg class="w-16 h-16 mx-auto mb-4" viewBox="0 0 3 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.33264 1.33264V5.66374" stroke="black" stroke-width="2.66529" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h1 class="text-4xl font-bold mb-2">CHATTERBOX</h1>
            </div>

            <h2 class="text-5xl font-bold mb-2">Happening now</h2>
            <p class="text-2xl font-semibold mb-8">Join today.</p>

            <div class="space-y-3">
                <!-- Google Sign Up -->
                <a href="{{ route('auth.google') }}" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-full shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Sign up with Google
                </a>

                <!-- Apple Sign Up -->
                <a href="{{ route('auth.apple') }}" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-full shadow-sm bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.05 20.28c-.98.95-2.05.88-3.08.4-1.09-.5-2.08-.48-3.24 0-1.44.62-2.2.44-3.06-.4C2.79 15.25 3.51 7.59 9.05 7.31c1.35.07 2.29.74 3.08.8 1.18-.24 2.31-.93 3.57-.84 1.51.12 2.65.72 3.4 1.8-3.12 1.87-2.38 5.98.48 7.13-.57 1.5-1.31 2.99-2.54 4.09l.01-.01zM12.03 7.25c-.15-2.23 1.66-4.07 3.74-4.25.29 2.58-2.34 4.5-3.74 4.25z"/>
                    </svg>
                    Sign up with Apple
                </a>

                <!-- Divider -->
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-gray-50 text-gray-500">or</span>
                    </div>
                </div>

                <!-- Create Account Button -->
                <button onclick="openSignUpModal()" class="w-full flex items-center justify-center px-4 py-3 border border-transparent rounded-full shadow-sm text-sm font-medium text-white bg-black hover:bg-gray-800 transition">
                    Create account
                </button>

                <p class="text-xs text-gray-500">
                    By signing up, you agree to the Terms of Service and Privacy Policy, including Cookie Use.
                </p>
            </div>

            <!-- Sign In Section -->
            <div class="mt-10">
                <h3 class="text-lg font-semibold mb-4">Already have an account?</h3>
                <a href="{{ route('signin') }}" class="w-full flex items-center justify-center px-4 py-3 border border-gray-300 rounded-full shadow-sm bg-white text-sm font-medium text-blue-600 hover:bg-gray-50 transition">
                    Sign in
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="fixed bottom-0 w-full bg-white border-t border-gray-200 py-2">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center items-center gap-4 text-xs text-gray-500">
            <a href="#" class="hover:underline">About</a>
            <a href="#" class="hover:underline">Help Center</a>
            <a href="#" class="hover:underline">Terms of Service</a>
            <a href="#" class="hover:underline">Privacy Policy</a>
            <a href="#" class="hover:underline">Cookie Policy</a>
            <a href="#" class="hover:underline">Accessibility</a>
            <a href="#" class="hover:underline">Ads info</a>
            <a href="#" class="hover:underline">Blog</a>
            <a href="#" class="hover:underline">Careers</a>
            <span>© 2025 ChatterBox Corp</span>
        </div>
    </div>
</footer>
@endsection

@section('scripts')
<script>
function openSignUpModal() {
    window.location.href = "{{ route('signin') }}?mode=signup";
}
</script>
@endsection