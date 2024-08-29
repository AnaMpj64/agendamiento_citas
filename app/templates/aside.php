<aside class="sidenav border-radius-xl mt-3 fixed-top ms-3">
    <div class="sidenav-header text-center">
        <div class="user-profile">
        <img src="../../public/img/usuario.png" alt="User Profile Image" class="user-avatar">
        <h6 class="user-name"><?php echo $_SESSION['USER'] ?></h6>
        </div>
    </div>
    <hr class="white">
    <div class="sidenav-content">
        <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" href="../views/dashboard.php">
            <i class="fas fa-tachometer-alt"></i>
            Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../views/citas_admin.php">
            <i class="far fa-calendar"></i>
            Citas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../views/ejercicios.php">
            <i class="fas fa-dumbbell"></i>
            Ejercicios
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="../views/pacientes_admin.php">
                <i class="fas fa-user"></i> 
                Pacientes 
            </a>
        </li>
        </ul>
    </div>
    <div class="sidenav-footer text-center">
        <hr class="white">
        <button class="btn btn-outline-danger btn-sm btn-rounded" onclick="cerrarSesion();">Cerrar Sesión</button>
    </div>
</aside>