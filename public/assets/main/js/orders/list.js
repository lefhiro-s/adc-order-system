var list_orders = {

    _orders : {},

    _status_order : {},

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
        thisO._orders       = data.orders;
        thisO._status_order = data.order_status;
        thisO._current_user_offices = data.user_office;
        thisO._current_user = data.user;

        if(thisO._current_user_offices.length == 0 && thisO._current_user != 2){
            $(".content-list-order").empty();
            var content = "Su usuario no posee oficinas asociadas para esta sección";

            $("#my-modal-title").text("Notificación");
            $("#my-modal-content").html(content);

            var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                        + "Close</button>"
                
            $(".my-modal-footer").empty();
            $(".my-modal-footer").html(buttons);
            $(".modal-alert-sm").modal("show");

            $(".my-modal-button-close").off("click").on("click", function() {
                location.href = '/index.php';
            });
        }
    },

    _initEvents: function(){
        var thisO = this;

        $(".edit-order").off("click").on("click", function(){
            var self_id = $(this).attr("id");
            self_id = parseInt(self_id.split("-").pop());
            thisO._renderModal(self_id);
        });

        $(".products-order").off("click").on("click", function(){
            var self_id = $(this).attr("id");
            self_id = parseInt(self_id.split("-").pop());
            thisO._getProductsByOrder(self_id);
        });

        $(".paginate_button > a").off("click").on("click", function(){
            setTimeout(function(){
                thisO._paginate_button()
            }, 500);
        });
    },

    _renderModal : function(id_order){
        var thisO = this;
        var order = {};

        $.each(thisO._orders, function(index, row_order){
            if(row_order['id_order'] == id_order){
                order = row_order;
            }
        });

        var content = "<h5>Pedido: <strong>"+ order['id_order'] +"</strong></h5>"
                    + "<h5>Status: <select class='form-control form-select' id='type_order'>";

        if(order['status'] == "CREADO"){
            content += "<option value='"+2+"' >"+thisO._status_order[2]+"</option>";
            content += "<option value='"+3+"' >"+thisO._status_order[3]+"</option>";
        }else  if (order['status'] == 'ERROR'){
            content += "<option value='"+2+"' >"+thisO._status_order[2]+"</option>";
        }else{
            thisO._alertNotify("Alerta", "Solo se pueden editar pedidos con status (CREADO y ERROR)", "warning");
            return false;
        }
        
        content += "</select></h5>";
        
        $("#my-modal-title").text("Cambio de status de pedido");
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

            order['status'] = $("#type_order").val();

            var content = "<h5>El cambio del pedido <strong>"+ order['id_order'] +"</strong> se realizo exitosamente </h5>";            
            thisO._updateOrder(order, content);
        });
    },

    _getProductsByOrder : function(id_order){
        var thisO = this;

        $.each(thisO._orders, function(index, row_order){
            if(row_order['id_order'] == id_order){
                order = row_order;
            }
        });
        
        $.ajax({
            type: 'POST',  
            url: '/index.php/services/orders/get_products',
            data: JSON.stringify({"id_order" : id_order}),
            context: document.body,
            success: function(response){
                response        = JSON.parse(response);
                console.log(response);
                $(".modal-loader-spinner").modal("hide");
                if(response.code == 0){

                    
                    $("#my-modal-title").text("lista de productos");
                    $(".my-modal").removeClass("modal-sm");
                    $("#my-modal-content").html(response.html);

                    $(".table-product-select").dataTable({
                        "lengthMenu" : [5, 10],
                        "bSort" : false
                    });
                    
                    $(".modal-alert-sm").modal("show");

                    $(".my-modal-button-close").off("click").on("click", function() {
                        $(".my-modal").addClass("modal-sm");
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



    _updateOrder : function (order, content){
        var thisO = this;
        if(order['status'] == 2){
            var content = "<h4 class='loader-info'>Procesando pedido, no cierre la pantalla</h4>";
            $(".loader-information").append(content);

            $.ajax({
                type: 'POST',  
                url: '/index.php/services/orders/send',
                data: JSON.stringify(order),
                context: document.body,
                success: function(response){
                    response = JSON.parse(response);
                    if(response.code == 0){
                        $('.modal-loader-spinner').modal('hide');
                        var content = "";
                            content     += "<div>"
                                        + "<h5> El pedido fue aprobado exitosamente!</h5>"
                            $("#my-modal-title").text("Pedido aprobado!");
                            $(".my-modal").addClass("modal-sm");
                            $("#my-modal-content").html(content);
        
                            var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                                        + "Close</button>"
                    
                            $(".my-modal-footer").empty();
                            $(".my-modal-footer").html(buttons);
        
                            $(".my-modal-button-close").off().on("click", function(){
                                location.reload();
                            });
                            
                            $(".modal-alert-sm").modal("show");
                    }else{
                        var content = "";
                            content     += "<div>"
                                        + "<h5>Ha ocurrido un error al aprobar el pedido, vuelve a intentarlo </h5"
                                        + "<h5 class='text-danger'>"+response.data['error_description']+"</h5>";
                            $("#my-modal-title").text("Pedido creado!");
                            $(".my-modal").addClass("modal-sm");
                            $("#my-modal-content").html(content);
        
                            var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                                        + "Close</button>"

                            $(".my-modal-footer").empty();
                            $(".my-modal-footer").html(buttons);
        
                            $(".my-modal-button-close").off().on("click", function(){
                                location.reload();
                            });
                            
                            $(".modal-alert-sm").modal("show");
                    }
                },
                error: function(response){
                    $('.modal-loader-spinner').modal('hide');
                    var content = "";
                        content     += "<div>"
                                    + "<h5 class='text-danger'> Ocurrio un error al enviar el pedido, intente mas tarde</h5>"
                        $("#my-modal-title").text("Pedido creado!");
                        $(".my-modal").addClass("modal-sm");
                        $("#my-modal-content").html(content);
    
                        var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                                    + "Close</button>"
                
                        $(".my-modal-footer").empty();
                        $(".my-modal-footer").html(buttons);
    
                        $(".my-modal-button-close").off().on("click", function(){
                            location.reload();
                        });
                        
                        $(".modal-alert-sm").modal("show");
                }
            });
        }else{
            $.ajax({
                type: 'POST',  
                url: '/index.php/services/orders/update',
                data: JSON.stringify(order),
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

                        $(".my-modal-button-close").off("click").on("click", function() {
                            $(".modal-backdrop").remove();
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

            return false;

        }
    },

    _paginate_button : function(){
        var thisO = this;

        $(".edit-order").off("click").on("click", function(){
            var self_id = $(this).attr("id");
            self_id = parseInt(self_id.split("-").pop());
            thisO._renderModal(self_id);
        });

        $(".paginate_button > a").off("click").on("click", function(){
            setTimeout(function(){
                thisO._paginate_button()
            }, 500);
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

dexport(list_orders, 'initGUI');
function dexport(object, method){
    window[method] = function(){return object[method].apply(object, arguments);};
};