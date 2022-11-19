//instant execute
$(document).ready(function () {
    putDataInFields();
});


// funcion de busqueda que solicita las personas que estan registradas en el acta de nacimiento
$('#inputSearch').on('input', function () {
    setTimeout(function () {

        curp = $('#inputSearch').val();

        $.ajax({
            url: 'search_curp_function.php',
            type: 'POST',
            data: {
                curp: curp,
            },
            success: function (resultado) {
                $('#searchResults').html(resultado);
            }

        });
    }, 1000);
});



function putDataInFields() {
    curpVal = $('#registerCurp').text(); // curp actual

    if ($("#form-list")[0]) { //run only in list

        // $('#buttonBack').removeClass('d-none');
        // $('#buttonDelete').removeClass('d-none');
        // $('input').prop("disabled", true);
        // $('select').prop("disabled", true);
        // $('button[type="submit"]').addClass('d-none');
        // //buttonDelete

        if (curp != undefined) { //run if curp is declarated
            $.ajax({
                url: 'get_list_user.php',
                type: 'POST',
                data: {
                    curp: curpVal,
                },
                success: function (resultado) {

                    console.log("he llegado aqui");

                    parse = $.parseJSON(resultado);
                    console.log(parse);

                    // $('#registerState').val(parse.state);
                    // $('#registerMunicipio').remove();
                    // $('#textMunicipio').removeClass('d-none');
                    // $('#textMunicipio').val(parse.municipioName);
                    $('#curp').val(parse.curp).prop("disabled", true);;
                    $('#name').val(parse.name).prop("disabled", true);;
                    $('#lastName1').val(parse.lastName1).prop("disabled", true);;
                    $('#lastName2').val(parse.lastName2).prop("disabled", true);;
                    $('#registersexo').val(parse.sex).prop("disabled", true);;

                    // $("#registerMunicipio").val(parse.municipio);
                    $('#birthDayDay').val(parse.birthday.day).prop("disabled", true);;
                    $('#birthDayMonth').val(parse.birthday.year).prop("disabled", true);;
                    $('#birthDayYear').val(parse.birthday.month).prop("disabled", true);;


                    // $('#certificateNumber').val(parse.cerificationNumber);
                    // $('#registerDate').val(parse.anoRegistro);
                    // $('#book').val(parse.book);
                    // $('#actaNumber').val(parse.actaNumber);
                    // $('#oficialia').val(parse.oficialia);
                    // $('#identifierElectronic').val(parse.electronicIdentiier);
                    // $('#registerDay').val(parse.registerDate.day);
                    // $('#registerMonth').val(parse.registerDate.month);
                    // $('#registerYear').val(parse.registerDate.year);

                }
            });
        }
    }
}

$("#newRegister").on("submit", function (e) {

    //get all values in form
    let jsonObject = new Array();

    jsonObject.push({
        curp: $('#curp').val(),
        name: $('#name').val(),
        lastName1: $('#lastName1').val(),
        lastName2: $('#lastName2').val(),
        sex: $('#registersexo').val(),
        state: $('#estado').val(),
        municipio: $('#municipio').val(),
        birthday: {
            day: $('#birthDayDay').val(),
            month: $('#birthDayMonth').val(),
            year: $('#birthDayYear').val()
        }
    });

    //revision de que todo este completado.
    $.ajax({
        url: 'submit_register.php',
        type: 'POST',
        data: {
            json: jsonObject,
        },
        beforeSend: function () {
            //$('#loadingModal').modal('show');
            // $('#loadingModal').modal({ backdrop: 'static', keyboard: false, show: true });
            // $('#loadingModal').modal('toggle');
        },
        success: function (resultado) {
            parse = $.parseJSON(resultado);
            console.log(parse);
            // $('#loadingModal').modal('toggle');
            // $('#viewDataInserted').prop("href", "./view_user.php?curp=" + jsonObject[0].curp + "");
            // $('#completedModal').modal('show');
            // clearAllInputs();
        }

    });

    e.preventDefault();
});
