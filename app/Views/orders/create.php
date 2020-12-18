<?= $this->section('head') ?>
<!-- bootstrap-daterangepicker -->
<link href="<?= base_url('assets/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.css') ?>" rel="stylesheet">


<?= $this->endSection() ?>

<?= $this->extend('layouts/master') ?>

<?= $this->section('foot') ?>
<!-- morris.js -->
<script src="<?= base_url('assets/gentelella/vendors/raphael/raphael.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/morris.js/morris.min.js') ?>"></script>
<!-- bootstrap-progressbar -->
<script src="<?= base_url('assets/gentelella/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') ?>"></script>
<!-- bootstrap-daterangepicker -->
<script src="<?= base_url('assets/gentelella/vendors/moment/min/moment.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/bootstrap-daterangepicker/daterangepicker.js') ?>"></script>
<!-- jQuery Smart Wizard -->
<script src="<?= base_url('assets/gentelella/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js') ?>"></script>
<!-- validator -->
<script src="<?= base_url('assets/gentelella/vendors/validator/validator.js') ?>"></script>

<!-- dataTables -->
<script src="<?= base_url('assets/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') ?>"></script>  
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') ?>"></script>

<!-- initGui js -->
<script>$(document).ready(function(){ window.initGUI({
	"user"        : <?=json_encode($user)?>,
	"user_office" : <?=json_encode($user_office)?>,
	"order"         : <?=json_encode($order)?>,
	"order_product" : <?=json_encode($order_product)?>
	})
}); </script>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-create-order">

<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Creación de pedidos</h3>
        </div>
    </div>

    <div class="clearfix"></div>

    <div class="row">

      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_content">


            <!-- Smart Wizard -->
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-create-order" role="progressbar" 
                     style="width: 34%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            <div id="wizard" class="form_wizard wizard_horizontal">
                <ul class="wizard_steps" style="display:none">
                    <li>
                        <a href="#step-1">
                            <span class="step_no">1</span>
                            <span class="step_descr"> Selección de tipos de pedido </span>
                        </a>
                    </li>
                    <li>
                        <a href="#step-2">
                            <span class="step_no">2</span>
                            <span class="step_descr"> Selección de productos</span>
                        </a>
                    </li>
                    <li>
                        <a href="#step-3">
                            <span class="step_no">3</span>
                            <span class="step_descr"> Confirmación de producto </span>
                        </a>
                    </li>
                </ul>
            <div id="step-1">
                <h2 class="StepTitle">Selección tipo de pedido</h2>
                <form class="form-horizontal form-label-left" id="form-type-order" action="javascript:void(0);" novalidate>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Tipo de Pedido <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="select-type-order" required="required" class="form-control col-md-7 col-xs-12">
                                <option value="" disabled selected>Seleccione un tipo de pedido</option>
                                <?php foreach ($order_types as $key_type => $order_type) { ?>
                                    <option <?=$order_type == 'Sugerido' ? 'disabled' : '' ?> value="<?=$key_type?>"><?=$order_type?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Sucursal/Oficina <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="select-office-order" required="required" class="form-control col-md-7 col-xs-12">
                                <option value="" disabled selected>Seleccione una oficina</option>
                                <?php foreach ($offices as $id_office => $office) { ?>
                                    <option value="<?=$id_office?>"><?=$office['nomb']?> - <?=$office['rif']?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div id="step-2" style="display:none">
                <h2 class="StepTitle">Selección de productos</h2>
                <hr>
                <div class="content-select-product">
                    <div class="col-sm-3 add-product">
                        <h4>Buscar productos</h4>
                        <form class="form-horizontal form-label-left" id="form-product-order-search" action="javascript:void(0);" novalidate>
                            <div class="item form-group">
                                <input id="code-search-poduct" class="form-control col-md-7 col-xs-12" name="name" placeholder="Code" type="text">
                            </div>
                            <div class="item form-group">
                                <input id="barcode-search-poduct" class="form-control col-md-7 col-xs-12" name="name" placeholder="Barcode" type="text">
                            </div>
                            <div class="item form-group">

                                <input id="description-search-poduct" class="form-control col-md-7 col-xs-12" name="name" placeholder="Description" type="text">
                            </div>
                            <div class="item form-group">
                                <input id="warehouse-search-poduct" class="form-control col-md-7 col-xs-12" name="name" placeholder="Warehouse" type="text">
                            </div>
                        </form>
                        <button class="product-order-search btn btn-primary" form="form-product-order-search"> 
                             Buscar Productos
                        </button>
                    </div>
                    <div class="notify-products-unselect">
                        <br>
                        <div class=" col-md-offset-1 col-sm-7 alert-warning alert-warning-detail text-center">
                            <h4>No se han agregado productos</h4>
                        </div>
                    </div>
                    <div class="col-sm-9 selected-products" style="display:none">
                        <h4>Productos seleccionados</h4>
                        <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap table-selected-products" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Código</th>
                                    <th>Código de barra</th>
                                    <th>Descripción</th>
                                    <th>Depósito</th>
                                    <th>Precio</th>
                                    <th class="cant-product">Cantidad</th>
                                    <th class="remove-product"></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="step-3" style="display:none">
            <h2 class="StepTitle">Confirmación de pedido</h2>
                <div class="container confirmed-order">
                    <br>
                    <div class="item col-md-12">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12 label-confirmed"> Tipo de Pedido:</label>
                        <span class="col-sm-10 span-confirmed" id="type-order-confirmed"></span>
                    </div>
                    <div class="item col-md-12">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12 label-confirmed"> Sucursal/Oficina:</label>
                        <span class="col-sm-10 span-confirmed" id="office-confirmed"></span>
                    </div>
                    <div class="item col-md-12">
                        <label class="control-label col-md-2 col-sm-4 col-xs-12 label-confirmed"> Productos:</label>
                        <div class="col-md-offset-2 col-md-10">
                            <table class="table table-striped order-products-confirmed">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Barcode</th>
                                        <th>Descrirption</th>
                                        <th>Cantidad</th>
                                    </tr>
                                </thead>
                                <tbody>   
                                </tbody>    
                            </table>  
                        </div>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
      </div>
    </div>
</div>
</div>
<?= $this->endSection()?>