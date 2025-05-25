
    const btnCommander = document.getElementById('btnCommander');
    const formCommande = document.getElementById('formCommande');

    btnCommander.addEventListener('click', () => {
        if (formCommande.style.display === 'none' || formCommande.style.display === '') {
            formCommande.style.display = 'block';
            btnCommander.scrollIntoView({behavior: 'smooth'});
        } else {
            formCommande.style.display = 'none';
        }
    });

