var create_order = {

    _user : {},

    _current_user : {},

    _products : {},

    _current_user_offices : {},

    _current_order : {},

    _order_original : {},

    _order_products : {},

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
        thisO._initEvents();
    },

    _initConfig: function(){
        var thisO = this;

    },

    _initData: function(data){
        var thisO = this;
        thisO._current_user_offices = data.user_office;
        thisO._order_original       = data.order;
        thisO._order_products       = data.order_product;
        if(thisO._current_user_offices.length == 0){
            $(".content-create-order").empty();
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

        if(thisO._order_original){
            $(".modal-loader-spinner").modal("show");
            $("#select-office-order").val(thisO._order_original['id_office']);
            $("#select-type-order").val(1);
            $("#office-confirmed").html($("#select-office-order option:selected").html());
            $("#type-order-confirmed").html($("#select-type-order option:selected").html());

            thisO._current_order['type_order'] = $("#select-type-order").val();
            thisO._current_order['office_order'] = $("#select-office-order").val();

            thisO._setProducts();

            setTimeout(function(){
                $(".buttonNext").trigger("click");
            }, 500);
            $(".modal-loader-spinner").modal("hide");

        }

        $(".table-selected-products").dataTable({
            "lengthMenu" : [5]
        });

        $("#select-type-order").on("change", function(){
            $("#type-order-confirmed").html($("#select-type-order option:selected").html());
            thisO._current_order['type_order'] = $(this).val();
        });

        $("#select-office-order").on("change", function(){
            $("#office-confirmed").html($("#select-office-order option:selected").html());
            thisO._current_order['office_order'] = $(this).val();
        });

        setTimeout(function(){
            $(".buttonNext").on("click", function(){
                $("#form-type-order").submit();

                if($("#select-type-order").val() == "3"){
                    $(".content-select-product").hide();
                }else{
                    $(".content-select-product").show();
                }
                if($(".wizard_steps > li > a.selected").attr("rel") == "2"){
                    if($(".cant-product-selected").length == 0){
                        thisO._alertNotify('Error', 'Debe agregar un producto', "error");
                        return false
                    }else{
                        thisO._confirmedProductOrders();
                    }
                };
            });
            $(".buttonPrevious").on("click", function(){
                $(".order-products-confirmed tbody tr").remove();
            });

            $(".buttonFinish").on("click", function(){
                $(".modal-loader-spinner").modal("show");
                thisO._finishOrder();
            });
        }, 1000);

        $(".product-order-search").off("click").on("click", function(){
            $(".modal-loader-spinner").modal("show");
            thisO._searchProducts();
        });

    },

    _searchProducts: function(){
        var thisO = this;
        var data = {
            "code"          : $("#code-search-poduct").val(),
            "barcode"       : $("#barcode-search-poduct").val(),
            "description"   : $("#description-search-poduct").val(),
            "warehouse"     : $("#warehouse-search-poduct").val()  
        }

        $.ajax({
            type: 'POST',  
            url: '/index.php/services/orders/search',
            data: JSON.stringify(data),
            context: document.body,
            success: function(response){
                response        = JSON.parse(response);
                $(".modal-loader-spinner").modal("hide");
                if(response.code == 0){

                    $.each(JSON.parse(response.data)['items'], function(index, product){
                        if(!thisO._products[product['code']]){
                            thisO._products[product['code']] = product;
                        }
                        thisO._products[product['code']]['checked'] = false;
                    });

                    $("#my-modal-title").text("Agregar productos");
                    $(".my-modal").removeClass("modal-sm");
                    $("#my-modal-content").html(response.html);

                    var buttons = "<button type='button' class='btn btn-success my-modal-button-add'>"
                                + "Agregar</button>"
                                +"<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                                + "Close</button>"
                        
                    $(".my-modal-footer").empty();
                    $(".my-modal-footer").html(buttons);
                    $(".modal-alert-sm").modal("show");
                    
                    $(".table-product-select").dataTable({
                        "lengthMenu" : [5],
                        "bSort" : false
                    });

                    $(".left-fill, .center-fill, .right-fill").removeClass("col-sm-4");
                    $(".left-fill, .right-fill").addClass("col-sm-6");

                    $(".my-modal-button-close").off("click").on("click", function() {
                        $(".my-modal").addClass("modal-sm");
                    });


                    $(".my-modal-button-add").off("click").on("click", function() {
                        $(".modal-alert-sm").modal("hide");
                        $(".modal-loader-spinner").modal("show");
                        $(".notify-products-unselect").fadeOut();
                        thisO._updateTableProducts();    
                        thisO._alertNotify('Exito!', 'Se han agregado los productos exitosamente', "success");
                        $(".selected-products").fadeIn();

                        thisO._removeProductSelected();
                    });

                    $(".check-all-product").off("click").on("click", function(){
                        $(".check-product").prop("checked", this.checked);
                        var checked_all = this.checked;
                        $.each(thisO._products, function(index, product){
                            thisO._products[index]['checked'] = checked_all;
                        });
                    });

                    $(".paginate_button > a").off("click").on("click", function(){
                        setTimeout(function(){
                            thisO._paginate_button()
                        }, 300);
                    });
            
                    $(".check-product").on("click", function() {
                        var index = $(this).attr("id").split("-")[2];
                        thisO._products[index]['checked'] = this.checked ? true : false;
                        if ($(".check-product").length == $(".check-product:checked").length) {  
                          $(".check-all-product").prop("checked", true);  
                        }else{  
                          $(".check-all-product").prop("checked", false);  
                        }  
                    });

                    $("#datatable-checkbox_filter > label > input").on("keyup", function(){
                        $(".check-product").on("click", function() {
                            var index = $(this).attr("id").split("-")[2];
                            thisO._products[index]['checked'] = this.checked ? true : false;
                            if ($(".check-product").length == $(".check-product:checked").length) {  
                              $(".check-all-product").prop("checked", true);  
                            }else{  
                              $(".check-all-product").prop("checked", false);  
                            } 
                        });
            
                        $(".check-product").each(function(){
                            var index = $(this).attr("id").split("-")[2];
                            $(this).prop("checked", thisO._products[index]['checked'] ? true : false);
                        });
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

    _setProducts : function(){
        var thisO = this;
        $.ajax({
            type: 'POST',  
            url: '/index.php/services/orders/search',
            data: JSON.stringify({}),
            context: document.body,
            success: function(response){
                response        = JSON.parse(response);
                if(response.code == 0){
                    $.each(JSON.parse(response.data)['items'], function(index, product){
                        if(thisO._order_products[product['code']]){
                            thisO._products[product['code']] = product;
                            thisO._products[product['code']]['quantity'] = thisO._order_products[product['code']]['quantity'];
                            thisO._products[product['code']]['checked'] = true;
                        }
                    });
                    $(".notify-products-unselect").fadeOut();
                    thisO._updateTableProducts();    
                    $(".selected-products").fadeIn();
                    thisO._removeProductSelected();

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

    _updateTableProducts : function(){
        var thisO = this;
        $.each(thisO._products, function(index, product){
            if(!product['added'] && product['checked']){
                $(".table-selected-products").DataTable().row.add([
                    product['code'],
                    product['barcode'],
                    product['description'],
                    product['warehouse'],
                    product['price'],
                    "<input type='number' class='form-control input-sm input-width-100 cant-product-selected' value='' id='cant-product-"+product['code']+"' />",
                    "<button class='btn btn-sm btn-danger remove-product-added' id='remove-product-"+product['code']+"'><i class='fa fa-trash'></i></button>"
                ]);
                thisO._products[index]['added'] = true;
                thisO._products[index]['quantity_product'] = 1;
            }
        });

        $(".table-selected-products").DataTable().draw();

        $(".cant-product-selected").off("keyup").on("keyup", function(){
            var index = $(this).attr("id").split("-")[2];
            $(this).val($(this).val() > 0 ? $(this).val() : 1);
            thisO._products[index]['quantity_product'] = $(this).val();
        });


        $("#datatable-responsive_filter > label > input").on("keyup", function(){
            $(".cant-product-selected").off("keyup").on("keyup", function(){
                var index = $(this).attr("id").split("-")[2];
                $(this).val($(this).val() > 0 ? $(this).val() : 1);
                thisO._products[index]['quantity_product'] = $(this).val();
            });
        });
        
        thisO._paginate_button();

        $('.modal-loader-spinner').modal('hide');

    },

    _confirmedProductOrders : function(){
        var thisO = this;
        thisO._current_order['products'] = {};
        $.each(thisO._products, function(index, product){
            if(product['added']){
                var content = "";
                content     += "<tr id='content-confirmed-product-"+product['code']+"'>"
                            +       "<td class='confirmed-product'>"+product['code']+"</td>"
                            +       "<td class='confirmed-product'>"+product['barcode']+"</td>"
                            +       "<td class='confirmed-product'>"+product['description']+"</td>"
                            +       "<td class='confirmed-product'>"+product['quantity_product']+"</td>";
                            +  "</tr>"
                $(".order-products-confirmed tbody").append(content);
                thisO._current_order['products'][index] = product;
            }
        });
    },

    _finishOrder :function(){
        var thisO = this;

        thisO._current_order['timezone'] = Intl.DateTimeFormat().resolvedOptions().timeZone;

        $.ajax({
            type: 'POST',  
            url: '/index.php/services/orders/save',
            data: JSON.stringify(thisO._current_order),
            context: document.body,
            success: function(response){
                response = JSON.parse(response);
                if(response.code == 0){
                    if(response.data['pre_approved'] == 0){
                        $(".modal-loader-spinner").modal("hide");
                        var content = "";
                        content     += "<div>"
                                    + "<h5> El pedido fue creado con el id: <strong>"+response.data['id_order']+"</strong></h5>"
                                    + "<h5> Debe ser aprobado por un administrador para ser procesado</h5>"
                        $("#my-modal-title").text("Pedido creado!");
                        $(".my-modal").addClass("modal-sm");
                        $("#my-modal-content").html(content);

                        var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                                    + "Close</button>"
                
                        $(".my-modal-footer").empty();
                        $(".my-modal-footer").html(buttons);

                        $(".my-modal-button-close").off().on("click", function(){
                            window.location = "/index.php/orders/list";
                        });
                        
                        $(".modal-alert-sm").modal("show");


                    }else{
                        var content = "<h4 class='loader-info'>Procesando pedido, no cierre la pantalla</h4>";
                        $(".loader-information").append(content);
                        thisO._current_order['id_order'] = response.data['id_order'];
                        thisO._sendOrder();
                    }
                }else{
                    $(".modal-loader-spinner").modal("hide");
                    thisO._alertNotify('Error', response.message, "error");
                }
            },
            error: function(response){
                $('.modal-loader-spinner').modal('hide');
                thisO._alertNotify('Error', "Ha ocurrido un error, vuelva a intentarlo", "error");
            }
        });
    },

    _sendOrder : function(){
        var thisO = this;

        $.ajax({
            type: 'POST',  
            url: '/index.php/services/orders/send',
            data: JSON.stringify(thisO._current_order),
            context: document.body,
            success: function(response){
                response = JSON.parse(response);
                console.log(response);
                if(response.code == 0){
                    $('.modal-loader-spinner').modal('hide');
                    var content = "";
                        content     += "<div>"
                                    + "<h5> El pedido fue creado con el id: <strong>"+thisO._current_order['return_id']+"</strong></h5>"
                                    + "<h5> Fue enviado exitosamente!</h5>"
                        $("#my-modal-title").text("Pedido creado!");
                        $(".my-modal").addClass("modal-sm");
                        $("#my-modal-content").html(content);
    
                        var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                                    + "Close</button>"
                
                        $(".my-modal-footer").empty();
                        $(".my-modal-footer").html(buttons);
    
                        $(".my-modal-button-close").off().on("click", function(){
                            window.location = "/index.php/orders/list";
                        });
                        
                        $(".modal-alert-sm").modal("show");
                }else{
                    var content = "";
                        content     += "<div>"
                                    + "<h5> El pedido fue creado con el id: <strong>"+thisO._current_order['id_order']+"</strong></h5>"
                                    + "<h5 class='text-danger'>"+response.data['error_description']+"</h5>";
                        $("#my-modal-title").text("Pedido creado!");
                        $(".my-modal").addClass("modal-sm");
                        $("#my-modal-content").html(content);
    
                        var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                                    + "Close</button>"
                
                        $(".my-modal-footer").empty();
                        $(".my-modal-footer").html(buttons);
    
                        $(".my-modal-button-close").off().on("click", function(){
                            window.location = "/index.php/orders/list";
                        });
                        
                        $(".modal-alert-sm").modal("show");
                }
            },
            error: function(response){
                $('.modal-loader-spinner').modal('hide');
                var content = "";
                    content     += "<div>"
                                + "<h5> El pedido fue creado con el id: <strong>"+thisO._current_order['id_order']+"</strong></h5>"
                                + "<h5 class='text-danger'> Ocurrio un error al enviar el pedido, intente mas tarde</h5>"
                    $("#my-modal-title").text("Pedido creado!");
                    $(".my-modal").addClass("modal-sm");
                    $("#my-modal-content").html(content);

                    var buttons = "<button type='button' class='btn btn-primary my-modal-button-close' data-dismiss='modal'>"
                                + "Close</button>"
            
                    $(".my-modal-footer").empty();
                    $(".my-modal-footer").html(buttons);

                    $(".my-modal-button-close").off().on("click", function(){
                        window.location = "/index.php/orders/list";
                    });
                    
                    $(".modal-alert-sm").modal("show");
            }
        });
    },

    _removeProductSelected : function(){
        var thisO = this;
        $(".remove-product-added").off("click").on("click", function(){
            $(".modal-loader-spinner").modal("show");
            var index = $(this).attr("id").split("-")[2];
            thisO._products[index]['added'] = false;
            $("content-confirmed-product-"+index).remove();
            $(".table-selected-products").DataTable().destroy();
            $("#remove-product-"+index).parent().parent().remove();
            
            if($(".table-selected-products tbody tr").length == 0){
                $(".selected-products").fadeOut();
                $(".notify-products-unselect").fadeIn();
            }
            
            $(".table-selected-products").dataTable({
                "lengthMenu" : [5],
            });

            thisO._removeProductSelected()
            $(".modal-loader-spinner").modal("hide");
        });
    },

    _paginate_button : function(){

        $(".check-product").on("click", function() {
            var index = $(this).attr("id").split("-")[2];
            thisO._products[index]['checked'] = this.checked ? true : false;
            if ($(".check-product").length == $(".check-product:checked").length) {  
              $(".check-all-product").prop("checked", true);  
            }else{  
              $(".check-all-product").prop("checked", false);  
            }  
        });

        $(".check-product").each(function(){
            var index = $(this).attr("id").split("-")[2];
            console.log(thisO._products[index]['checked']);
            $(this).prop("checked", thisO._products[index]['checked'] ? true : false);
        });

        $(".cant-product-selected").off("keyup").on("keyup", function(){
            var index = $(this).attr("id").split("-")[2];
            $(this).val($(this).val() > 0 ? $(this).val() : 1);
            thisO._products[index]['quantity_product'] = $(this).val();
        });

        thisO._removeProductSelected();

        $(".paginate_button > a").off("click").on("click", function(){
            setTimeout(function(){
                thisO._paginate_button()
            }, 500);
        });
    },

    _alertNotify : function(title, message, type){
        PNotify.removeAll();
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

dexport(create_order, 'initGUI');
function dexport(object, method){
    window[method] = function(){return object[method].apply(object, arguments);};
};