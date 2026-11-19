// Modale de suppression : avant son ouverture, on y copie le code et la désignation
// du produit, lus dans les attributs data-* du bouton "Supprimer" cliqué.
const modalSupprimer = document.getElementById('modalSupprimer');

if (modalSupprimer) {
    modalSupprimer.addEventListener('show.bs.modal', function (event) {
        const bouton = event.relatedTarget; // le bouton qui a ouvert la modale
        document.getElementById('modalCode').value = bouton.dataset.code;
        document.getElementById('modalDesignation').textContent = bouton.dataset.designation;
    });
}
