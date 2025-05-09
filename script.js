document.addEventListener('keydown', function(event) {
    const fields = document.querySelectorAll('.nav-field');
    let currentIndex = -1;

    fields.forEach((field, index) => {
        if (field === document.activeElement) {
            currentIndex = index;
        }
    });

    if (currentIndex !== -1) {
        if (event.key === 'ArrowDown') {
            event.preventDefault();
            const nextIndex = (currentIndex + 1) % fields.length;
            fields[nextIndex].focus();
        } else if (event.key === 'ArrowUp') {
            event.preventDefault();
            const prevIndex = (currentIndex - 1 + fields.length) % fields.length;
            fields[prevIndex].focus();
        }
    }
});