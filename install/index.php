<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>hrastral - The Ultimate HRM</title>
  <link rel="stylesheet" href="assets/css/bootstrap.min.css">
  <style type="text/css">
  body {
   font-size: 12px;
 }
 .form-control {
   height: 32px;
 }
 .error {
   background: #ffd1d1;
   border: 1px solid #ff5858;
   padding: 4px;
 }
</style>
</head>
<body style="background:linear-gradient(90deg, #000000 0%, #d3e9ff 100%);">
  <div class="container" style="margin-top:50px ">
    <div class="row">
      <div class="col-md-6 col-md-offset-5" style="margin-bottom:15px;"> <img src="../skin/img/hrastral-white.png" /> </div>
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-primary">
          <div class="panel-heading"> <strong class="">HRASTRAL - HRM</strong> </div>
          <div class="panel-body">

            <div class="panel panel-default" data-collapsed="0"
            style="border-color: #dedede;">
            <!-- panel body -->
            <div class="panel-body" style="font-size: 14px;">
              <p style="font-size: 14px;">
                Anda perlu mengetahui item berikut sebelum following
                melanjutkan.
              </p>
              <hr/>
              <ol>
                <li>Nama Database</li>
                <li>Username Database</li>
                <li>Password Database</li>
                <li>Hostname Database</li>
              </ol>
              <p style="font-size: 14px;">
                Kami akan menggunakan informasi di atas untuk menulis file database.php yang akan menghubungkan aplikasi ke Anda
                basis data.<br />
                Selama proses instalasi, kami akan memeriksa apakah file yang perlu ditulis
                (<strong>application/config/database.php</strong> & <strong>application/config/routes.php</strong>) have
                <strong>write permission</strong>.
              </p>
              <p style="font-size: 14px;">
                Kumpulkan informasi yang disebutkan di atas sebelum menekan tombol mulai instalasi. Jika Anda siap....
              </p>
              <br>
              <p class="text-right">
                <a href="step1.php" class="btn btn-primary">
                  Mulai Proses Instalasi
                </a>
              </p>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <footer class="main" style="text-align: center;">Butuh bantuan?  
              <a href="https://hrastral.com/kontak.php" target="_blank" style="text-decoration:underline;">Kontak kami</a>
            </footer>
          </div>
        </div>
        <div class="panel-footer"><?php echo date('Y');?> &copy HRASTRAL - HRM</div>
      </div>
    </div>
  </div>
</div> 
</body>
</html>
