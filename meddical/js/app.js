// setup icons
const setupIcon = async (el) => {
    const src = el.getAttribute('data-icon');
    const container = el.querySelector('.icon-place');
    fetch(src, {
        method: 'GET',
        headers: {
            "Content-Type": "image/svg+xml"
        }
    })
        .then(res => res.text())
        .then(data => {
            container.innerHTML = data;
        })
        .catch(err => {console.log(err);})
}

//mobile menu
const mobileMenuToggle = () => {
    const button = document.querySelector('.mobile-button');

    if (button) {
        button.addEventListener('click', () => {
            button.classList.toggle('active');
            document.querySelector('.header-top').classList.toggle('hide');
            document.querySelector('.main-nav').classList.toggle('open');
        });
    }
}

// Execute when JS will loaded
(() => {
    const promises = [];
    document.querySelectorAll('[data-icon]').forEach(el => {
        promises.push(setupIcon(el))
    })

    Promise.all(promises);

    mobileMenuToggle();
})();