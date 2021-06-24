// JQUERY CODE ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function(){
    const apiUrl = 'https://geo.api.gouv.fr/communes?codePostal=';
    const format = '&format=json';

    let cp = $('#cp'); let ville = $('#ville'); let errorMessage = $('#error-message');

    $(cp).on('blur', function(){
        let code = $(this).val();
       //console.log(code);
       let url = apiUrl+code+format;
       //console.log(url);

       fetch(url, {method: 'get'}).then(response => response.json()).then(results => {
        //console.log(results);
        $(ville).find('option').remove();
        if(results.length){
            $(errorMessage).text('').hide();
            $.each(results, function(key, value){
            console.log(value.nom);
            $(ville).append('<option value="'+value.nom+'">'+value.nom+'</option>');

            });
        }
        else{
            if($(cp).val()){
                console.log('Ce code postal n\'existe pas.');
                $(errorMessage).text('Aucune commune avec ce code postal.').show();
            }else{
                $(errorMessage).text('').hide();
            }
        }
       }).catch(err => {
           console.log(err);
           $(ville).find('option').remove();
       });
    });




    // COde barre de recherche
    // $("#myDataList").keyup(function () {

    //     let currentValue = $(this).val();

    //     if(currentValue.length == 0) {
    //         $("#datalistOptions").html("");
    //         return false;
    //     }

    //     $.ajax({
    //         url: "suggestions.php",
    //         type: "GET",
    //         dataType: "json",
    //         data: { myInputValue: currentValue }
    //     }).done(function (data) {

    //         let listOptions = "";
    //         $.each(data, function (index, value) {
    //             listOptions += "<option> " + value.title + " </option>";
    //         });

    //         $("#datalistOptions").html(listOptions);
    //     });

    // });

});
//END OF JQUERY CODE //////////////////////////////////////////////////////////////////////////////////////////////////////////////

// Code JS pour la lightbox 

let exampleModal = document.getElementById('exampleModal')
exampleModal.addEventListener('show.bs.modal', function (event) {
  // Button that triggered the modal
  let button = event.relatedTarget
  // Extract info from data-bs-* attributes
  let recipient = button.getAttribute('data-bs-whatever')
  // If necessary, you could initiate an AJAX request here
  // and then do the updating in a callback.
  //
  // Update the modal's content.
  let modalTitle = exampleModal.querySelector('.modal-title')
  let modalBodyInput = exampleModal.querySelector('.modal-body input')

  modalTitle.textContent = 'Nouveau message  à ' + recipient
  modalBodyInput.value = recipient
})