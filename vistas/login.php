<div class="container">
    <div class="row">
        <div class="col-12">
        <form id="login">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" aria-describedby="emailHelp" required placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">Nunca compartas tu email con nadie.</small>
                <p class="alert alert-danger alert-badge" style="display:none"></p>
            </div>
            <div class="form-group">
                <label for="pass">Contraseña</label>
                <input type="password" name="pass" class="form-control" required id="pass" placeholder="Ingresa tu contraseña">
                <p class="alert alert-danger alert-badge" style="display:none"></p>
            </div>
            <button type="submit" class="btn btn-primary my-3">Ingresar</button>
            <input type="hidden" name="url" value="login">
            </form>

            <p>Si aun no tienes cuenta <a href="registrarse">registrate</a></p>
        </div>
    </div>
</div>
<div id="errores" class=""><p class="messageError alert alert-danger"  style="display:none;"></p></div>
<script src="vistas/js/login.js"></script>
