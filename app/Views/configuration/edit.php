<?= $this->extend('layouts/master') ?>

<?= $this->section('foot') ?>
<!-- validator -->
<script src="<?= base_url('assets/gentelella/vendors/validator/validator.js') ?>"></script>

<!-- initGui js -->
<script>$(document).ready(function(){ window.initGUI({
	"user" : <?=json_encode($user)?>
	})
}); </script>

<?= $this->endSection() ?>


<?= $this->section('content') ?>
<div class="">
    <div class="page-title">
        <div class="title_left">
            <h3>Editar Configuración</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <form class="form-horizontal form-label-left" action="javascript:void(0);" novalidate>
                        <span class="section">Configuración Basica</span>
                        <br>
                        <?php foreach ($config as $key_config => $row_config) { ?>
                            <div class="item form-group">
                                <label class="control-label col-md-4 col-sm-4 col-xs-12" for="name">
                                    <?= $row_config['name'] == 'pedidos_requieren_autorizacion' 
                                        ? 'Los pedidos requieren autorización' : '' ?> : 
                                </label>
                                <div class="col-md-5 col-sm-5 col-xs-12">
                                    <label class="switch">
                                        <input type="checkbox" class="check-config" id="<?=$row_config['name']?>" 
                                               <?=$row_config['value'] == 'SI' ? 'checked' : '' ?>>
                                        <span class="slider round">
                                            <span class="value-select">SI</span>
                                            <span class="value-select-no">NO</span>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        <?php } ?>
                        <br>
                        <hr>
                        <div class="form-group">
                            <div class="col-md-5 col-md-offset-4">
                                <input type="button" id="cancel-config" class="btn btn-primary" value="Cancelar"></button>
                                <button id="save-config" class="btn btn-success">Guardar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
              
<?= $this->endSection() ?>
