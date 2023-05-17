jQuery(function ($) {
    $(document).ready(function () {  
        $("#eliminar").on("submit", function(e){
            
            e.preventDefault();

            var data = new FormData(this);
          console.log(data)
            var esto = $(this);

            Swal.fire({
              title: 'Estas seguro que quieres eliminar tu cuenta?',
              showCancelButton: true,
              confirmButtonText: 'Eliminar',
              confirmButtonColor: 'rgb(230, 58, 58)'
            }).then((result) => {
              /* Read more about isConfirmed, isDenied below */
              if (result.isConfirmed) {

                enviar_ajax(data, esto, redirection = "/proyecto_utn/inicio");

              } else if (result.isDenied) {
                Swal.fire('Cancelado', '', 'info')
              }
            })
   
        })
    })
})