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


<!-- dataTables -->
<script src="<?= base_url('assets/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') ?>"></script>  
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') ?>"></script>

<!-- validator -->
<script src="<?= base_url('assets/gentelella/vendors/validator/validator.js') ?>"></script>

<!-- initGui js -->
<script>$(document).ready(function(){ window.initGUI({
	"user"        	: <?=json_encode($user)?>,
	"user_office" 	: <?=json_encode($user_office)?>,
	"orders"      	: <?=json_encode($orders)?>,
	"order_status"	: <?=json_encode($order_status)?>
    })
}); </script>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-list-order">
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
		<div class="x_title">
        	<h2>Lista de pedidos</small></h2>
        	<div class="clearfix"></div>
        </div>
        <div class="x_content">
        	<table id="datatable-checkbox" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            	<thead>
               		<tr>
						<th>ID</th>
						<th>Fecha de creación</th>
						<th>Status</th>
						<th>Usuario</th>
						<th>Sucursal</th>
						<th>Productos</th>
						<th>ID Pedido Telares</th>
						<th>Acciones</th>
                	</tr>
            	</thead>
              	<tbody>
					<?php foreach ($orders as $key_order => $order){ ?>
						<tr>
							<td><?=$order['id_order']?></td>
							<td class="created-date-panel"><?=$order['creation_date']?></td>
							<td><?=$order['status']?></td>
							<td><?=$order['name'] ?></td>
							<td class="nomb-order-office"><?=$order['nomb'] ?></td>
							<td class="products-data">
								<button class="btn btn-sm panel-products text-center btn-primary products-order" id="products-<?=$order['id_order']?>">
									<h6><strong>Ver Productos</strong></h6>
								</button>
					  		</td>
							<td class="id-telares-td"><?=$order['return_id'] ?></td>
							<td class="action-orders text-center">
								<form action="/index.php/orders/create" method="post" target="_blank">
									<input type="hidden" id="id_order" name="id_order" value="<?=$order['id_order']?>" />
									<input type="hidden" id="id_office" name="id_office" value="<?=$order['id_office']?>" />
									<div class="btn-group">
										<?php if($user['type'] == 2 && 
											($order['status'] == 'CREADO' || $order['status'] == 'ERROR') ){?>
										<button type="button" id="edit-order-<?=$order['id_order']?>"
												class="btn btn-sm btn-primary edit-order">
											<i class="glyphicon glyphicon-edit"></i> Editar
										</button>
										<?php } ?>
										<button type="sumbit" class="btn btn-sm btn-primary copy-order">
												<i class="glyphicon glyphicon-duplicate"></i> Copiar
										</button>
									</div>
								</form>
							</td>
						</tr>
					<?php } ?>
				</tbody>
            </table>
          </div>
        </div>
      </div>
	</div>
</div>
<?= $this->endSection()?>