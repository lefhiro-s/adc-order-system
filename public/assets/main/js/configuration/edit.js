var edit_configuration = {

    _user : {},

    _current_user : {},

    _current_user_offices : {},

    /**
     * Inicializa la interfaz del usuario
     *
     * @param {object} p Contiene las propiedades iniciales
     * @returns {void}
     */
    initGUI: function (p){
        thisO = this;
        thisO._initConfig();
        thisO._initData(p);
        thisO._initEvents();
    },

    _initConfig: function(){
        var thisO = this;

    },

    _initData: function(data){
        var thisO = this;
    },

    _initEvents: function(){
        var thisO = this;
        $("#cancel-config").off("click").on("click", function(){
            window.location.reload()
        });

        $("#save-config").off("click").on("click", function(){
            thisO._saveConfig();
        });
    },

    _saveConfig : function(){
        var thisO = this;

        $('.modal-loader-spinner').modal('show');
        var data = {
            "pedidos_requieren_autorizacion" : $("#pedidos_requieren_autorizacion").prop('checked') ? 'SI': 'NO'
        };

        $.ajax({
            type: 'POST',  
            url: '/index.php/services/configuration/update',
            data: JSON.stringify(data),
            context: document.body,
            success: function(response){
                response = JSON.parse(response);
                $('.modal-loader-spinner').modal('hide');
                if(response.code == 0){
                    var content = "<div>"
                                + "     <h5>"+response.message+"</h5>"
                                + "</div>";

                    $("#my-modal-title").text("Exito!");
                    $("#my-modal-content").html(content);
                    $(".modal-alert-sm").modal("show");
                    
                    $(".my-modal-button-close").off().on("click", function(){
                        window.location.reload();
                    });
                }else{
                    thisO._alertNotify('Error', response.message, "error");
                }
            },
            error: function(response){
                $('.modal-loader-spinner').modal('hide');
                thisO._alertNotify('Error', "Ha ocurrido un error, vuelva a intentarlo", "error");
            }
        });
    }

}

dexport(edit_configuration, 'initGUI');
function dexport(object, method){
    window[method] = function(){return object[method].apply(object, arguments);};
};