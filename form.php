<form id="newRegister">
      <div class="row mt-4">
        <h4>Datos generales</h4>
        <hr>
        <div class="col">
          <label class="mb-2">Curp <span class="required">*</span></label>
          <input id="curp" type="text" class="form-control" placeholder="curp" required>
        </div>
      </div>
      <div class="row mt-4">
        <div class="col">
          <label class="mb-2">Nombre's <span class="required">*</span></label>
          <input id="name" type="text" class="form-control" placeholder="Last name">
        </div>
        <div class="col">
          <label class="mb-2">Apellido Paterno <span class="required">*</span></label>
          <input id="lastName1" type="text" class="form-control" placeholder="Apellido Paterno" required>
        </div>
        <div class="col">
          <label class="mb-2">Apellido Materno <span class="required">*</span></label>
          <input id="lastName2" type="text" class="form-control" placeholder="Apellido materno" required>
        </div>
        <div class="col">
          <label class="mb-2">Sexo <span class="required">*</span></label>
          <select class="form-control" id="registersexo" required>
            <option value="1">Masculino</option>
            <option value="0">Femenino</option>
          </select>
        </div>
      </div>

      <div class="row mt-4">
        <h4>Fecha de nacimiento</h4>
        <hr>
        <div class="col">
          <label class="mb-2">Día <span class="required">*</span></label>
          <input id="birthDayDay" type="number" class="form-control" placeholder="Día" required>
        </div>
        <div class="col">
          <label class="mb-2">Mes <span class="required">*</span></label>
          <input id="birthDayMonth" type="number" class="form-control" placeholder="Mes" required>
        </div>
        <div class="col">
          <label class="mb-2">Año <span class="required">*</span></label>
          <input id="birthDayYear" type="number" class="form-control" placeholder="Año" required>
        </div>
      </div>

      <div class="row mt-4">
      <h4>Datos ine</h4>
        <hr>
      <div class="col">
          <label class="mb-2">Clave Elector <span class="required">*</span></label>
          <input id="claveElector" type="text" class="form-control" placeholder="Clave Elector" required>
        </div>
      </div>

      <div class="row mt-4">
      <div class="col">
          <label class="mb-2">Sección <span class="required">*</span></label>
          <input id="section" type="number" class="form-control" placeholder="Sección" required>
        </div>
      </div>


      <div class="row mt-4">
      <h4>Ubicación</h4>
        <hr>
      <div class="col">
          <label class="mb-2">Calle <span class="required">*</span></label>
          <input id="calle" type="text" class="form-control" placeholder="Calle" required>
        </div>
        <div class="col">
          <label class="mb-2">Número Exterior <span class="required">*</span></label>
          <input id="numExterior" type="text" class="form-control" placeholder="Número Exterior" required>
        </div>
        <div class="col">
          <label class="mb-2">Número Interior <span class="required">*</span></label>
          <input id="numInterior" type="text" class="form-control" placeholder="Número Interior" required>
        </div>
      </div>


      <div class="row mt-4">
      <div class="col">
          <label class="mb-2">Colonia <span class="required">*</span></label>
          <input id="colonia" type="text" class="form-control" placeholder="Colonia" required>
        </div>
        <div class="col">
          <label class="mb-2">Código Postal <span class="required">*</span></label>
          <input id="codigoPostal" type="number" class="form-control" placeholder="Código Postal" required>
        </div>
      </div>

      <div class="row mt-4">
      <div class="col">
          <label class="mb-2">Estado <span class="required">*</span></label>
          <input id="estado" type="text" class="form-control" placeholder="estado" required>
        </div>
        <div class="col">
          <label class="mb-2">Municipio <span class="required">*</span></label>
          <input id="municipio" type="text" class="form-control" placeholder="Municipio" required>
        </div>

      </div>
  
      <br><br>
      <div class="d-flex">
        <button type="submit" class="btn btn-primary m-auto d-flex">Enviar</button>
      </div>
      <br><br>

      </div>

    </form>