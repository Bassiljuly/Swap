

let modifierProfil = document.querySelector('#modifprofil');
let formProfil = document.querySelector('#formprofil');
let hidProfilForm = document.querySelector('#AnnulModif');

function showProfil() {

    formProfil.classList.add('show');

}

modifierProfil.addEventListener('click', showProfil);


function hiddFormProfil() {
    formProfil.classList.add('hidden');
}

hidProfilForm.addEventListener('click', hiddFormProfil);