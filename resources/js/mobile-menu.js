// Mobile Menu Functionality
document.addEventListener('DOMContentLoaded', function() {
    const btnMenu = document.getElementById('btn-menu');
    const btnMenuClose = document.getElementById('btn-menu-close');
    const mobileMenu = document.getElementById('mobileMenu');
    const menuPanel = document.getElementById('menuPanel');
    const menuOverlay = document.getElementById('menuOverlay');
    const btnProducts = document.getElementById('btn-products');
    const submenuProducts = document.getElementById('submenu-products');
    const productsCaret = document.getElementById('products-caret');

    // Open mobile menu
    btnMenu?.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
        setTimeout(() => {
            menuPanel.style.transform = 'translateX(0)';
        }, 10);
    });

    // Close mobile menu functions
    const closeMenu = () => {
        menuPanel.style.transform = 'translateX(-100%)';
        setTimeout(() => {
            mobileMenu.classList.add('hidden');
        }, 300);
    };

    btnMenuClose?.addEventListener('click', closeMenu);
    menuOverlay?.addEventListener('click', function(e) {
        // Don't close if clicking on the menu panel or its children (links)
        if (menuPanel && menuPanel.contains(e.target)) {
            // If clicking on a link, let it navigate immediately
            const link = e.target.closest('a');
            if (link && link.href && link.href !== '#') {
                // Close menu and let link navigate
                closeMenu();
                return; // Don't prevent navigation
            }
            return; // Let the link handle navigation
        }
        closeMenu();
    });

    // Toggle products submenu
    btnProducts?.addEventListener('click', (e) => {
        e.stopPropagation(); // Prevent event bubbling
        const expanded = btnProducts.getAttribute('aria-expanded') === 'true';
        btnProducts.setAttribute('aria-expanded', !expanded);
        
        if (expanded) {
            submenuProducts.classList.add('hidden');
            productsCaret.style.transform = 'rotate(90deg)';
        } else {
            submenuProducts.classList.remove('hidden');
            productsCaret.style.transform = 'rotate(180deg)';
        }
    });
});