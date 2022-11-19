//instant execute
$(document).ready(function () {
    putDataInFields();
    putDataInFieldsIne();
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

                    parse = $.parseJSON(resultado);
                    console.log(parse);

                    // $('#registerState').val(parse.state);
                    // $('#registerMunicipio').remove();
                    // $('#textMunicipio').removeClass('d-none');
                    // $('#textMunicipio').val(parse.municipioName);
                    $('#curp').val(parse.curp).prop("disabled", true);
                    $('#name').val(parse.name).prop("disabled", true);
                    $('#lastName1').val(parse.lastName1).prop("disabled", true);
                    $('#lastName2').val(parse.lastName2).prop("disabled", true);
                    $('#registersexo').val(parse.sex).prop("disabled", true);

                    // $("#registerMunicipio").val(parse.municipio);
                    $('#birthDayDay').val(parse.birthday.day).prop("disabled", true);
                    $('#birthDayMonth').val(parse.birthday.year).prop("disabled", true);
                    $('#birthDayYear').val(parse.birthday.month).prop("disabled", true);


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



function putDataInFieldsIne() {
    claveElector = $('#registerClaveElector').text(); // curp actual

    if ($("#form-list")[0]) { //run only in list

        // $('#buttonBack').removeClass('d-none');
        // $('#buttonDelete').removeClass('d-none');
        // $('input').prop("disabled", true);
        // $('select').prop("disabled", true);
        // 
        // //buttonDelete

        if ($('#registerClaveElector')[0]) {
            $('button[type="submit"]').addClass('d-none');
        }

        if (curp != undefined) { //run if curp is declarated
            $.ajax({
                url: 'get_list_ine.php',
                type: 'POST',
                data: {
                    claveElector: claveElector,
                },
                success: function (resultado) {

                    parse = $.parseJSON(resultado);
                    console.log(parse);

                    $('#curp').val(parse.curp).prop("disabled", true);
                    $('#name').val(parse.name).prop("disabled", true);
                    $('#lastName1').val(parse.lastName1).prop("disabled", true);
                    $('#lastName2').val(parse.lastName2).prop("disabled", true);
                    $('#registersexo').val(parse.sex).prop("disabled", true);

                    $('#birthDayDay').val(parse.birthday.day).prop("disabled", true);
                    $('#birthDayMonth').val(parse.birthday.month).prop("disabled", true);
                    $('#birthDayYear').val(parse.birthday.year).prop("disabled", true);

                    $('#claveElector').val(parse.claveElector).prop("disabled", true);
                    $('#section').val(parse.seccion).prop("disabled", true);

                    $('#calle').val(parse.direccion.calle).prop("disabled", true);
                    $('#codigoPostal').val(parse.direccion.codigoPostal).prop("disabled", true);
                    $('#colonia').val(parse.direccion.colonia).prop("disabled", true);
                    $('#estado').val(parse.direccion.estado).prop("disabled", true);
                    $('#municipio').val(parse.direccion.municipio).prop("disabled", true);
                    $('#numExterior').val(parse.direccion.numeroExterior).prop("disabled", true);
                    $('#numInterior').val(parse.direccion.numeroInterior).prop("disabled", true);

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
        claveElector: $('#claveElector').val(),
        seccion: $('#section').val(),
        address: {
            calle: $('#calle').val(),
            numExterior: $('#numExterior').val(),
            numInterior: $('#numInterior').val(),
            colonia: $('#colonia').val(),
            codigoPostal: $('#codigoPostal').val(),
            estado: $('#estado').val(),
            municipio: $('#municipio').val(),
        },
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
            // parse = $.parseJSON(resultado);
            // console.log(parse);
            // $('#loadingModal').modal('toggle');
            // $('#viewDataInserted').prop("href", "./view_user.php?curp=" + jsonObject[0].curp + "");
            // $('#completedModal').modal('show');
            // clearAllInputs();
            console.log(resultado);
        }

    });

    e.preventDefault();
});


$("#buttonModify").on("click", function (e) {
    //vamos a desbloquar los campos
    onOffElements(false);
    $(this).addClass('d-none');
    $('#buttonUpdate').removeClass('d-none');
});

$("#buttonUpdate").on("click", function (e) {

    if (checkEmpty()) {
        //bloqueamos una vez mas los campos

        let jsonObject = new Array();

        jsonObject.push({
            curp: $('#curp').val(),
            name: $('#name').val(),
            lastName1: $('#lastName1').val(),
            lastName2: $('#lastName2').val(),
            sex: $('#registersexo').val(),
            state: $('#estado').val(),
            municipio: $('#municipio').val(),
            claveElector: $('#claveElector').val(),
            seccion: $('#section').val(),
            address: {
                calle: $('#calle').val(),
                numExterior: $('#numExterior').val(),
                numInterior: $('#numInterior').val(),
                colonia: $('#colonia').val(),
                codigoPostal: $('#codigoPostal').val(),
                estado: $('#estado').val(),
                municipio: $('#municipio').val(),
            },
            birthday: {
                day: $('#birthDayDay').val(),
                month: $('#birthDayMonth').val(),
                year: $('#birthDayYear').val()
            }
        });

        $.ajax({
            url: 'update_register.php',
            type: 'POST',
            data: {
                json: jsonObject,
            },
            success: function (resultado) {
                onOffElements(true);
                $('#buttonUpdate').addClass('d-none');
                $('#buttonModify').removeClass('d-none');
                alert("Datos actualizados con éxito");
            }
        });
    } else {
        alert("Revise uno o varios campos, solo el número interior puede enviarse vacío");
    }

});

function onOffElements(value) {
    $('#section').prop("disabled", value);
    $('#calle').prop("disabled", value);
    $('#codigoPostal').prop("disabled", value);
    $('#colonia').prop("disabled", value);
    $('#estado').prop("disabled", value);
    $('#municipio').prop("disabled", value);
    $('#numExterior').prop("disabled", value);
    $('#numInterior').prop("disabled", value);
}

function checkEmpty() {
    if (
        $('#section').val() != '' &&
        $('#calle').val() != '' &&
        $('#codigoPostal').val() != '' &&
        $('#colonia').val() != '' &&
        $('#estado').val() != '' &&
        $('#municipio').val() != '' &&
        $('#numExterior').val() != ''
    ) {
        return true;
        //alert("Revise uno o varios campos, solo el número interior puede enviarse vacío");
    } else {
        return false;
        //almacenamos la data
        //alert("Datos actualizados con éxito");
    }
}