<div>
   <x-videoslist/>
</div>
@push('headerScript')
<script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
@endpush
@push('css')
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            -webkit-font-smoothing: antialiased;
        }
        
        .custom-scrollbar::-webkit-scrollbar {
            width: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .video-container {
            transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .btn-active {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -2px rgba(0, 0, 0, 0.02);
        }
    </style>
@endpush
@push('scripts')
    <script>
        function changeVideo(url, title, description, element) {
            const iframe = document.getElementById('videoFrame');
            const titleDisplay = document.getElementById('currentTitle');
            const descDisplay = document.getElementById('currentDesc');
            
            // Effect: Fade out
            document.querySelector('.video-container').style.opacity = '0';
            document.querySelector('.video-container').style.transform = 'translateY(10px)';
            
            setTimeout(() => {
                iframe.src = url;
                titleDisplay.innerText = title;
                descDisplay.innerText = description;
                
                // Effect: Fade in
                document.querySelector('.video-container').style.opacity = '1';
                document.querySelector('.video-container').style.transform = 'translateY(0)';
            }, 300);

            // Reset buttons
            const buttons = document.querySelectorAll('.playlist-btn');
            buttons.forEach(btn => {
                btn.classList.remove('bg-white', 'border-zinc-100', 'btn-active', 'ring-1', 'ring-zinc-900/5');
                btn.classList.add('hover:bg-zinc-50', 'border-transparent');
                
                const label = btn.querySelector('span');
                label.classList.remove('text-zinc-900', 'bg-zinc-100');
                label.classList.add('text-zinc-400');
                
                const mainText = btn.querySelector('.text-sm');
                mainText.classList.replace('text-zinc-900', 'text-zinc-500');

                const playingIcon = btn.querySelector('.playing-icon');
                if (playingIcon) playingIcon.classList.add('hidden');
            });

            // Set active
            element.classList.add('bg-white', 'border-zinc-100', 'btn-active', 'ring-1', 'ring-zinc-900/5');
            element.classList.remove('hover:bg-zinc-50', 'border-transparent');
            
            const activeLabel = element.querySelector('span');
            activeLabel.classList.remove('text-zinc-400');
            activeLabel.classList.add('text-zinc-900', 'bg-zinc-100');
            
            const activeMainText = element.querySelector('.text-sm');
            activeMainText.classList.replace('text-zinc-500', 'text-zinc-900');

            const activePlayingIcon = element.querySelector('.playing-icon');
            if (activePlayingIcon) activePlayingIcon.classList.remove('hidden');

            if (window.innerWidth < 768) {
                document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
            }
        }
    </script>
@endpush
