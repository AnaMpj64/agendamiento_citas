<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container-fluid">
  <img src="../../public/img/logo.png" alt="Achilie Logo" height="50px" width="50px" style="margin-left: 20px;">
    <div class="menu-options mx-auto">
        <a class="menu-link" href="../views/inicio.php">Inicio</a>
        <a class="menu-link" href="../views/page_ejercicios.php">Ejercicios</a>
        <a class="menu-link" href="../views/dashboard.php">Administrador</a>
    </div> 
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDarkDropdown" aria-controls="navbarNavDarkDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse col-2 position-absolute end-0 m-4 id="navbarNavDarkDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <button class="btn text-white dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          </button>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="../../index.php" onclick="cerrarSesion();"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>