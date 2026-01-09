// Global fix to ensure all links work on first click
// This ensures no event listeners prevent link navigation

(function() {
    'use strict';
    
    // Function to fix all links on the page
    function fixAllLinks() {
        const links = document.querySelectorAll('a[href]');
        links.forEach(function(link) {
            // Skip special links
            if (link.href === '#' || 
                link.href.startsWith('javascript:') ||
                link.hasAttribute('wire:navigate') ||
                link.hasAttribute('wire:click') ||
                link.hasAttribute('data-link-fixed')) {
                return;
            }
            
            // Mark as fixed to avoid duplicate handlers
            link.setAttribute('data-link-fixed', 'true');
            
            // Add a click handler that ensures navigation happens
            link.addEventListener('click', function(e) {
                const href = this.getAttribute('href');
                
                // Only handle real navigation links
                if (href && href !== '#' && !href.startsWith('javascript:')) {
                    // If event was prevented by another handler, force navigation
                    if (e.defaultPrevented) {
                        // Check if it's a real navigation link (not a modal trigger, etc.)
                        if (!this.hasAttribute('data-no-navigate') && 
                            !this.onclick || 
                            (this.onclick && this.onclick.toString().indexOf('preventDefault') === -1)) {
                            // Force navigation
                            e.stopImmediatePropagation();
                            window.location.href = href;
                            return false;
                        }
                    }
                }
            }, true); // Use capture phase to run first
        });
    }
    
    // Fix links when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', fixAllLinks);
    } else {
        fixAllLinks();
    }
    
    // Fix dynamically added links (e.g., by Livewire)
    const observer = new MutationObserver(function() {
        fixAllLinks();
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
})();

