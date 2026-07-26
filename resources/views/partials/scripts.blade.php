<script>
    function toggleDarkMode() {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'));

        const toggleButton = document.getElementById('darkModeToggle');
        const toggleButtonDesktop = document.getElementById('darkModeToggleDesktop');

        if (document.documentElement.classList.contains('dark')) {
            if (toggleButton) toggleButton.innerHTML = '☀️';
            if (toggleButtonDesktop) toggleButtonDesktop.innerHTML = '☀️';
        } else {
            if (toggleButton) toggleButton.innerHTML = '🌙';
            if (toggleButtonDesktop) toggleButtonDesktop.innerHTML = '🌙';
        }
    }

    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        const menuToggle = document.getElementById('mobileMenuToggle');

        mobileMenu.classList.toggle('hidden');

        if (mobileMenu.classList.contains('hidden')) {
            menuToggle.innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            `;
        } else {
            menuToggle.innerHTML = `
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            `;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.classList.add('dark');
            const toggleButton = document.getElementById('darkModeToggle');
            const toggleButtonDesktop = document.getElementById('darkModeToggleDesktop');
            if (toggleButton) toggleButton.innerHTML = '☀️';
            if (toggleButtonDesktop) toggleButtonDesktop.innerHTML = '☀️';
        }

        const toggleButton = document.getElementById('darkModeToggle');
        const toggleButtonDesktop = document.getElementById('darkModeToggleDesktop');
        if (toggleButton) toggleButton.onclick = toggleDarkMode;
        if (toggleButtonDesktop) toggleButtonDesktop.onclick = toggleDarkMode;
        document.getElementById('mobileMenuToggle').onclick = toggleMobileMenu;
    });
</script>