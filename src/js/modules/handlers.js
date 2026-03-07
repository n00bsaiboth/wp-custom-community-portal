"use strict";

const handleUpdatePost = () => { 

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

            const shouldOpen = form.hidden;

            form.hidden = !shouldOpen;

            toggle.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
            toggle.textContent = shouldOpen ? 'Cancel' : 'Update';
        });
    });
};

export { handleUpdatePost };