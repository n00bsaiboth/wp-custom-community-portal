"use strict";

const handleUpdatePost = () => { 
    console.log('Initializing update post handlers...');
    const toggles = document.querySelectorAll('[data-wccp-edit-toggle]');
    
    if (!toggles.length) {
        return;
    }

    toggles.forEach(toggle => {
        toggle.addEventListener('click', () => {
            const container = toggle.closest('[data-wccp-edit-container]');

            if (!container) {
                return;
            }

            const form = container.querySelector('[data-wccp-edit-form]');

            if (!form) {
                return;
            }

            const shouldOpen = form.ariaHidden;
            form.hidden = !shouldOpen;

            toggle.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
            toggle.textContent = shouldOpen ? 'Cancel' : 'Update';
        });
    });
};

export { handleUpdatePost };