<div class="top_nav">
    <div class="nav_menu">
      <nav>
        <div class="nav toggle">
          <a class="menu_toggle" id="menu_toggle"><i class="fa fa-bars"></i></a>
        </div>

        <ul class="nav navbar-nav navbar-right">
          <li class="">
            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <span class="fa fa-user-circle-o fa-mid"></span><span class="user-name"> <?=$user['name']?></span>
              <span class=" fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu dropdown-usermenu pull-right">
              <li><a href="<?= base_url('index.php/profile') ?>"> Perfil</a></li>
              <li><a href="<?= base_url('index.php/logout') ?>"><i class="fa fa-sign-out pull-right"></i> Cerrar Sesión</a></li>
              <li><p>Ultimo Login: <?=$user['last_login']?></p></li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
</div>