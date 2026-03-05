"use strict";

const validation = () => {

    const MAX_FILE_SIZE = 5 * 1024 * 1024; // 5MB

    document.querySelectorAll('.wccp-form-post, .wccp-form-reply').forEach(function (formWrapper) {

        const fileInput = formWrapper.querySelector('input[type="file"]');
        if (!fileInput) return;

        const form = fileInput.closest('form');
        const submitButton = form.querySelector('button[type="submit"]');
        const notificationBox = formWrapper.querySelector('.wccp-notifications');

        const validateFile = () => {

            // Reset state
            notificationBox.innerHTML = '';
            notificationBox.style.display = 'none';
            submitButton.disabled = false;

            const file = fileInput.files[0];
            if (!file) return true; // no file is allowed

            let errors = [];

            if (file.type !== 'application/pdf') {
                errors.push('Invalid file type. Only PDF files are allowed.');
            }

            if (file.size > MAX_FILE_SIZE) {
                errors.push('File is too large. Maximum size is 5MB.');
            }

            if (errors.length > 0) {

                submitButton.disabled = true;
                notificationBox.style.display = 'block';

                errors.forEach(function (error) {
                    const p = document.createElement('p');
                    p.classList.add('wccp-notification');
                    p.textContent = error;
                    notificationBox.appendChild(p);
                });

                return false;
            }

            return true;
        };

        fileInput.addEventListener('change', validateFile);

        form.addEventListener('submit', function (e) {
            if (!validateFile()) {
                e.preventDefault();
            }
        });

    });

};

export { validation };