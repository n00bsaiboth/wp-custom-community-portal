"use strict";

const accordion = () => {

    const portal = document.getElementById("wccp-portal");

    portal.addEventListener("click", function (e) {

        const header = e.target.closest(".wccp-entry > header");

        if (!header) return;

        const article = header.parentElement;

        article.classList.toggle("is-open");

    });
};

export { accordion };