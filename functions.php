<?php

//conection database acta de nacimiento
define('SERVER_ACTA', 'localhost');
define('USER_ACTA', 'root');
define('PASSWORD_ACTA', 'root');
define('DB_NAME_ACTA', 'acta_nacimiento');

define('SERVER_INE', 'localhost');
define('USER_INE', 'root');
define('PASSWORD_INE', 'root');
define('DB_NAME_INE', 'ine');

function getConectionIne()
{
    $mysqli = new mysqli(
        SERVER_INE,
        USER_INE,
        PASSWORD_INE,
        DB_NAME_INE
    );

    if ($mysqli->connect_errno) {
        header('Location: error_db.php');
    } else {
        return $mysqli;
    }
}

function getConectionActa()
{
    $mysqli = new mysqli(
        SERVER_ACTA,
        USER_ACTA,
        PASSWORD_ACTA,
        DB_NAME_ACTA
    );

    if ($mysqli->connect_errno) {
        header('Location: error_db.php');
    } else {
        return $mysqli;
    }
}



function selectQuery($sql)
{
    $connection = getConectionActa(); //curp connection

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        return $result;
    } else {
        return 0;
    }
}

function selectQueryIne($sql)
{
    $connection = getConectionIne(); //curp connection

    $result = $connection->query($sql);

    if ($result->num_rows > 0) {
        return $result;
    } else {
        return 0;
    }
}

function searchPerson($curp)
{
    $query = selectQuery("SELECT * FROM `Persona` WHERE `curp` LIKE '%$curp%'");

    if ($query != 0) { ?>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col-2">Curp</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">FechaRegistro</th>
                    <th scope="col">Municipio</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Certificado</th>
                    <th scope="col">Libro</th>
                    <th scope="col">No Acta</th>
                    <th scope="col">Oficialía</th>
                    <th scope="col">Status</th>
                </tr>
        </thead>
    
    <?php while ($row = $query->fetch_assoc()) { 

            $person = getPerson($row['curp']);
            
            //revisamos si la persona es mayor de edad
            $dia = $person->birthday->day;
            $mes = $person->birthday->year;
            $ano = $person->birthday->month;

            $actual = 2022;


            echo '
            <tr>
                <th scope="row">' . $person->curp . '</th>
                <td>' . $person->name . ' ' . $person->lastName1 . ' ' . $person->lastName2 . '</td>
                <td>' . $person->registerDate->day . '-' . $person->registerDate->year . '-' . $person->registerDate->month . '</td>
                <td>' . $person->municipioName . '</td>
                <td>' . $person->estadoName . '</td>
                <td>' . $person->cerificationNumber . '</td>
                <td>' . $person->book . '</td>
                <td>' . $person->actaNumber . '</td>
                <td>' . $person->oficialia . '</td>';

            if(($actual - $ano) > 18) {
                
                //revisamos si la persona esta registrada o no en el ine
                $existence = selectQueryIne("SELECT `curp` FROM `ine` WHERE `curp` = '$person->curp'");                
                
                if($existence == 0) {
                    //la persona puede ser registrada mostrar el botón
                    echo '<td><a class="btn btn-primary" href="./register.php?curp='.$person->curp.'">Registrar</a></td>';
                } else {
                    echo '<td><a class="btn btn-primary" href="#">Visualizar</a></td>';
                }

            } else {
                echo '<td><button disabled class="btn btn-primary" href="#">No válido</button></td>';
            }
            echo '</tr>';
        } ?>


        <!-- colocamos el tbody -->
                </tbody>
            </table>


        <?php } else {
        echo 'no hay registros que cumplan tu busqueda.';
    }
}

