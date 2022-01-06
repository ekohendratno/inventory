<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>USBK - Ujian Sekolah Berbasis Komputer</title>
    <script src="<?php echo base_url('assets/admin/js/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/jquery-ui.js') ?>"></script>
    <script src="<?php echo base_url(); ?>assets/admin/js/sweetalert/sweetalert.min.js"></script>
    <link rel="icon" type="image/ico" href="<?php echo base_url('assets/images/logocbt.ico') ?>"><link rel='dns-prefetch' href='<?php echo base_url();?>' />
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/admin/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/admin/css/jquery-ui.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/admin/css/custom.css') ?>" rel="stylesheet">
    <style type="text/css">
        .panel-default>.panel-heading {
            background-color: #fff;
            border-bottom: 0px;
        }
    </style>
</head>

<body class="text-center" style="padding-top: 10px;">

<div id="loading_ajax"><center style="padding:20px;"><div class="_ani_loading"><span style="clear:both">Memuat...</span></center></div></div>

<div class="container">

    <div class="row">
        <div id="loginbox" class="mainbox col-md-6 col-md-offset-3 col-sm-6 col-sm-offset-4">
            <div class="panel panel-default" >
                <div class="panel-heading">
                    <div class="panel-title pull-left">
                        <a href="<?php echo base_url();?>auth"><div class="btn-group" role="group"><div class="btn"><span class="
									glyphicon glyphicon-chevron-left" style="font-size: 14px;"></span> Dashboard</div></div></a>

                    </div>
                    <div class="panel-title pull-right">
                        <a href="javascript:void(0);" onclick="aksiLogout()" title="Logout"><div class="btn"><span class="
glyphicon glyphicon-off" style="color: #FC0004"></span></div></a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="panel-body text-left" >

                    <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                    <form class="form-horizontal" id="submit">

                        <center>
                            <img src="<?php echo $foto;?>" class="img-circle" alt="Cinque Terre" height="100" width="100" style="margin:20px 0;" ><br/>
                            <?php echo $username;?>
                        </center>
                    </form>



                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mastfoot mt-auto">
    <div class="inner">
        <p class="text-dark">&copy; 2019. Dikembangkan oleh Eko Hendratno, S.Kom</p>
    </div>
</footer>
</div>
<script src="<?php echo base_url('assets/admin/js/bootstrap.min.js') ?>"></script>
</body>
</html>
