

    <!-- Tombol Toggle Dark Mode -->
    <div class="fixed top-6 right-6 z-50">
        <button id="themeToggle" class="p-3 rounded-2xl bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-700 hover:scale-110 transition-all focus:outline-none">
            <!-- Icon Sun (Terlihat saat dark mode) -->
            <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <!-- Icon Moon (Terlihat saat light mode) -->
            <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
            </svg>
        </button>
    </div>

    <div class="min-h-screen flex flex-col items-center py-12 px-6">
        <!-- Judul Utama -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight text-balance">Galeri Destinasi Interaktif</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-3 text-lg">Geser secara manual untuk melihat detail informasi.</p>
        </div>

        <!-- Main Carousel Container -->
        <div class="relative w-full max-w-4xl group">
            
            <!-- Wrapper untuk Slide -->
            <div class="overflow-hidden">
                
                <!-- Track -->
                <div id="carouselTrack" class="carousel-track">
                    
                    <!-- Slide 1 -->
                    <div class="carousel-item min-w-full flex flex-col px-2">
                        <div class="relative overflow-hidden rounded-3xl shadow-xl bg-black aspect-video md:aspect-[21/9]">
                            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?auto=format&fit=crop&q=80&w=1200" 
                                 alt="Pegunungan Alpen" 
                                 class="img-zoom w-full h-full object-cover object-center transition-transform hover:scale-105 duration-700">
                            <div class="absolute top-4 left-4">
                                <span class="bg-blue-600/80 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Alam</span>
                            </div>
                        </div>
                        <div class="mt-6 bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Eksplorasi Pegunungan Alpen</h3>
                            <p class="text-gray-600 dark:text-gray-300 mt-3 leading-relaxed text-lg">
                                Rasakan sensasi berdiri di puncak dunia. Pegunungan Alpen menawarkan pemandangan salju abadi dan udara segar bagi petualang sejati.
                            </p>
                        </div>
                    </div>
                    
                    <!-- Slide 2 -->
                    <div class="carousel-item min-w-full flex flex-col px-2">
                        <div class="relative overflow-hidden rounded-3xl shadow-xl bg-black aspect-video md:aspect-[21/9]">
                            <img src="https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&q=80&w=1200" 
                                 alt="Mercusuar Pantai" 
                                 class="img-zoom w-full h-full object-cover object-center transition-transform hover:scale-105 duration-700">
                            <div class="absolute top-4 left-4">
                                <span class="bg-teal-600/80 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Pantai</span>
                            </div>
                        </div>
                        <div class="mt-6 bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Ketenangan di Mercusuar</h3>
                            <p class="text-gray-600 dark:text-gray-300 mt-3 leading-relaxed text-lg">
                                Berjalan di sepanjang garis pantai yang sunyi dengan latar belakang mercusuar bersejarah. Tempat ideal untuk menikmati senja.
                            </p>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-item min-w-full flex flex-col px-2">
                        <div class="relative overflow-hidden rounded-3xl shadow-xl bg-black aspect-video md:aspect-[21/9]">
                            <img src="https://images.unsplash.com/photo-1502082553048-f009c37129b9?auto=format&fit=crop&q=80&w=1200" 
                                 alt="Kedalaman Hutan" 
                                 class="img-zoom w-full h-full object-cover object-center transition-transform hover:scale-105 duration-700">
                            <div class="absolute top-4 left-4">
                                <span class="bg-emerald-600/80 backdrop-blur-md text-white px-3 py-1 rounded-full text-xs font-bold uppercase tracking-widest">Hutan</span>
                            </div>
                        </div>
                        <div class="mt-6 bg-white dark:bg-gray-800 p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
                            <h3 class="text-2xl font-bold text-gray-800 dark:text-white">Misteri Hutan Rimba</h3>
                            <p class="text-gray-600 dark:text-gray-300 mt-3 leading-relaxed text-lg">
                                Masuki dunia hijau yang penuh dengan rahasia alam. Keanekaragaman flora di hutan ini memberikan pengalaman tak terlupakan.
                            </p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Navigasi Panah -->
            <div class="absolute top-[calc(28.5%)] left-0 right-0 -translate-y-1/2 flex justify-between px-4 pointer-events-none">
                <button id="prevBtn" class="pointer-events-auto bg-white/30 dark:bg-black/30 hover:bg-white/60 dark:hover:bg-black/60 backdrop-blur-lg text-white p-3 rounded-2xl transition-all border border-white/20 opacity-0 group-hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="nextBtn" class="pointer-events-auto bg-white/30 dark:bg-black/30 hover:bg-white/60 dark:hover:bg-black/60 backdrop-blur-lg text-white p-3 rounded-2xl transition-all border border-white/20 opacity-0 group-hover:opacity-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <!-- Dots -->
            <div id="dotContainer" class="flex justify-center gap-3 mt-8"></div>
        </div>
    </div>

    <!-- Lightbox -->
    <div id="lightbox" class="fixed inset-0 z-[100] bg-black/95 flex items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
        <button id="closeLightbox" class="absolute top-6 right-6 text-white bg-white/10 hover:bg-white/20 p-3 rounded-full transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <img id="lightboxImg" src="" alt="Full Screen" class="max-w-[95%] max-h-[80vh] object-contain shadow-2xl transition-transform duration-300 scale-95">
        <div id="lightboxCaption" class="absolute bottom-10 text-white text-xl font-medium px-6 text-center bg-black/50 py-2 rounded-lg backdrop-blur-sm"></div>
    </div>
