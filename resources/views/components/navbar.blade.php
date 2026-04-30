<nav class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-gray-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="bg-blue-600 p-2 rounded-xl text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-blue-600 leading-none">InklusifEdu<span class="text-gray-400 font-semibold">.com</span></h1>
                    <p class="text-[10px] font-bold text-gray-500 tracking-widest uppercase">SMPN 10 TAKARI</p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <!-- Dropdown Login Navbar -->
                <div class="relative inline-block text-left">
                    <button onclick="toggleDropdown('nav-login-dropdown')" class="flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-100 dark:shadow-none hover:bg-blue-700 transition-all">
                        Login
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div id="nav-login-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 rounded-xl shadow-2xl border border-gray-100 dark:border-slate-700 overflow-hidden z-50">
                        <a href="/admin/login" class="block px-4 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-700 border-b border-gray-50 dark:border-slate-700">Sebagai Guru</a>
                        <a href="/parent/login" class="block px-4 py-3 text-sm font-semibold text-slate-700 dark:text-slate-200 hover:bg-blue-50 dark:hover:bg-slate-700">Sebagai Orang Tua</a>
                    </div>
                </div>

                <!-- Dark Mode Toggle -->
                <button onclick="toggleDarkMode()" class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-full text-xs font-bold text-gray-700 dark:text-slate-200 shadow-sm hover:shadow-md transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                    <span class="hidden sm:inline">Dark Mode</span>
                </button>
            </div>
        </div>
    </nav>