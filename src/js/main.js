"use strict";

// Importing the main SCSS file to be processed by Webpack
import '../scss/style.scss';

// Importing SVG sprite (if needed for inlining or other purposes)
import sprite from '../images/sprite.svg';
console.log(sprite);


import { accordion } from './modules/accordion.js';
import { validation } from './modules/validation.js';

document.addEventListener('DOMContentLoaded', () => {
    accordion();
    validation();
});

// const HelloWebpack = (name) => {
//     console.log(`Hello, ${name}!`);
// }

// HelloWebpack('WP Custom Community Portal');
