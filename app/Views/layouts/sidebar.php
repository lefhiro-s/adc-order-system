<div class="col-md-3 left_col">
    <div class="left_col scroll-view">
      <div class="navbar nav_title" style="border: 0;">
        <a href="<?= base_url('index.php/dashboard') ?>" class="site_title"><img src="<?= base_url('assets/main/images/adc-isotipo.png')?>" class="icon-sidebar"> <span>PEL 2.0</span></a>
      </div>

      <div class="clearfix"></div>

      <br />

      <!-- sidebar menu -->
      <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
          <h3>General</h3>
          <ul class="nav side-menu">
            <li><a href="<?= base_url('index.php/dashboard') ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            </li>
              <li><a><i class="glyphicon glyphicon-shopping-cart"></i> Pedidos <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li><a href="<?= base_url('index.php/orders/create') ?>">Crear pedido</a></li>
                  <li><a href="<?= base_url('index.php/orders/list') ?>">Lista de pedidos</a></li>
                </ul>
              </li>
            <?php if ($user['type'] == "2") : ?>
              <li><a><i class="fa fa-users"></i> Usuarios <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                  <li><a href="<?= base_url('index.php/user/create') ?>">Crear usuario</a></li>
                  <li><a href="<?= base_url('index.php/user/list') ?>">Lista de usuarios</a></li>
                  <li><a href="<?= base_url('index.php/user/associate_office') ?>">Gestor de oficinas</a></li>
                </ul>
              </li>
              <li><a><i class="fa fa-cogs"></i> Configuración <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?= base_url('index.php/configuration/edit') ?>">Editar configuración</a></li>
                </ul>
            </li>
            <?php endif; ?>
          </ul>
        </div>


      </div>
      <!-- /sidebar menu -->

      <!-- /menu footer buttons -->
      <div class="sidebar-footer hidden-small">
        <a data-toggle="tooltip" data-placement="top" title="FullScreen" class="menu_toggle">
          <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
        </a>
        <a data-toggle="tooltip" data-placement="top" title="Logout" href="<?= base_url('logout') ?>">
          <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
        </a>
      </div>
      <!-- /menu footer buttons -->
    </div>
</div>