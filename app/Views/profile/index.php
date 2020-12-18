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
        <h3>Perfil</h3>
      </div>
    </div>
    
    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">

          <div class="x_content">
            <div class="col-md-3 col-sm-3 col-xs-12 text-center">
              <div class="profile_img">
                <div id="crop-avatar">
                  <span class="fa fa-user-circle-o fa-max avatar"></span>
                </div>
              </div>
              <a class="btn btn-primary" id="edit-user"><i class="fa fa-edit m-right-xs"></i> Editar Usuario</a>
              <br />

            </div>
            <div class="col-md-9 col-sm-9 col-xs-12">
            <div class="x_panel">
              <div class="x_content">
                <form class="form-horizontal form-label-left" action="javascript:void(0);" novalidate>
                  <span class="section">Información Basica</span>
                  <div class="item form-group" style="display:none">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="hidden" id="id_user" name="id" 
                              class="form-control col-md-7 col-xs-12" disabled value="<?=$user['id_user']?>">
                    </div>
                  </div>
                  <div class="item form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">Nombre:
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input id="name-usr" class="form-control col-md-7 col-xs-12 input-profile input-profile-edit disabled-input" disabled 
                             name="name" placeholder="" required="required" type="text"
                             value="<?=$user['name']?>">
                    </div>
                  </div>
                  <div class="item form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Correo:
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="email" id="email-usr" name="email" 
                              class="form-control col-md-7 col-xs-12 disabled-input" disabled value="<?=$user['email']?>">
                    </div>
                  </div>
                  <div class="item form-group ">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">Tipo:
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input  type="type" id="type-usr" name="type" 
                              class="form-control col-md-7 col-xs-12 disabled-input" disabled value="<?=$user['type_name']?>">
                    </div>
                  </div>
                  <section id="change-password-edit" style="display:none">
                    <span class="section">Cambio de clave</span>
                    <div class="item form-group ">
                      <label for="password-old-usr" class="control-label col-md-3">Clave Actual:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  id="password-old" type="password" name="password-old" class="form-control col-md-7 col-xs-12 input-change-password" 
                                value="">
                      </div>
                    </div>
                    <div class="item form-group ">
                      <label for="password-new-usr" class="control-label col-md-3">Nueva clave:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  id="password" type="password" name="password" class="form-control col-md-7 col-xs-12 input-change-password" 
                                value="" required="required">
                      </div>
                    </div>
                    <div class="item form-group ">
                      <label for="repeat-password-new-usr" class="control-label col-md-3">Repita la nueva clave:</label>
                      <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  id="password-repeat" type="password" name="password-repeat" data-validate-linked="password" 
                                class="form-control col-md-7 col-xs-12 input-change-password " value="" required="required">
                      </div>
                    </div>
                  </section>
                  <div class="form-group">
                    <div class="col-md-6 col-md-offset-3 buttons-edit" style="display:none">
                    </div>
                  </div>
                </form>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<?= $this->endSection() ?>