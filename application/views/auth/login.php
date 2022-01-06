<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inventory</title>
    <script src="<?php echo base_url('assets/js/jquery.js') ?>"></script>
      <script src="<?php echo base_url(); ?>assets/admin/js/sweetalert/sweetalert.min.js"></script>
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/login.css" rel="stylesheet">
	<style type="text/css">
		  
	</style>
	<script type="text/javascript">

        $(document).on('keypress', 'input', function(e) {

            if(e.keyCode == 13 && e.target.type !== 'submit') {
                e.preventDefault();
                signin();
            }

        });

		function signin() {
			
			$('.status').empty();
			var username = $('#username').val();
			var password = $('#password').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>auth/signin',
				data:'username='+username+'&password='+password,
				dataType:'json',
				beforeSend: function () {
					$("input").attr('disabled','disabled');
					$("button").attr('disabled','disabled');

					$('.status').html('<div class="alert alert-warning" role="alert">Loading ...</div>');
					$('#loading_ajax').show();
				},
                error:function (hasil) {
                    $('#username').val("");
                    $('#password').val("");

                    $('.status').empty();
                    $("input").removeAttr('disabled');
                    $("button").removeAttr('disabled');

                    $('#loading_ajax').fadeOut("slow");
                    swal({
                        title: "Gagal!",
                        text: "Gagal melakukkan login!",
                        icon: "error",
                        button: true,
                    });

                },
				success: function (hasil) {

                    $('#loading_ajax').fadeOut("slow");
                    $('.status').html(hasil.pesan);
                    if(hasil.pesan == ''){
                        swal({
                            title: "Berhasil!",
                            text: "Sedang di dialihkan, Tunggu beberapa saat!",
                            icon: "success",
                            button: false,
                        });

                    }else{
                        $("input").removeAttr('disabled');
                        $("button").removeAttr('disabled');
                    }
                    $('#loading_ajax').fadeOut("slow");

                    if( hasil.redirect != null ){
                        setTimeout(function () {
                            window.location.assign("<?php echo base_url();?>"+hasil.redirect);
                        },2000);
                    }
				}
			});
		}
	</script>
  </head>

  <body>
  
	  
		<div class="container-fluid">  
			<div class="row col-wrap">
				<div class="col-lg-3 col-md-4 col-sm-5 col">

					
					<div id="loginbox" class="cpanel-login-v3-left col-md-12 col-md-offset-0">

                        <div class="py-5 text-center" style="padding-top: 20px;padding-bottom: 20px">
                            <a href="<?php echo base_url();?>"><img src="<?php echo base_url();?>assets/images/logocbt.ico" width="98px"/></a>
                        </div>
                        <div class="py-4 of-login-container of-show">
                            <h4 class="pt-2 text-center">Inventory Akun</h4>
                            <div class="status"></div>

                            <div class="form-group form-group-lg">
                                <input type="input" class="form-control" id="username" placeholder="Username">
                            </div>
                            <div class="form-group form-group-lg">
                                <input type="password" class="form-control" id="password" placeholder="Password">
                                <div class="of-input-validation lpassword-toggle-btn show-password"></div>
                            </div>

                            <div class="text-right">
                                <button onclick="signin()" type="button" id="btn-tambah" class="btn btn-lg btn-block btn-success">MASUK</button>
                            </div>

                            <br class="clear"/>
                            <div class="of-copyright text-center">&copy; 2019.<br/>Created by Eko Hendratno, S.Kom</div>
                        </div>


					</div>
					
				</div>
				<div class="col-lg-9 col-md-8 col-sm-7 col login-image">
				
					<div id="signup-signin-v3-right-holder full-width" class="" style="display: block;">

					<picture>
					<img class="cpanel-login-v3-right__image" src="<?php echo base_url();?>assets/images/utama.jpg">
					</picture>
					</div>
				
				</div>
			</div>
    	</div>
	  
	  
	<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
  </body>
</html>
