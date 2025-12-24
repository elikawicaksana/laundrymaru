<aside class="main-sidebar sidebar-dark-primary elevation-2">
    <div class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Laundry Maru</span>
    </div>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo $_SESSION['foto']; ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="edit-user.php?id_user=<?php echo $_SESSION['id_user']; ?>" class="d-block"><?php echo $_SESSION['nama_user']; ?></a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <?php
                    if($_SESSION['level']=='Admin'){
                        echo "
                            <li class='nav-header'>USER</li>
                            <li class='nav-item sidebar-func nav-func'>
                                <a href='transaksi-list.php' class='nav-link'>
                                    <i class='nav-icon fas fa-tachometer-alt'></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class='nav-item sidebar-func nav-func'>
                                <a href='transaksi-pelanggan.php' class='nav-link'>
                                    <i class='nav-icon fa fa-cash-register'></i>
                                    <p>
                                        Transaksi
                                    </p>
                                </a>
                            </li>
                            <li class='nav-header'></li>
                            <li class='nav-header'>ADMIN</li>
                            <li class='nav-item sidebar-func nav-func'>
                                <a href='daftar-pelanggan.php' class='nav-link'>
                                    <i class='nav-icon fa-regular fa-id-badge'></i>
                                    <p>
                                        Pelanggan
                                    </p>
                                </a>
                            </li>
                            <li class='nav-item sidebar-func nav-func'>
                                <a href='daftar-produk.php' class='nav-link'>
                                    <i class='nav-icon fa fa-boxes-stacked'></i>
                                    <p>
                                        Paket
                                    </p>
                                </a>
                            </li>
                            <li class='nav-item sidebar-func nav-func'>
                                <a href='daftar-outlet.php' class='nav-link'>
                                    <i class='nav-icon fas fa-store'></i>
                                    <p>
                                        Outlet
                                    </p>
                                </a>
                            </li>
                            <li class='nav-item sidebar-func nav-func'>
                                <a href='daftar-user.php' class='nav-link'>
                                    <i class='nav-icon fa fa-user-tie'></i>
                                    <p>
                                        User
                                    </p>
                                </a>
                            </li>
                        ";
                    }elseif($_SESSION['level']=='Kasir'){
                        echo "
                            <li class='nav-header'>USER</li>
                            <li class='nav-item sidebar-func nav-func'>
                                <a href='transaksi-list.php' class='nav-link'>
                                    <i class='nav-icon fas fa-cash-register'></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class='nav-item sidebar-func nav-func'>
                                <a href='transaksi-pelanggan.php' class='nav-link'>
                                    <i class='nav-icon fas fa-tachometer-alt'></i>
                                    <p>
                                        Transaksi
                                    </p>
                                </a>
                            </li>
                            <li class='nav-item sidebar-func nav-func'>
                                <a href='register-pelanggan.php' class='nav-link'>
                                    <i class='nav-icon fa fa-user'></i>
                                    <p>
                                        Pelanggan
                                    </p>
                                </a>
                            </li>
                        ";
                    }else{
                        echo "
                            <li class='nav-header'>USER</li>
                            <li class='nav-item sidebar-func nav-func'>
                                <a href='transaksi-list.php' class='nav-link'>
                                    <i class='nav-icon fas fa-tachometer-alt'></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                        ";
                    }
                ?>
            </ul>
        </nav>
    </div>
</aside>