var login = {

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

        $('.input100').each(function(){
            // Se valida si los inputs tienen algun dato
            if($(this).val().trim() != "") {
                $(this).addClass('has-val');
            }
    
            else {
                $(this).removeClass('has-val');
            }
            $(this).on('blur', function(){
                if($(this).val().trim() != "") {
                    $(this).addClass('has-val');
                }
                else {
                    $(this).removeClass('has-val');
                }
            }); 
        });
    
        if($("input.input100[name='email']").val() != ''){
            $("input[name='remember-me']").prop('checked', true);
        }
    
        $('.input100').off('click').on('click', function(){
            if(!$('#alert-email-incorrec').hasClass('inactive-display')){
                $("#alert-email-incorrect").addClass('inactive-display');
            }
        });
      
        /*[ Validate ]*/
        var input = $('.validate-input .input100');
    
        $('#login100-submit').on('click',function(){
            var check = true;
            $("#alert-email-incorrect").addClass('inactive-display');
            for(var i=0; i < input.length; i++) {
                if(thisO._validate(input[i]) == false){
                    thisO._showValidate(input[i]);
                    check=false;
                }
            }
    
            if(check){
                $('.modal-loader-spinner').modal('show');
                thisO._verifyUser();
            }
        });

        $('.validate-form .input100').each(function(){
            $(this).focus(function(){
                thisO._hideValidate(this);
            });
        });

        $("input").focus();

    },

    _verifyUser : function(){
        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

        var data = {
            'email'         : $("input.input100[name='email']").val(),
            'password'      : $("input.input100[name='pass']").val(),
            'remember_me'   : $("input[name='remember-me']").prop('checked') ? 1 : 0,
            'timezone'      : timezone,
        }

        $.ajax({
            type: 'POST',  
            url: '/index.php/services/user/validation',
            data: JSON.stringify(data),
            context: document.body,
            success: function(response){
                response = JSON.parse(response);
                if(response['validated']){
                    location.reload();
                }else{

                    var message;
                    switch (response['message']) {
                        case 2:
                            message  = 'Combinación email  / password es incorrecta';
                            break;
                        case 0:
                            message  = 'Usuario desactivo, no podrá iniciar sesión';
                            break;
                        default:
                            break;
                    }

                    setTimeout(
                        function(){
                            $('.modal-loader-spinner').modal('hide');
                            $("#alert-email-incorrect").removeClass('inactive-display');
                            $("#alert-email-incorrect span").html(message);
                        }, 1000);
                }
            }

        });
    },

    _validate : function(input) {
        if($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        }
        else {
            if($(input).val().trim() == ''){
                return false;
            }
        }
    },

    _showValidate : function(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    },

    _hideValidate : function(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    },

}

dexport(login, 'initGUI');
function dexport(object, method){
    window[method] = function(){return object[method].apply(object, arguments);};
};