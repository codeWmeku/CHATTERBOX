<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ChatterBox')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    @yield('content')

    <!-- Fullscreen Image Preview Modal (Safe training/demo UI) -->
    <div id="image-preview-modal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-90 items-center justify-center" aria-hidden="true" role="dialog" aria-modal="true">
        <div class="absolute top-4 left-4 text-white bg-yellow-600 px-3 py-1 rounded" id="training-badge">Training Simulation</div>
        <button id="image-preview-close" class="absolute top-4 right-4 text-white bg-gray-800 bg-opacity-60 hover:bg-opacity-90 px-3 py-1 rounded">Close</button>
        <div id="image-preview-container" class="max-w-[95%] max-h-[95%] flex items-center justify-center">
            <img id="image-preview-img" src="{{ asset('images/HS1.png') }}" alt="Preview" class="max-w-full max-h-full object-contain rounded" />
        </div>
    </div>

    @yield('scripts')

    <script>
        (function(){
            // Elements
            const modal = document.getElementById('image-preview-modal');
            const img = document.getElementById('image-preview-img');
            const closeBtn = document.getElementById('image-preview-close');
            const trainingBadge = document.getElementById('training-badge');

            // Ensure modal is keyboard-focusable when opened
            function openPreview(src, title) {
                img.src = src || img.getAttribute('src');
                if (title) img.alt = title;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                // Move focus to close button for accessibility
                closeBtn.focus();
            }

            function closePreview() {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
                // restore src to HS1 default to avoid accidental leakage
                // (keep last shown src in history if you want)
                // img.src = "{{ asset('images/HS1.png') }}";
            }

            // Attach to all post images (use `.post-image` class on images inside posts)
            function attachPostImageHandlers() {
                document.querySelectorAll('.post-image').forEach(el => {
                    el.style.cursor = 'zoom-in';
                    el.addEventListener('click', (e) => {
                        // Training mode: always show HS1.png regardless of clicked image
                        openPreview("{{ asset('images/HS1.png') }}", el.alt || 'Training image');
                    });
                });
            }

            // Close handlers
            closeBtn.addEventListener('click', closePreview);
            modal.addEventListener('click', (e) => {
                if (e.target === modal) closePreview();
            });
            document.addEventListener('keydown', (e) => {
                // Standard and accessible close key
                if (e.key === 'Escape') return closePreview();
                // Optional training hotkey: Alt+E closes preview when visible (non-restrictive)
                if (e.altKey && (e.key === 'e' || e.key === 'E')) {
                    if (!modal.classList.contains('hidden')) {
                        e.preventDefault();
                        return closePreview();
                    }
                }
            });

            // Initialize handlers on DOM ready
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', attachPostImageHandlers);
            } else {
                attachPostImageHandlers();
            }
        })();
    </script>
</body>
</html>