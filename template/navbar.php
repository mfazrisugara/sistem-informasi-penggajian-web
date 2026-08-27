<nav class="navbar">

    <div class="navbar-title">
        Sistem Informasi Penggajian
    </div>


    <div class="navbar-user">

        <i class="fas fa-user-circle"></i>

        <span>
            <?= $_SESSION['username']; ?>
        </span>

        <span class="role">
            (<?= $_SESSION['role']; ?>)
        </span>


<a href="/penggajian/logout.php" class="logout-btn">
    <i class="fas fa-right-from-bracket"></i>
    Logout
</a>

    </div>


</nav>