"use strict";

// Importing the main SCSS file to be processed by Webpack
import '../scss/style.scss';

// Importing SVG sprite (if needed for inlining or other purposes)
import sprite from '../images/sprite.svg';

// Importing JavaScript modules for accordion functionality and form validation
import { accordion } from './modules/accordion.js';
import { validation } from './modules/validation.js';
import { handleUpdatePost } from './modules/handlers.js';

document.addEventListener('DOMContentLoaded', () => {
    accordion();
    validation();
    handleUpdatePost();
});

