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


function listPersons()
{
    $query = selectQuery("SELECT * FROM `Persona`");

    if ($query != 0) { ?>


<table class="table">
  <thead>
    <tr>
      <th scope="col-2">Curp</th>
      <th scope="col">Nombre</th>
      <th scope="col">Clave de elector</th>
      <th scope="col">Año de Registro</th>
      <th scope="col">Emisión</th>
      <th scope="col">Vigencia</th>
      <th scope="col">Sección</th>
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
                <td>' . $person->name . ' ' . $person->lastName1 . ' ' . $person->lastName2 . '</td>';

                if (($actual - $ano) > 18) {

                    $personIne = getPersonIne($row['curp']);

                    //revisamos si la persona esta registrada o no en el ine
                    $existence = selectQueryIne("SELECT `curp` FROM `ine` WHERE `curp` = '$person->curp'");

                    if ($existence == 0) {
                        //la persona aun no cuenta con una ine pero puede tenerla
                        echo '<th scope="row">-</th>';
                        echo '<th scope="row">-</th>';
                        echo '<th scope="row">-</th>';
                        echo '<th scope="row">-</th>';
                        echo '<th scope="row">-</th>';
                        //la persona puede ser registrada mostrar el botón
                        echo '<td><a class="btn btn-primary" href="./register.php?curp=' . $person->curp . '">Registrar</a></td>';
                    } else {
                        echo '<th scope="row">' . $personIne->claveElector . '</th>';
                        echo '<th scope="row">' . $personIne->anoRegistro . '</th>';
                        echo '<th scope="row">' . $personIne->emision . '</th>';
                        echo '<th scope="row">' . $personIne->vigencia . '</th>';
                        echo '<th scope="row">' . $personIne->seccion . '</th>';
                        echo '<td><a class="btn btn-primary" href="./view_ine.php?curp=' . $personIne->claveElector . '">Visualizar</a></td>';
                    }
                } else {
                    echo '<th scope="row">-</th>';
                    echo '<th scope="row">-</th>';
                    echo '<th scope="row">-</th>';
                    echo '<th scope="row">-</th>';
                    echo '<th scope="row">-</th>';
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


function searchPerson($curp)
{
    $query = selectQuery("SELECT * FROM `Persona` WHERE `curp` LIKE '%$curp%'");

    if ($query != 0) { ?>


<table class="table">
  <thead>
    <tr>
      <th scope="col-2">Curp</th>
      <th scope="col">Nombre</th>
      <th scope="col">Clave de elector</th>
      <th scope="col">Año de Registro</th>
      <th scope="col">Emisión</th>
      <th scope="col">Vigencia</th>
      <th scope="col">Sección</th>
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
                <td>' . $person->name . ' ' . $person->lastName1 . ' ' . $person->lastName2 . '</td>';

                if (($actual - $ano) > 18) {

                    $personIne = getPersonIne($row['curp']);

                    //revisamos si la persona esta registrada o no en el ine
                    $existence = selectQueryIne("SELECT `curp` FROM `ine` WHERE `curp` = '$person->curp'");

                    if ($existence == 0) {
                        //la persona aun no cuenta con una ine pero puede tenerla
                        echo '<th scope="row">-</th>';
                        echo '<th scope="row">-</th>';
                        echo '<th scope="row">-</th>';
                        echo '<th scope="row">-</th>';
                        echo '<th scope="row">-</th>';
                        //la persona puede ser registrada mostrar el botón
                        echo '<td><a class="btn btn-primary" href="./register.php?curp=' . $person->curp . '">Registrar</a></td>';
                    } else {
                        echo '<th scope="row">' . $personIne->claveElector . '</th>';
                        echo '<th scope="row">' . $personIne->anoRegistro . '</th>';
                        echo '<th scope="row">' . $personIne->emision . '</th>';
                        echo '<th scope="row">' . $personIne->vigencia . '</th>';
                        echo '<th scope="row">' . $personIne->seccion . '</th>';
                        echo '<td><a class="btn btn-primary" href="./view_ine.php?curp=' . $personIne->claveElector . '">Visualizar</a></td>';
                    }
                } else {
                    echo '<th scope="row">-</th>';
                    echo '<th scope="row">-</th>';
                    echo '<th scope="row">-</th>';
                    echo '<th scope="row">-</th>';
                    echo '<th scope="row">-</th>';
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
    //create date
    $registerYear = strval($ObjData->birthday['year']);
    $registerMonth = strval($ObjData->birthday['month']);
    $registerDay = strval($ObjData->birthday['day']);

    $birthday = "$registerYear-" . "$registerDay-" . "$registerMonth";

    $curp = strval($ObjData->curp);
    $name = strval($ObjData->name);
    $lastName1 = strval($ObjData->lastName1);
    $lastName2 = strval($ObjData->lastName2);
    $sex = intval($ObjData->sex);

    //datos de elector
    $claveElector = strval($ObjData->claveElector);
    $seccion = intval($ObjData->seccion);

    //direccion
    $calle = strval($ObjData->address['calle']);
    $numExterior = strval($ObjData->address['numExterior']);
    $numInterior = !empty($ObjData->address['numInterior']) ? strval($ObjData->address['numInterior']) : "NULL";
    $colonia = strval($ObjData->address['colonia']);
    $codigoPostal = intval($ObjData->address['codigoPostal']);
    $estado = strval($ObjData->address['estado']);
    $municipio = strval($ObjData->address['municipio']);

    //inicio fin
    $emision = 2022;
    $vigencia = 2022 + 10;
    $anoRegistro = $emision;

    $datosRegistro = "INSERT INTO `ine`(`curp`, `claveElector`, `seccion`, `vigencia`, `emision`, `sexo`, `nombre`, `apellidoPaterno`, `apellidoMaterno`, `fechaNacimiento`, `añoRegistro`, `calle`, `numeroExterior`, `numeroInterior`, `colonia`, `Municipio`, `Estado`, `codigoPostal`) VALUES
    (
        '$curp',
        '$claveElector',
        $seccion,
        $vigencia,
        $emision,
        $sex,
        '$name',
        '$lastName1',
        '$lastName2',
        '$birthday',
         $anoRegistro,
        '$calle',
        '$numExterior',
        '$numInterior',
        '$colonia',
        '$municipio',
        '$estado',
        '$codigoPostal'
    )";

    $insert = insertDatWithReturnTrue($datosRegistro);

    if ($insert == true) {
        return 1;
    } else {
        return 0;
    }
}

function insertDatWithReturnTrue($sql)
{
    $connection = getConectionIne();

    if ($connection->query($sql) === TRUE) {
        return true;
    } else {
        return $connection->error;
    }
}


function getPersonIne($curp)
{
    $checkClaveElector = "SELECT * FROM `ine` WHERE `curp` = '$curp'";

    $datosRegistro = selectQueryIne($checkClaveElector);

    if ($datosRegistro != 0) {

        while ($row = $datosRegistro->fetch_assoc()) {

            //fecha de nacimiento
            $fechaRegistro = explode('-', $row['fechaNacimiento']);
            $year = $fechaRegistro[0];
            $month   = $fechaRegistro[1];
            $day  = $fechaRegistro[2];

            $birthday = "$year-" . "$month-" . "$day";

            $curp = $row['nombre'];
            $name = $row['nombre'];
            $lastName1 = $row['apellidoMaterno'];
            $lastName2 = $row['apellidoPaterno'];
            $sex = $row['sexo'];

            //datos de elector
            $claveElector = $row['claveElector'];
            $seccion = $row['seccion'];

            //direccion
            $calle = $row['calle'];
            $numExterior = $row['numeroExterior'];
            $numInterior = $row['numeroInterior'];
            $colonia = $row['colonia'];
            $codigoPostal = $row['codigoPostal'];
            $estado = $row['Estado'];
            $municipio = $row['Municipio'];
            $anoRegistro = $row['añoRegistro'];
            $emision = $row['emision'];
            $vigencia = $row['vigencia'];


            return (object) array(
                'curp' => $curp,
                'name' => $name,
                'lastName1' => $lastName1,
                'lastName2' => $lastName2,
                'sex' => $sex,
                'birthday' => (object) array(
                    'day' => $day,
                    'month' => $month,
                    'year' => $year,
                ),
                'direccion' => (object) array(
                    'calle' => $calle,
                    'numeroExterior' => $numExterior,
                    'numeroInterior' => $numInterior,
                    'colonia' => $colonia,
                    'codigoPostal' => $codigoPostal,
                    'estado' => $estado,
                    'municipio' => $municipio
                ),
                'claveElector' => $claveElector,
                'seccion' => $seccion,
                'anoRegistro' => $anoRegistro,
                'emision' => $emision,
                'vigencia' => $vigencia
            );
        }
    } else {
        return 0;
    }
}

function getPersonclaveElector($curp)
{
    $checkClaveElector = "SELECT * FROM `ine` WHERE `claveElector` = '$curp'";

    $datosRegistro = selectQueryIne($checkClaveElector);

    if ($datosRegistro != 0) {

        while ($row = $datosRegistro->fetch_assoc()) {

            //fecha de nacimiento
            $fechaRegistro = explode('-', $row['fechaNacimiento']);
            $year = $fechaRegistro[0];
            $month   = $fechaRegistro[1];
            $day  = $fechaRegistro[2];

            $birthday = "$year-" . "$month-" . "$day";

            $curp = $row['curp'];
            $name = $row['nombre'];
            $lastName1 = $row['apellidoMaterno'];
            $lastName2 = $row['apellidoPaterno'];
            $sex = $row['sexo'];

            //datos de elector
            $claveElector = $row['claveElector'];
            $seccion = $row['seccion'];

            //direccion
            $calle = $row['calle'];
            $numExterior = $row['numeroExterior'];
            $numInterior = $row['numeroInterior'];
            $colonia = $row['colonia'];
            $codigoPostal = $row['codigoPostal'];
            $estado = $row['Estado'];
            $municipio = $row['Municipio'];
            $anoRegistro = $row['añoRegistro'];
            $emision = $row['emision'];
            $vigencia = $row['vigencia'];


            return (object) array(
                'curp' => $curp,
                'name' => $name,
                'lastName1' => $lastName1,
                'lastName2' => $lastName2,
                'sex' => $sex,
                'birthday' => (object) array(
                    'day' => $day,
                    'month' => $month,
                    'year' => $year,
                ),
                'direccion' => (object) array(
                    'calle' => $calle,
                    'numeroExterior' => $numExterior,
                    'numeroInterior' => $numInterior,
                    'colonia' => $colonia,
                    'codigoPostal' => $codigoPostal,
                    'estado' => $estado,
                    'municipio' => $municipio
                ),
                'claveElector' => $claveElector,
                'seccion' => $seccion,
                'anoRegistro' => $anoRegistro,
                'emision' => $emision,
                'vigencia' => $vigencia
            );
        }
    } else {
        return 0;
    }
}

function updateRegisterData($ObjData)
{
    //datos de elector
    $claveElector = strval($ObjData->claveElector);
    $seccion = intval($ObjData->seccion);

    //direccion
    $calle = strval($ObjData->address['calle']);
    $numExterior = strval($ObjData->address['numExterior']);
    $numInterior = !empty($ObjData->address['numInterior']) ? strval($ObjData->address['numInterior']) : "NULL";
    $colonia = strval($ObjData->address['colonia']);
    $codigoPostal = intval($ObjData->address['codigoPostal']);
    $estado = strval($ObjData->address['estado']);
    $municipio = strval($ObjData->address['municipio']);


    $datosRegistro = "UPDATE `ine` SET
    `seccion`='$seccion',
    `calle`='$calle',
    `numeroExterior`='$numExterior',
    `numeroInterior`='$numInterior',
    `colonia`='$colonia',
    `Municipio`='$municipio',
    `Estado`='$estado',
    `codigoPostal`='$codigoPostal'
    WHERE `claveElector` = '$claveElector';";

    $insert = insertDatWithReturnTrue($datosRegistro);

    if ($insert == true) {
        return 1;
    } else {
        return 0;
    }
}