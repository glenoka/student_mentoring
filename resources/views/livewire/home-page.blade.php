<div class="hero-gradient min-h-screen">

    <x-navbar />
    <x-hero />
    <x-features />
    <x-features2 />
    <x-footer />
@push('scripts')
<script>
     window.addEventListener('load', () => {
            if (localStorage.getItem('theme') === 'dark') {
                document.documentElement.classList.add('dark');
            }
            
            // Jalankan animasi untuk angka-angka di hero dashboard
            animateValue("count-mentoring", 100, 128, 2000);
            animateValue("count-siswa", 100, 256, 2000);
            animateValue("count-pesan", 100, 342, 2000);
        });
        function animateValue(id, start, end, duration) {
            const obj = document.getElementById(id);
            if (!obj) return;
            
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start);
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }
    function toggleDarkMode() {
        document.documentElement.classList.toggle('dark');
        const isDark = document.documentElement.classList.contains('dark');
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        if (dropdown) dropdown.classList.toggle('hidden');
    }

    window.addEventListener('click', function(event) {
        if (!event.target.closest('button')) {
            const dropdown = document.getElementById('nav-login-dropdown');
            if (dropdown) dropdown.classList.add('hidden');
        }
    });
</script>
@endpush
</div>