var list = {

    _user : {},

    _current_users : {},

    _user_types : {},

    _current_pass : '',

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
        thisO._current_users = data.users;
        thisO._user_types = data.user_types;
    },

    _initEvents: function(){
        var thisO = this;
        $(".change-pass").off("click").on("click", function(){
            var self_id = $(this).attr("id");
            self_id = parseInt(self_id.split("-").pop());
            thisO._confirmedChange(self_id);
        });

        $(".change-type").off("click").on("click", function(){
            var self_id = $(this).attr("id");
            self_id = parseInt(self_id.split("-").pop());
            thisO._renderModal(self_id);
        });
    },

    _renderModal : function(id_user){
        var thisO = this;
        var user = {};

        $.each(thisO._current_users, function(index, row_user){
            if(row_user['id_user'] == id_user){
                user = row_user;
            }
        });
        var content = "<h5>Usuario: <strong>"+ user['name'] +"</strong></h5>"
                    + "<h5>Tipo: <select class='form-control form-select' id='type_usr'>";

        $.each(thisO._user_types, function(index, type){
            var active = (index == user['type']) ? 'selected' : '';
            content += "<option value='"+index+"' "+active+">"+type+"</option>";
        });
        
        content += "</select></h5>";
        
        $("#my-modal-title").text("Cambio de tipo de usuario");
        $("#my-modal-content").html(content);

        var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                    + "Cancelar</button>"
                    + "<button type='button' class='btn btn-success my-modal-button-confirm'>"
                    + "Confirmar</button>";

        $(".my-modal-footer").empty();
        $(".my-modal-footer").html(buttons);

        $(".modal-alert-sm").modal("show");

        $(".my-modal-button-confirm").off().on("click", function(){
            $(".modal-alert-sm").modal("hide");
            $(".modal-loader-spinner").modal("show");
            user['type']      = $(".form-select").val();
            user['type_name'] = $(".form-select option:selected").text();

            var content = "<h5>El cambio de <strong>"+ user['name'] +"</strong> se realizo exitosamente </h5>"
                        + "<h5>Ahora es de tipo: <strong>"+ user['type_name'] +"</strong></h5>";
            
            thisO._updateUser(user, content);
            $(".modal-loader-spinner").modal("hide");
        });
    },

    _confirmedChange : function(id_user){
        var thisO = this;
        var user = {};

        $.each(thisO._current_users, function(index, row_user){
            if(row_user['id_user'] == id_user){
                user = row_user;
            }
        });
        
        var content = "<h5>¿Seguro que desea realizar el reinicio de clave de "
                    + "<strong>"+ user['name'] +"</strong>?</h5>";
        
        $("#my-modal-title").text("Confirmar");
        $("#my-modal-content").html(content);

        var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                    + "No</button>"
                    + "<button type='button' class='btn btn-success my-modal-button-confirm'>"
                    + "Si</button>";
        
        $(".my-modal-footer").empty();
        $(".my-modal-footer").html(buttons);

        $(".modal-alert-sm").modal("show");

        $(".my-modal-button-confirm").off().on("click", function(){
            $(".modal-alert-sm").modal("hide");
            $(".modal-loader-spinner").modal("show");
            var current_pass = thisO._rand_pass();
            user['pass'] = current_pass;

            var content = "<h5>El cambio de <strong>"+ user['name'] +"</strong> se realizo exitosamente </h5>"
                        + "<h5>La nueva clave es: <strong>"+ user['pass'] +"</strong></h5>";
            
            thisO._updateUser(user, content);
            $(".modal-loader-spinner").modal("hide");

        });

    },

    _updateUser : function(user, content){
        var thisO = this;
        $.ajax({
            type: 'POST',  
            url: '/index.php/services/user/update',
            data: JSON.stringify(user),
            context: document.body,
            success: function(response){
                response = JSON.parse(response);
                $(".modal-loader-spinner").modal("hide");
                if(response.code == 0){

                    $("#my-modal-title").text("Exito!");
                    $("#my-modal-content").html(content);

                    var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                                + "Close</button>"
                        
                    $(".my-modal-footer").empty();
                    $(".my-modal-footer").html(buttons);
                    $(".modal-alert-sm").modal("show");

                    $("#user-type-"+user['id_user']).text(user['type_name']);

                    $(".my-modal-button-close").off("click").on("click", function() {
                        $(".modal-backdrop").remove();
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

        return false;
    },
    
    _rand_pass : function(){
        code  = "";
        chars = "abcdefghijklmnopqrstuvwxyz";
        chars_length = 0;
        num_length   = 0;

        for (x=0; x < 5; x++){
            rand_type = Math.floor(Math.random() * 2);
            if(chars_length < 2 && rand_type == 0){
                chars_length++;
                rand = Math.floor(Math.random() * chars.length);
                code += chars.substr(rand, 1);
                continue;
            }else if(num_length < 3){
                num_length++;
                rand = Math.floor(Math.random()*10);
                code += rand;
                continue;
            }
            x--;
        }

        return code;
    },

    _alertNotify : function(title, message, type){
        new PNotify({
            title: title,
            text: message,
            timeout:'50',
            type: type,
            styling: 'bootstrap3',
            addclass: 'alertNotify'
         });
    }

}

dexport(list, 'initGUI');
function dexport(object, method){
    window[method] = function(){return object[method].apply(object, arguments);};
};