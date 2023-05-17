jQuery(function ($) {
    $(document).ready(function () {  
        $("#login").on("submit", function(e){
            
            e.preventDefault();

            var data = new FormData(this);

            var esto = $(this);

            enviar_ajax(data ,esto , redirection = "inicio")
        })
    })
})