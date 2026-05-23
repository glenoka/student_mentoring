<nav class="sticky top-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-gray-100 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <!-- Header Logo Image (Updated source and increased size dynamically) -->
                <img src="https://inklusifedu.com/images/logo_edu.png" 
                     alt="InklusifEdu Logo" 
                     class="h-20 w-auto object-contain rounded-lg" 
                     onerror="this.onerror=null; this.outerHTML='<div class=\'bg-blue-600 p-2 rounded-xl text-white\'><svg xmlns=\'http://www.w3.org/2000/svg\' width=\'24\' height=\'24\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' stroke-linecap=\'round\' stroke-linejoin=\'round\'><path d=\'M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z\'/><path d=\'M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z\'/></svg></div>';">
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
    @push('css')
        <style>
        body {
            font-family: 'Inter', sans-serif;
            transition: background-color 0.3s, color 0.3s;
        }
        .hero-gradient {
            background: radial-gradient(circle at 80% 20%, #e0f2fe 0%, transparent 40%),
                        radial-gradient(circle at 10% 80%, #eff6ff 0%, transparent 30%);
        }
        .dark .hero-gradient {
            background: radial-gradient(circle at 80% 20%, #1e293b 0%, transparent 40%),
                        radial-gradient(circle at 10% 80%, #0f172a 0%, transparent 30%);
            background-color: #020617;
        }
        .card-shadow {
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.05);
        }
        .dark .card-shadow {
            box-shadow: 0 10px 40px -10px rgba(0, 0, 0, 0.4);
        }
    </style>
    @endpush

    @push('headerScript')
        <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>
    @endpush