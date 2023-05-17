jQuery(function ($) {
    $(document).ready(function () {  
        $("#registrarse").on("submit", function(e){
            console.log("funciona");
            e.preventDefault();

            var data = new FormData(this);

            var esto = $(this);

            enviar_ajax(data ,esto , redirection = "/proyecto_utn/inicio")
        })
    })
})