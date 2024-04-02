document.getElementById('filter-patients').addEventListener('input', function() {
    let filter = this.value.toLowerCase();
    let lines = document.querySelectorAll('.patients-table tbody tr');

    lines.forEach((line) => {
        let nome = line.querySelector('td:first-child').textContent.toLowerCase();
        if (nome.includes(filter)) {
            line.style.display = '';
        } else {
            line.style.display = 'none';
        }
    });
});
