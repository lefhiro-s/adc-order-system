var profile = {

    _user : {},

    _current_user : {},

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
        $("#edit-user").off('click').on('click', function(){ 
            $('.modal-loader-spinner').modal('show');
            thisO._renderEditSection();
            $('.modal-loader-spinner').modal('hide');
        });

        $(".input-change-password").blur(function() {
            var validate_fields = true;
            $(".input-change-password").removeAttr("required");

            $(".input-change-password").each(function(){
                if($(this).val() != ''){
                    validate_fields = false;
                }
            });

            if(validate_fields){
                setTimeout(function(){
                    $("section#change-password-edit > div.item").removeClass("bad");
                    $("section#change-password-edit > div.item > div.alert").remove();
                    $(".input-change-password").removeAttr("required");
                }, 500);
            }else{
                $(".input-change-password").attr("required", "required");
            }
        });

    },

    _renderEditSection : function(){
        var thisO = this;
        $("#change-password-edit").slideDown();
        $("#edit-user").fadeOut();
        $(".input-profile-edit").removeClass("disabled-input");
        $(".input-profile-edit").removeAttr("disabled");

        var buttons_edit = "<button id='cancel-edit' class='btn btn-primary'>Cancelar</button>"
                         + "<button id='save-edit'  type='submit' class='btn btn-success'>Guardar</button>";
        $(".buttons-edit").append(buttons_edit);
        $(".buttons-edit").slideDown();
        
        $("#save-edit").off('click').on('click', function(){
            $(".alertNotify").remove();
            thisO._updateUser();
        });

        $("#cancel-edit").off('click').on('click', function(){
            $('.modal-loader-spinner').modal('show');
            thisO._unrenderizedEditSection();
            $('.modal-loader-spinner').modal('hide');
        });
    },

    _unrenderizedEditSection : function(){
        var thisO = this;
        $("#change-password-edit").slideUp();
        $(".input-change-password").val('');
        $(".alert").remove();
        $(".bad").removeClass("bad");

        $(".input-profile-edit").addClass("disabled-input");
        $(".input-profile-edit").prop("disabled", true);
        
        $(".buttons-edit").empty();
        $("#edit-user").slideDown();
        $("#name-usr").val(thisO._current_user['name']);
        $(".user-name").text(thisO._current_user['name']);
    },

    _updateUser : function(){
        var thisO = this;

        thisO._user = {};

        if($("#name-usr").val() == ''){
            return false;
        }else{
            thisO._user['name']= $("#name-usr").val();
        }

        if($("#password-old").val() == '' && $("#password").val() == '' && $("#password-repeat").val() == '' ){
            $("section#change-password-edit > div.item").removeClass("bad");
            $("section#change-password-edit > div.item > div.alert").remove();
            $(".input-change-password").removeAttr("required");
        }else{
            thisO._user['password_old']       = $("#password-old").val();
            thisO._user['password']           = $("#password").val();

            $(".input-change-password").attr("required", "required");

            if($("#password-old").val() == ''){
                return false;
            }

            if($("#password").val() == ''){
                return false;
            }

            if($("#password").val() != $("#password-repeat").val()){
                return false;
            }
        }
        $('.modal-loader-spinner').modal('show');

        thisO._user['id_user'] = $("#id_user").val();
        thisO._saveUser(thisO._user);
    },

    _saveUser : function(user){
        var thisO = this;
        $.ajax({
            type: 'POST',  
            url: '/index.php/services/user/update',
            data: JSON.stringify(user),
            context: document.body,
            success: function(response){
                response = JSON.parse(response);
                $('.modal-loader-spinner').modal('hide');
                if(response.code == 0){
                    thisO._current_user = response.data;
                    thisO._unrenderizedEditSection();
                    thisO._alertNotify('Exito', response.message, "success");
                    
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

dexport(profile, 'initGUI');
function dexport(object, method){
    window[method] = function(){return object[method].apply(object, arguments);};
};