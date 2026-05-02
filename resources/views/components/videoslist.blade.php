<div class="bg-[#FAFAFA] text-zinc-900">

    <div class="flex flex-col md:flex-row h-screen overflow-hidden">
        
        <!-- Sidebar: Navigation -->
        <aside class="w-full md:w-[340px] bg-white border-r border-zinc-100 flex flex-col z-10">
            <div class="p-8 pb-4">
                <h2 class="text-[11px] font-bold uppercase tracking-[0.2em] text-zinc-400 mb-4">Daftar Modul</h2>
            </div>
            
            <nav id="playlist" class="flex-1 overflow-y-auto custom-scrollbar px-6 pb-8 space-y-3">
                <!-- Video Item 1 -->
                <button onclick="changeVideo('https://www.youtube.com/embed/dQw4w9WgXcQ', 'Eksplorasi Konsep Dasar', 'Pelajari bagaimana membangun fondasi berpikir kritis dalam desain arsitektur modern. Kita akan mengulas sejarah dan evolusi minimalisme.', this)" 
                    class="playlist-btn w-full text-left p-4 rounded-2xl transition-all duration-300 group relative bg-white border border-zinc-100 btn-active ring-1 ring-zinc-900/5">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-bold text-zinc-900 bg-zinc-100 px-2 py-0.5 rounded-full">MODUL 01</span>
                        <div class="playing-icon flex gap-0.5 items-end h-3">
                            <div class="w-0.5 h-full bg-zinc-900 animate-[bounce_1s_infinite]"></div>
                            <div class="w-0.5 h-2/3 bg-zinc-900 animate-[bounce_1.2s_infinite]"></div>
                            <div class="w-0.5 h-full bg-zinc-900 animate-[bounce_0.8s_infinite]"></div>
                        </div>
                    </div>
                    <p class="text-sm font-semibold text-zinc-900 group-hover:translate-x-1 transition-transform">Eksplorasi Konsep Dasar</p>
                    <p class="text-[11px] text-zinc-400 mt-1">12 Menit • Dasar</p>
                </button>

                <!-- Video Item 2 -->
                <button onclick="changeVideo('https://www.youtube.com/embed/ScMzIvxBSi4', 'Konfigurasi Environment', 'Langkah praktis menyiapkan alat tempur Anda. Dari pemilihan IDE hingga optimasi workflow yang efisien.', this)" 
                    class="playlist-btn w-full text-left p-4 rounded-2xl transition-all duration-300 group hover:bg-zinc-50 border border-transparent">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-bold text-zinc-400">MODUL 02</span>
                    </div>
                    <p class="text-sm font-semibold text-zinc-500 group-hover:text-zinc-900 group-hover:translate-x-1 transition-transform">Konfigurasi Environment</p>
                    <p class="text-[11px] text-zinc-400 mt-1">24 Menit • Menengah</p>
                </button>

                <!-- Video Item 3 -->
                <button onclick="changeVideo('https://www.youtube.com/embed/PkZNo7MFNFg', 'Manajemen Struktur File', 'Cara mengelola aset digital agar tetap rapi saat proyek tumbuh besar. Standar industri untuk penamaan dan kategori.', this)" 
                    class="playlist-btn w-full text-left p-4 rounded-2xl transition-all duration-300 group hover:bg-zinc-50 border border-transparent">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-bold text-zinc-400">MODUL 03</span>
                    </div>
                    <p class="text-sm font-semibold text-zinc-500 group-hover:text-zinc-900 group-hover:translate-x-1 transition-transform">Manajemen Struktur File</p>
                    <p class="text-[11px] text-zinc-400 mt-1">18 Menit • Lanjutan</p>
                </button>

                <!-- Video Item 4 -->
                <button onclick="changeVideo('https://www.youtube.com/embed/6m6YlOsqZ80', 'Prinsip UI Minimalis', 'Bedah tuntas elemen visual yang membuat desain terasa ringan, fungsional, dan tetap memiliki estetika tinggi.', this)" 
                    class="playlist-btn w-full text-left p-4 rounded-2xl transition-all duration-300 group hover:bg-zinc-50 border border-transparent">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-[10px] font-bold text-zinc-400">MODUL 04</span>
                    </div>
                    <p class="text-sm font-semibold text-zinc-500 group-hover:text-zinc-900 group-hover:translate-x-1 transition-transform">Prinsip UI Minimalis</p>
                    <p class="text-[11px] text-zinc-400 mt-1">30 Menit • Ahli</p>
                </button>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto flex flex-col items-center">
            <div class="w-full max-w-5xl px-8 py-10 md:py-14">
                
                <!-- Player Section -->
                <div class="video-container relative w-full rounded-[2rem] overflow-hidden bg-white shadow-[0_32px_64px_-15px_rgba(0,0,0,0.1)] ring-1 ring-zinc-200/50 aspect-video group">
                    <iframe 
                        id="videoFrame"
                        class="absolute top-0 left-0 w-full h-full"
                        src="https://www.youtube.com/embed/dQw4w9WgXcQ" 
                        title="Video Player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                    </iframe>
                </div>
                
                <!-- Info Section -->
                <div class="mt-12 max-w-3xl">
                    <div class="space-y-2">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            <span class="text-[11px] font-bold text-zinc-400 uppercase tracking-widest">Sesi Aktif</span>
                        </div>
                        <h2 id="currentTitle" class="text-3xl font-bold tracking-tight text-zinc-900">Eksplorasi Konsep Dasar</h2>
                    </div>
                    
                    <div class="mt-8 flex flex-col md:flex-row gap-12 border-t border-zinc-100 pt-8">
                        <div class="flex-1">
                            <h3 class="text-xs font-bold text-zinc-900 uppercase tracking-wider mb-4">Ringkasan Sesi</h3>
                            <p id="currentDesc" class="text-zinc-500 text-base leading-relaxed font-medium">
                                Pelajari bagaimana membangun fondasi berpikir kritis dalam desain arsitektur modern. Kita akan mengulas sejarah dan evolusi minimalisme.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    </div>

    
</body>