<section class="max-w-7xl mx-auto px-6 py-16 md:py-24 grid lg:grid-cols-2 gap-16 items-center">
        <!-- Text Content -->
        <div class="space-y-8 text-center lg:text-left">
            <span class="inline-block px-4 py-1.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold rounded-full border border-blue-100 dark:border-blue-800 uppercase">Sistem Edukasi Terintegrasi</span>
            <h2 class="text-4xl md:text-6xl font-extrabold leading-[1.1] text-slate-900 dark:text-white">
                Monitoring Siswa yang <span class="text-blue-600">Transparan</span>, Kolaboratif, dan Berdampak
            </h2>
            <p class="text-gray-500 dark:text-slate-400 text-base md:text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                InklusifEdu.com membantu sekolah, guru, dan orang tua memantau perkembangan siswa secara real-time dengan data yang akurat, komentar yang terbuka, dan proses yang terarah.
            </p>
            <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                <button class="px-8 py-4 bg-blue-600 text-white rounded-2xl font-bold flex items-center gap-3 shadow-xl shadow-blue-200 dark:shadow-none hover:bg-blue-700 transform hover:-translate-y-1 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Login Guru
                </button>
                <button class="px-8 py-4 bg-white dark:bg-slate-800 text-blue-600 dark:text-blue-400 border-2 border-blue-100 dark:border-blue-900 rounded-2xl font-bold flex items-center gap-3 hover:bg-blue-50 dark:hover:bg-slate-700 transform hover:-translate-y-1 transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Login Orang Tua
                </button>
            </div>
            {{-- <div class="flex flex-wrap justify-center lg:justify-start gap-6 pt-4">
                <div class="flex items-center gap-2 text-xs font-bold text-gray-500">
                    <span class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center text-white"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg></span> Aman
                </div>
                <div class="flex items-center gap-2 text-xs font-bold text-gray-500">
                    <span class="w-5 h-5 bg-blue-600 rounded-full flex items-center justify-center text-white"><svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4"><polyline points="20 6 9 17 4 12"/></svg></span> Terpercaya
                </div>
            </div> --}}
        </div>

        <!-- Mockup Dashboard -->
        <div class="relative w-full max-w-xl mx-auto lg:max-w-none">
            <div class="bg-white dark:bg-slate-900 rounded-[40px] p-8 card-shadow border border-gray-50 dark:border-slate-800">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-white">Dashboard Guru</h3>
                        <p class="text-xs font-medium text-gray-400 uppercase tracking-tighter">SMPN 10 Takari</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-slate-800 border border-gray-100 dark:border-slate-700 px-3 py-2 rounded-xl text-[10px] font-bold text-gray-500 dark:text-slate-400 cursor-pointer">
                        Semester Genap 2024/2025 ▼
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8 text-center sm:text-left">
                    <div class="bg-blue-50/50 dark:bg-blue-900/20 p-4 rounded-3xl border border-blue-50 dark:border-blue-900/40">
                        <p class="text-[9px] font-bold text-gray-400 uppercase mb-1">Mentoring</p>
                        <h4 id="count-mentoring" class="text-2xl font-black text-slate-900 dark:text-white">128</h4>
                    </div>
                    <div class="bg-emerald-50/50 dark:bg-emerald-900/20 p-4 rounded-3xl border border-emerald-50 dark:border-emerald-900/40">
                        <p class="text-[9px] font-bold text-gray-400 uppercase mb-1">Siswa</p>
                        <h4 id="count-siswa" class="text-2xl font-black text-slate-900 dark:text-white">256</h4>
                    </div>
                    <div class="bg-amber-50/50 dark:bg-amber-900/20 p-4 rounded-3xl border border-amber-50 dark:border-amber-900/40">
                        <p class="text-[9px] font-bold text-gray-400 uppercase mb-1">Pesan</p>
                        <h4 id="count-pesan" class="text-2xl font-black text-slate-900 dark:text-white">342</h4>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-6">
                     <div class="space-y-4">
                        <h5 class="text-[10px] font-bold text-slate-800 dark:text-slate-300 uppercase tracking-wider">Ringkasan Progress</h5>
                        <div class="space-y-4">
                            <!-- Status Assessment -->
                            <div class="flex justify-between items-center">
                                <span class="text-[11px] font-bold text-gray-400">Assessment</span>
                                <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/30 text-green-600 dark:text-green-400 text-[9px] font-bold rounded-md uppercase">Completed</span>
                            </div>
                            <!-- Status Monitoring -->
                            <div class="flex justify-between items-center">
                                <span class="text-[11px] font-bold text-gray-400">Monitoring</span>
                                <span class="px-2 py-0.5 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-[9px] font-bold rounded-md uppercase">In Progress</span>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <h5 class="text-[10px] font-bold text-slate-800 dark:text-slate-300 uppercase">Komentar Terbaru</h5>
                        <div class="space-y-3">
                            <div class="flex gap-3 items-start">
                                <div class="w-8 h-8 bg-slate-100 dark:bg-slate-800 rounded-full flex-shrink-0"></div>
                                <div class="flex-1">
                                    <p class="text-[10px] font-extrabold text-slate-900 dark:text-slate-200">Ibu Sari</p>
                                    <p class="text-[9px] text-gray-500 leading-tight">Perkembangan positif, terus pertahankan!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>