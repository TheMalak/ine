<?php include('./header.php'); ?>

<?php $curp = $_GET['curp']; ?>

<div class="d-none" id="registerCurp"><?php echo $curp; ?></div>

<br><br>
<div class="container">
    <h1>Registro de ine para el curp <?php echo $curp; ?></h1>
    <br><br>
    <div id="form-list">
      <?php include('./form.php'); ?>
    </div>
</div>

<?php include('./footer.php'); ?>