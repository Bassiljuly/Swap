// CODE pour l'autocompletion dans la barre de recherche de la nav  -----------------------------

$(document).ready(function () {


    $("#myDataList").keyup(function () {

        let currentValue = $(this).val();

        if(currentValue.length == 0) {
            $("#datalistOptions").html("");
            return false;
        }

        $.ajax({
            url: "suggestion.php",
            type: "GET",
            dataType: "json",
            data: { myInputValue: currentValue }
        }).done(function (data) {

            let listOptions = "";
            $.each(data, function (index, value) {
                listOptions += "<option> " + value.description_courte + " </option>";
            });

            $("#datalistOptions").html(listOptions);
        });

    });

});