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
        <h3>Crear usuario</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
          <div class="x_content">
            <form class="form-horizontal form-label-left" action="javascript:void(0);" novalidate>
              <span class="section">Información Basica</span>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input id="name-user" class="form-control col-md-7 col-xs-12" name="name" placeholder="" required="required" type="text">
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Tipo <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <select id="type-user" class="form-control col-md-7 col-xs-12" name="type" required="required">
                  <?php foreach ($user_type as $key_type => $type) { ?>
                    <option value="<?=$key_type?>"><?=$type?></option>
                  <?php } ?>
                  </select>
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Correo <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="email" id="email-user" name="email" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="item form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Confirmar correo <span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <input type="email" id="email-user-repeat" name="confirm_email" data-validate-linked="email" required="required" class="form-control col-md-7 col-xs-12">
                </div>
              </div>
              <div class="item form-group">
                <label for="password" class="control-label col-md-3">Clave</label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="input-group">
                    <input id="password-user" type="text" name="password" class="form-control col-md-7 col-xs-12" required="required" disabled>
                    <span class="input-group-addon refresh-password-user" id="refresh-password"
                          data-toggle="tooltip" data-placement="right" title="" data-original-title="Generar una nueva clave"><i class="glyphicon glyphicon-refresh"></i></span>
                  </div>
                </div>
              </div>
              <div class="ln_solid"></div>
              <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                  <input type="button" id="cancel-user" class="btn btn-primary" value="Cancelar"></button>
                  <button id="save-user" type="submit" class="btn btn-success">Guardar</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</div>
<?= $this->endSection() ?>