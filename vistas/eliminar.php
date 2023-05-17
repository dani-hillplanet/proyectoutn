<form method="post" id="eliminar">

    <button type="submit" class="btn btn-primary my-2">Eliminar Usuario</button>
    <input type="hidden" name="id" value="<?= $_SESSION["user_id"] ?>">
    <input type="hidden" name="url" value="eliminar">
   
</form>

<script src="vistas/js/eliminar.js"></script>