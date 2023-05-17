var enviar_ajax = function(data ,esto , redirection = ""){
    
    var spin = '<div class="spinner-border" style="position:absolute;left:0;right:0;top:0;bottom:0;margin:auto;" role="status"></div>';
    
    var configuracion_ajax = {
        type: "POST",
        url: data.get("url"),
        data: data,
        dataType: "json",
        
        beforeSend: function () {
            if(esto.find("input[type=submit]").length > 0 ){
                esto.find("input[type=submit]").parent().append(spin);
                esto.find("input[type=submit]").attr("disabled", "disabled");
            }else{
                esto.append(spin);
            }
        },
        success: function (value) {
            console.log(value);
            jQuery(".spinner-border").remove();
            jQuery("#errores .messageError").text("");
            if(esto.find("input[type=submit]").length > 0 ){
                esto.find("input[type=submit]").removeAttr("disabled").removeClass("disabled");
            }
            if (value.estado) {
                Swal.fire({
                    icon: "success",
                    html: "<h4>"+value.mensaje+"</h4>",
                    showConfirmButton: false,
                    timer: 3500,
                }).then(() => {
                    if(redirection != ""){
                        window.location.replace(redirection);
                        return false;
                    }
                    
                });
            }else{
                $(".alert-badge").fadeOut( 500 );
                esto.find(".alert").each(function(){
                     $(this).text("");  
                 })
                 
                if(typeof value.mensaje === 'object' && value.mensaje !== null ){

                    jQuery.each(value.mensaje, function(key, res){ 

                        jQuery("#" + key).parent().find(".alert-badge").fadeIn( 500,

                            function(){
                                console.log($(this).text(res));
                                $(this).text(res);

                            }

                        ); 
 
                    })
                }else{
                    jQuery(".messageError").show(500, function(){
                        $(this).text(value.mensaje);
                    })
                }

                return false;
                
            }

            return true;
        },
        error: function (res) {
            console.log(res);
            jQuery(".spinner-border").remove();
            if(esto.find("input[type=submit]").length > 0 ){
                esto.find("input[type=submit]").removeAttr("disabled").removeClass("disabled");
            }
        },
    }
    

    if(esto.find("button[type=submit]").length > 0 ){
        configuracion_ajax.processData = false;
        configuracion_ajax.contentType =  false;
    }
    
    return jQuery.ajax(configuracion_ajax);
  }