<h1>Actualizar información</h1>
<form id="registrarse">
    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" value="<?= $data["nombre"] ?>" aria-describedby="nombreHelp" placeholder="Ingresar nombre">
        <small id="nombreHelp" class="form-text text-muted">Con este nombre se te conocera en este sitio web.</small>
        <p class="alert alert-badge" style="display:none"></p>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $data["email"] ?>" aria-describedby="emailHelp" placeholder="Ingresar email">
        <small id="emailHelp" class="form-text text-muted">Nunca compartas el email con nadie.</small>
        <p class="alert alert-badge" style="display:none"></p>
    </div>
    <div class="form-group">
        <label for="pass">Contraseña
        <input type="password" name="pass" class="form-control" id="pass" placeholder="Ingresa tu contraseña">
        <p class="alert alert-badge" style="display:none"></p>
    </div>

    <input type="hidden" name="url" value="/proyecto_utn/actualizar">
    <input type="hidden" name="ID" value="<?= $data["ID"] ?>">
    <button type="submit" class="btn btn-primary my-2">Actualizar</button>
    <p class="messageError"></p>
</form>
<div id="errores"><p class="messageError"></p></div>



<script src="vistas/js/actualizar.js"></script>