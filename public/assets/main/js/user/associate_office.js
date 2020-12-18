var associate_office = {

    _users : {},

    _offices : {},

    _current_user : {},

    _current_pass : '',

    _office_ids : {},

    /**
     * Inicializa la interfaz del usuario
     *
     * @param {object} p Contiene las propiedades iniciales
     * @returns {void}
     */
    initGUI: function (p){
        thisO = this;
        thisO._initData(p);
        thisO._initConfig();
    },

    _initData: function(data){
        var thisO = this;
        thisO._users        = data.users;
        thisO._offices      = data.offices;
        thisO._current_user = data.user;
    },

    _initConfig: function(){
        var thisO = this;
        setTimeout(function(){
            var content = "<select class='form-control input-sm user-office-select'>"
                    + "<option selected disabled>Selecciona un usuario</option>";
            $.each(thisO._users, function(index, user){
                var user = user['user'];
                content += "<option value='"+user['id_user']+"'>"+user['name']+" - "+user['email']+"</option>"
            });
            content += "</select>";
            var buttons = "<button class='btn btn-sm btn-primary' id='save-office-user' disabled>Guardar</button>";
            $(".center-fill").append(content + buttons);

            thisO._initEvents();
        }, 1000);
    },

    _initEvents: function(){
        var thisO = this;

        $(".check-all-office").off("click").on("click", function(){
            $(".check-office").prop("checked", this.checked);
            var checked_all = this.checked;

            $.each(thisO._offices, function(index, office){
                thisO._offices[index]['checked'] = checked_all; 
            });
        });

        $(".check-office").on("click", function() {
            var index = $(this).attr("id").split("-")[2];
            thisO._offices[index]['checked'] = this.checked ? true : false;
            if ($(".check-office").length == $(".check-office:checked").length) {  
              $(".check-all-office").prop("checked", true);  
            }else{  
              $(".check-all-office").prop("checked", false);  
            }  
        });

        $(".user-office-select").off("change").on("change", function(){
            var user_office_id = $(".user-office-select").val();
            $("#save-office-user").prop("disabled", false);
            $(".check-office").prop("checked", false);

            $.each(thisO._users[user_office_id]['offices'], function(index, office){
                $("#check-office-"+office['id_office']).prop("checked", true);
                thisO._offices[office['id_office']]['checked'] = true;
            });

            if ($(".check-office").length == $(".check-office:checked").length) {  
                $(".check-all-office").prop("checked", true);  
            } else {  
                $(".check-all-office").prop("checked", false);  
            }
            
        });

        $("#save-office-user").off("click").on("click", function(){
            $(".modal-loader-spinner").modal("show");
            thisO._saveOfficeUser();
        });

        $(".paginate_button > a").off("click").on("click", function(){
            setTimeout(function(){
                thisO._paginate_button()
            }, 500);
        });

        $("select[name='datatable-checkbox_length']").on("change", function() {
            $(".check-office").on("click", function() {
                var index = $(this).attr("id").split("-")[2];
                thisO._offices[index]['checked'] = this.checked ? true : false;
                if ($(".check-office").length == $(".check-office:checked").length) {  
                  $(".check-all-office").prop("checked", true);  
                }else{  
                  $(".check-all-office").prop("checked", false);  
                } 
            });

            $(".check-office").each(function(){
                var index = $(this).attr("id").split("-")[2];
                $(this).prop("checked", thisO._offices[index]['checked'] ? true : false);
            });

            if ($(".check-office").length == $(".check-office:checked").length) {  
                $(".check-all-office").prop("checked", true);  
            }else{
                $(".check-all-office").prop("checked", false);  
            }
        });
        
        $("#datatable-checkbox_filter > label > input").on("keyup", function(){
            $(".check-office").on("click", function() {
                var index = $(this).attr("id").split("-")[2];
                thisO._offices[index]['checked'] = this.checked ? true : false;
                if ($(".check-office").length == $(".check-office:checked").length) {  
                  $(".check-all-office").prop("checked", true);  
                }else{  
                  $(".check-all-office").prop("checked", false);  
                } 
            });

            $(".check-office").each(function(){
                var index = $(this).attr("id").split("-")[2];
                $(this).prop("checked", thisO._offices[index]['checked'] ? true : false);
            });

            if ($(".check-office").length == $(".check-office:checked").length) {  
                $(".check-all-office").prop("checked", true);  
            }else{
                $(".check-all-office").prop("checked", false);  
            }  
        });
    },

    _paginate_button(){

        $(".check-office").on("click", function() {
            var index = $(this).attr("id").split("-")[2];
            thisO._offices[index]['checked'] = this.checked ? true : false;
            if ($(".check-office").length == $(".check-office:checked").length) {  
              $(".check-all-office").prop("checked", true);  
            }else{  
              $(".check-all-office").prop("checked", false);  
            }  
        });

        $(".check-office").each(function(){
            var index = $(this).attr("id").split("-")[2];
            $(this).prop("checked", thisO._offices[index]['checked'] ? true : false);
        });

        $(".paginate_button > a").off("click").on("click", function(){
            setTimeout(function(){
                thisO._paginate_button()
            }, 500);
        });
    },

    _saveOfficeUser(){
        var thisO = this;

        $.each(thisO._offices, function(index, office){
            thisO._office_ids[index] = office['checked'];
        });

        data = {
            offices_ids : thisO._office_ids,
            id_user     : $(".user-office-select").val()
        }
        
        $.ajax({
            type: 'POST',  
            url: '/index.php/services/user/office/update',
            data: JSON.stringify(data),
            context: document.body,
            success: function(response){
                response = JSON.parse(response);
                $(".modal-loader-spinner").modal("hide");
                if(response.code == 0){

                    $("#my-modal-title").text("Exito!");
                    $("#my-modal-content").html(response['message']);

                    var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                                + "Close</button>"
                        
                    $(".my-modal-footer").empty();
                    $(".my-modal-footer").html(buttons);
                    $(".modal-alert-sm").modal("show");

                    $(".my-modal-button-close").off("click").on("click", function() {
                        location.reload();
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
dexport(associate_office, 'initGUI');
function dexport(object, method){
    window[method] = function(){return object[method].apply(object, arguments);};
};