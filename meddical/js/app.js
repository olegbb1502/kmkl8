
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

const mobileCategoryToggle = () => {
    const button = document.querySelector('.block-title');

    if (button) {
        button.addEventListener('click', () => {
            button.classList.toggle('active');
            document.querySelector('.category-list').classList.toggle('hide');
        });
    }
}

const stickyElements = (positionY) => {
    const header = document.querySelector('.header-bottom');
    const moveToTop = document.querySelector('.move-to-top');

    if (positionY > 300) {
        header.classList.add('sticky');
        moveToTop.classList.add('sticky');
    } else {
        header.classList.remove('sticky');
        moveToTop.classList.remove('sticky');
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
    mobileCategoryToggle();

    const doc = document.documentElement;
    window.addEventListener("scroll", () => {
        const top = (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);
        stickyElements(top);
    }, { passive: true });

    const moveToTop = document.querySelector('.move-to-top');
    moveToTop.addEventListener('click', () => {
        window.scrollTo(0, 0);
    })
})();