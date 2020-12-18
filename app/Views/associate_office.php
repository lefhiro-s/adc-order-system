<?= $this->section('head') ?>
<?= $this->endSection() ?>

<?= $this->extend('layouts/master') ?>

<?= $this->section('foot') ?>
<!-- Datatables -->
<script src="<?= base_url('assets/gentelella/vendors/datatables.net/js/jquery.dataTables.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/jszip/dist/jszip.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/pdfmake/build/pdfmake.min.js') ?>"></script>
<script src="<?= base_url('assets/gentelella/vendors/pdfmake/build/vfs_fonts.js') ?>"></script>

<script>$(document).ready(function(){ window.initGUI({
	"user"    : <?=json_encode($user)?>,
	"users"   : <?=json_encode($users)?>,
	"offices" : <?=json_encode($offices)?>
	})
}); </script>

<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
		<div class="x_title">
        	<h2>Gestor de oficinas a usuarios</small></h2>
        	<div class="clearfix"></div>
        </div>
        <div class="x_content">
        	<table id="datatable-checkbox" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            	<thead>
               		<tr>
						<th>
							<td><input type="checkbox" id="check-all" class="flat check-all-office"></td>
						</th>
						<th>Nombre</th>
						<th>RIF</th>
						<th>Ubicación</th>
						<th>Estado</th>
                	</tr>
            	</thead>
              <tbody>
			  <?php foreach ($offices as $key_office => $row_office) { ?>
                <tr class="entry-<?=$row_office['id_office']?>">
                  <td>
                     <th><input type="checkbox" id="check-office-<?=$row_office['id_office']?>" class="flat check-office"></th>
                  </td>
                  <td><?=$row_office['nomb']?></td>
                  <td><?=$row_office['rif']?></td>
                  <td><?=$row_office['ubic']?></td>
                  <td><?=$row_office['esta']?></td>
                </tr>
			<?php } ?>
			</tbody>
            </table>
          </div>
        </div>
      </div>
	</div>

<?= $this->endSection() ?>