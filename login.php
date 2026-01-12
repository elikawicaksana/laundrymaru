<!DOCTYPE html>
<html lang="en">
<head>
  <?php
    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['passwd'])){
        echo "<script type='text/javascript'>\n";
        echo "alert('Anda Sudah Login');";
        echo "window.location = ('transaksi-list.php');";
        echo "</script>";
    }
    include 'config/koneksi.php';
    include 'include/head.php';
  ?>
  <style>
    .bg-img {
      background: rgba(0, 0, 0, 0.7) url("img/login-bg.jpg");
      background-attachment: fixed;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
      background-blend-mode: darken;
      /* backdrop-filter: blur(2px); */
    }

    .color{
      color: #4d4d4d;
    }

    .img-login{
        width: 375px;
        height:406.4px;
        margin-left:-15px;
        border-radius: 0px 15px 15px 0px;
        -moz-border-radius: 0px 15px 15px 0px;
        -webkit-border-radius: 0px 15px 15px 0px;
        border: 0px solid #000000;
    }

    .border-login{
        border-radius: 15px 0px 0px 15px;
        -moz-border-radius: 15px 0px 0px 15px;
        -webkit-border-radius: 15px 0px 0px 15px;
        border: 0px solid #000000;
    }
  </style>
</head>
<body class="hold-transition light-mode login-page bg-img">
  <div class="row">
    <div class="col-6">
      <div class="login-box border-login">
        <div class="card border-login">
          <div class="card-body login-card-body border-login">
            <br/>
            <div class="login-logo">
              <b class="color">Laundry Marrow</b>
            </div>  
            <p class="login-box-msg">Sign in to start your session</p>
            <form action="proses/login-proses.php" method="post" autocomplete="off">
              <div class="form-group">
                <label class="color">Username</label>
                <div class="input-group mb-3">
                  <input type="text" name="username" class="form-control" placeholder="Masukkan Username.." required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-user color"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="color">Password</label>
                <div class="input-group mb-3">
                  <input type="password" name="passwd" class="form-control" placeholder="Masukkan Password.." required>
                  <div class="input-group-append">
                    <div class="input-group-text">
                      <span class="fas fa-lock color"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12">
                  <button type="submit" class="btn btn-dark btn-block">Sign In</button>
                </div>
              </div>
            </form>
            <br/>
          </div>
        </div>
      </div>
    </div>
    <div class="col-6">
      <img src="img/login2.png" class="img-login">
    </div>
  </div>
<?php
    include 'include/script.php';
?>
<script>
  setTimeout(function(){
    $('#textValidasi').fadeOut();
  },1000);
</script>
</body>
</html>