function getPerson($curp)
{
    $checkCurp = "SELECT * FROM `DatosRegistro` WHERE `curp` = '$curp'";
    $datosRegistro = selectQuery($checkCurp);

    if ($datosRegistro != 0) {
        //el usuario existe dentro del sistema
        //obtenemos el registerdata;
        $datosPersona = selectQuery("SELECT * FROM `Persona` WHERE `curp` = '$curp'");

        //SELECT * FROM `Filial` WHERE `idPersona` = 29; filiales
        $filiales = [];
        while ($row = $datosPersona->fetch_assoc()) {
            $nombres = $row['nombres'];
            $apellidoPaterno = $row['apellidoPaterno'];
            $apellidoMaterno = $row['apellidoMaterno'];
            $sexoPersona = $row['sexo'];
            $orderdate = explode('-', $row['fechaNacimiento']);
            $birthdayMonth = $orderdate[0];
            $birthdayDay   = $orderdate[1];
            $birthdayYear  = $orderdate[2];
            $filial1 = $row['filial1'];
            $filial2 = $row['filial2'];
        }

        while ($row = $datosRegistro->fetch_assoc()) {
            $curp = $row['curp'];
            $numeroCertificado = $row['numeroCertificado'];
            $idEntidadRegistro = $row['idEntidadRegistro'];
            $numeroActa = $row['numeroActa'];
            $anoRegistro = $row['anoRegistro'];
            $libro = $row['libro'];
            $idMunicipioRegistro = $row['idMunicipioRegistro'];
            $oficialia = $row['oficialia'];
            $fechaRegistro = explode('-', $row['fechaRegistro']);
            $registerMonth = $fechaRegistro[0];
            $registerDay   = $fechaRegistro[1];
            $registerYear  = $fechaRegistro[2];
            $identificadorElectronico = $row['identificadorElectronico'];
        }

        //datos del filial
        $filial1 = selectQuery("SELECT * FROM `Filial` WHERE `idPersona` = $filial1");
        $filial2 = selectQuery("SELECT * FROM `Filial` WHERE `idPersona` = $filial2");

        while ($row = $filial1->fetch_assoc()) {
            $idPersonaF1 = $row['idPersona'];
            $nombresF1 = $row['nombres'];
            $apellidoPaternoF1 = $row['apellidoPaterno'];
            $apellidoMaternoF1 = $row['apellidoMaterno'];
            $sexoF1 = $row['sexo'];
            $curpF1 = $row['curp'];
            $idNacionalidadF1 = $row['idNacionalidad'];
        }

        $idPersonaF2 = '';
        $nombresF2 = '';
        $apellidoPaternoF2 = '';
        $apellidoMaternoF2 = '';
        $sexoF2 = '';
        $curpF2 = '';
        $idNacionalidadF2 = '';

        if ($filial2 != 0) {
            while ($row = $filial2->fetch_assoc()) {
                $idPersonaF2 = $row['idPersona'];
                $nombresF2 = $row['nombres'];
                $apellidoPaternoF2 = $row['apellidoPaterno'];
                $apellidoMaternoF2 = $row['apellidoMaterno'];
                $sexoF2 = $row['sexo'];
                $curpF2 = $row['curp'];
                $idNacionalidadF2 = $row['idNacionalidad'];
            }
        }



        return (object) array(
            'curp' => $curp,
            'name' => $nombres,
            'lastName1' => $apellidoPaterno,
            'lastName2' => $apellidoMaterno,
            'sex' => $sexoPersona,
            'state' => $idEntidadRegistro,
            'municipio' => $idMunicipioRegistro,
            'birthday' => (object) array(
                'day' => $birthdayDay,
                'month' => $birthdayMonth,
                'year' => $birthdayYear,
            ),
            'personFiliales' => (object) array(
                'person1' => (object) array(
                    'id' => $idPersonaF1,
                    'name' => $nombresF1,
                    'lastName1' => $apellidoPaternoF1,
                    'lastName2' => $apellidoMaternoF1,
                    'curp' => $curpF1,
                    'sex' => $sexoF1,
                    'country' => $idNacionalidadF1,
                ),
                'person2' => (object) array(
                    'id' => $idPersonaF2,
                    'name' => $nombresF2,
                    'lastName1' => $apellidoPaternoF2,
                    'lastName2' => $apellidoMaternoF2,
                    'curp' => $curpF2,
                    'sex' => $sexoF2,
                    'country' => $idNacionalidadF2,
                ),
            ),
            'cerificationNumber' => $numeroCertificado,
            'registerDate' => (object) array(
                'day' => $registerDay,
                'month' => $registerMonth,
                'year' => $registerYear,
            ),
            'anoRegistro' => $anoRegistro,
            'book' => $libro,
            'actaNumber' => $numeroActa,
            'oficialia' => $oficialia,
            'electronicIdentiier' => $identificadorElectronico,
            'municipioName' => getMunicipioName($idMunicipioRegistro),
            'estadoName' => getEstadoName($idEntidadRegistro)
        );
    } else {
        header('Location: no_curp.php');
    }
}

function getMunicipioName($id)
{
    $get = selectQuery("SELECT `nombre` FROM `Municipio` WHERE `idMunicipio` = $id");
    $name = '';
    while ($row = $get->fetch_assoc()) {
        $name = $row['nombre'];
    }
    return $name;
}

function getEstadoName($id)
{
    $get = selectQuery("SELECT `nombre` FROM `Estado` WHERE `idEstado` = $id");
    $name = '';
    while ($row = $get->fetch_assoc()) {
        $name = $row['nombre'];
    }
    return $name;
}


function registerNewRegisterData($ObjData)
{
    echo $ObjData;
}