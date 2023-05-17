<form id="registrarse">
    <div class="form-group">
        <label for="nombre">Nombre</label>
        <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombreHelp" placeholder="Ingresar nombre">
        <small id="nombreHelp" class="form-text text-muted">Con este nombre se te conocera en este sitio web.</small>
        <p class="alert alert-danger alert-badge" style="display:none"></p>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Ingresar email">
        <small id="emailHelp" class="form-text text-muted">Nunca compartas el email con nadie.</small>
        <p class="alert alert-danger alert-badge" style="display:none"></p>
    </div>
    <div class="form-group">
        <label for="pass">Contraseña
        <input type="password" name="pass" class="form-control" id="pass" placeholder="Ingresa tu contraseña">
        <p class="alert alert-danger alert-badge" style="display:none"></p>
    </div>
    <div class="form-group">
        <label for="pass2">Confirmación de contraseña</label>
        <input type="password" name="pass2" class="form-control" id="pass2" placeholder="Vuelve a ingresar tu contraseña">
        <p class="alert alert-danger alert-badge" style="display:none"></p>
    </div>
    <input type="hidden" name="url" value="/proyecto_utn/registrarse">
    <button type="submit" class="btn btn-primary my-2">Registrarse</button>
</form>
<div id="errores"><p class="messageError" style="display:none"></p></div>
<p>Si tienes una cuenta <a href="inicio">ingresa</a></p>


<script src="vistas/js/registrarse.js"></script>
