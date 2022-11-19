<?php include('./header.php'); ?>

<?php
$claveElector = $_GET['curp'];
?>

<div class="d-none" id="registerClaveElector"><?php echo $claveElector; ?></div>

<div class="container mt-5">
  <div class="row">
    <div class="col-md-12">
      <h1>Ine con clave <?php echo $claveElector; ?></h1>
    </div>

    <div id="form-list">
      <?php include('./form.php'); ?>
    </div>

    <div class="options-in-view-person d-flex justify-content-center">
      <button style="margin-right: 20px;" id="buttonModify" class="btn btn-warning mr-3">Modificar</button>
      <button style="margin-right: 20px;" id="buttonUpdate" class="d-none btn btn-success mr-3">Actualizar
        Datos</button>
      <a href="./" id="buttonBack" class="btn btn-primary">Regresar a lista</a>
    </div>
    <br><br>
    <br><br>


    <?php include('./footer.php'); ?>