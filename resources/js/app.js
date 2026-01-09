import './bootstrap';
import '../css/app.css'
import '../css/app.css'
import './link-fix.js'

// --- Mobile menu toggle ---
const $ = (sel) => document.querySelector(sel)

const openMenu = () => {
  const mobileMenu = $('#mobileMenu')
  const menuPanel = $('#menuPanel')
  if (mobileMenu && menuPanel) {
    mobileMenu.classList.remove('hidden')
    // slide panel in
    setTimeout(() => {
      menuPanel.style.transform = 'translateX(0)'
    }, 10)
  }
}
const closeMenu = () => {
  const menuPanel = $('#menuPanel')
  const mobileMenu = $('#mobileMenu')
  if (menuPanel && mobileMenu) {
    // slide panel out then hide container
    menuPanel.style.transform = 'translateX(-100%)'
    setTimeout(() => {
      mobileMenu.classList.add('hidden')
    }, 300)
  }
}

// open/close
$('#btn-menu')?.addEventListener('click', openMenu)
$('#btn-menu-close')?.addEventListener('click', closeMenu)
$('#menuOverlay')?.addEventListener('click', function(e) {
  // Don't close if clicking on the menu panel or its children (links)
  const menuPanel = $('#menuPanel');
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
})
document.addEventListener('keydown', (e) => e.key === 'Escape' && closeMenu())

// --- Products submenu ---
const productsBtn = $('#btn-products')
const productsMenu = $('#submenu-products')
const caret = $('#products-caret')

productsBtn?.addEventListener('click', (e) => {
  e.stopPropagation(); // Prevent event bubbling
  const isHidden = productsMenu.classList.contains('hidden')
  productsMenu.classList.toggle('hidden')
  productsBtn.setAttribute('aria-expanded', String(isHidden))
  // rotate caret when open
  caret?.classList.toggle('rotate-180', isHidden)
})

