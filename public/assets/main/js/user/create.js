var create = {

    _user : {},

    _current_user : {},

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
        thisO._current_user = data.user;

    },

    _initEvents: function(){
        var thisO = this;
        thisO._current_pass = thisO._rand_pass();
        $("#password-user").val(thisO._current_pass);

        $("#refresh-password").off("click").on("click", function(){
            thisO._current_pass = thisO._rand_pass();
            $("#password-user").val(thisO._current_pass);
        });

        $("#cancel-user").off("click").on("click", function(){
            window.location.reload()
        });

        $("#save-user").off("click").on("click", function(){
            thisO._save_user();
        });
    },

    _save_user : function(){
        var thisO = this;

        if($("#name-user").val() == ''){
            return false;
        }else{
            thisO._user['name'] = $("#name-user").val();
        }

        if($("#email-user").val() == '' || ($("#email-user").val() != $("#email-user-repeat").val()) ){
            return false;
        }else{
            thisO._user['email'] = $("#email-user").val();
        }

        thisO._user['type']     = $("#type-user").val();
        thisO._user['password'] = thisO._current_pass;
        
        $('.modal-loader-spinner').modal('show');

        $.ajax({
            type: 'POST',  
            url: '/index.php/services/user/create',
            data: JSON.stringify(thisO._user),
            context: document.body,
            success: function(response){
                response = JSON.parse(response);
                $('.modal-loader-spinner').modal('hide');
                if(response.code == 0){
                    var content = "<div>"
                                + "<h5>"+response.message+"</h5>"
                                + "<h5>Resguarde la clave: <strong>"+thisO._current_pass+ "</strong></h5>";
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
    },

    _rand_pass : function(){
        code  = "";
        chars = "abcdefghijklmnopqrstuvwxyz";
        chars_length = 0;
        num_length   = 0;

        for (x=0; x < 5; x++){
            rand_type = Math.floor(Math.random()*2);
            if(chars_length < 2 && rand_type == 0){
                chars_length++;
                rand = Math.floor(Math.random()*chars.length);
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

dexport(create, 'initGUI');
function dexport(object, method){
    window[method] = function(){return object[method].apply(object, arguments);};
};