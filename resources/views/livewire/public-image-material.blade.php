<div class="bg-gray-50 dark:bg-gray-900 font-sans text-gray-900 dark:text-gray-100 transition-colors duration-300">
   <x-carousel />
</div>
@push('headerScript')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Konfigurasi Tailwind untuk mendukung class-based dark mode
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
@endpush
@push('css')
    <style>
        .carousel-track {
            display: flex;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .img-zoom {
            cursor: zoom-in;
        }
        #carouselTrack::-webkit-scrollbar {
            display: none;
        }
    </style>
@endpush
@push('scripts')
    <script>
        const track = document.getElementById('carouselTrack');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const dotContainer = document.getElementById('dotContainer');
        const themeToggle = document.getElementById('themeToggle');
        const sunIcon = document.getElementById('sunIcon');
        const moonIcon = document.getElementById('moonIcon');
        const slides = Array.from(track.children);
        
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightboxImg');
        const lightboxCaption = document.getElementById('lightboxCaption');
        const closeLightbox = document.getElementById('closeLightbox');
        
        let currentIndex = 0;

        // Dark Mode Logic
        function toggleTheme() {
            document.documentElement.classList.toggle('dark');
            const isDark = document.documentElement.classList.contains('dark');
            sunIcon.classList.toggle('hidden', !isDark);
            moonIcon.classList.toggle('hidden', isDark);
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        }

        themeToggle.addEventListener('click', toggleTheme);

        // Check preference on load
        if (localStorage.getItem('theme') === 'dark' || 
            (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            sunIcon.classList.remove('hidden');
            moonIcon.classList.add('hidden');
        }

        // Carousel Logic
        function initDots() {
            slides.forEach((_, index) => {
                const dot = document.createElement('button');
                dot.className = `h-2.5 rounded-full transition-all duration-300 ${index === 0 ? 'w-12 bg-blue-600' : 'w-2.5 bg-gray-300 dark:bg-gray-700 hover:bg-gray-400'}`;
                dot.addEventListener('click', () => goToSlide(index));
                dotContainer.appendChild(dot);
            });
        }

        function goToSlide(index) {
            if (index < 0) index = slides.length - 1;
            if (index >= slides.length) index = 0;
            currentIndex = index;
            track.style.transform = `translateX(-${currentIndex * 100}%)`;
            updateDots();
        }

        function updateDots() {
            const dots = dotContainer.querySelectorAll('button');
            dots.forEach((dot, index) => {
                if (index === currentIndex) {
                    dot.classList.replace('w-2.5', 'w-12');
                    dot.classList.replace('bg-gray-300', 'bg-blue-600');
                    dot.classList.replace('dark:bg-gray-700', 'bg-blue-600');
                } else {
                    dot.classList.replace('w-12', 'w-2.5');
                    dot.classList.add('bg-gray-300', 'dark:bg-gray-700');
                    dot.classList.remove('bg-blue-600');
                }
            });
        }

        // Lightbox Logic
        slides.forEach(slide => {
            const img = slide.querySelector('img');
            const title = slide.querySelector('h3').innerText;
            img.addEventListener('click', () => {
                lightboxImg.src = img.src;
                lightboxCaption.innerText = title;
                lightbox.classList.remove('opacity-0', 'pointer-events-none');
                setTimeout(() => {
                    lightboxImg.classList.remove('scale-95');
                    lightboxImg.classList.add('scale-100');
                }, 10);
                document.body.style.overflow = 'hidden';
            });
        });

        function closeFullScreen() {
            lightboxImg.classList.replace('scale-100', 'scale-95');
            lightbox.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = '';
        }

        closeLightbox.addEventListener('click', closeFullScreen);
        lightbox.addEventListener('click', (e) => { if (e.target === lightbox) closeFullScreen(); });

        prevBtn.addEventListener('click', () => goToSlide(currentIndex - 1));
        nextBtn.addEventListener('click', () => goToSlide(currentIndex + 1));

        window.onload = initDots;

        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') goToSlide(currentIndex - 1);
            if (e.key === 'ArrowRight') goToSlide(currentIndex + 1);
            if (e.key === 'Escape') closeFullScreen();
        });
    </script>
    
        
    @endpush
