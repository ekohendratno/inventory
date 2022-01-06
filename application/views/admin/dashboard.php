<div class="position-absolute">
<div class="container container-medium">
    <div class="row">


        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="small-box bg-light">
                <div class="icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <div class="inner">
                    <h3><?php echo 0;?>/<?php echo 0;?></h3>
                    <p>Hari ini/Total Barang</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12">
            <div class="small-box bg-light">
                <div class="icon">
                    <i class="fas fa-reply"></i>
                </div>
                <div class="inner">
                    <h3><?php echo 0;?>/<?php echo 0;?></h3>
                    <p>Hari ini/Total Transaksi</p>
                </div>
            </div>
        </div>





    </div>
</div>
</div>

<div class="container container-medium" style="margin-top: 20px">
    <div class="col-md-12">
        <div class="row">

            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="homes" style="padding-bottom: 40px; padding-top: 40px">

                        <div class="col-lg-3 col-sm-3 col-xs-6 text-center">
                            <a href="<?php echo base_url()?>admin/katalog">
                                <div class="dashboard-circle">
                                    <div class="icon">
                                        <i class="fas fa-book-open"></i>
                                    </div>
                                    <p class="text-center">Katalog</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-sm-3 col-xs-6 text-center">
                            <a href="<?php echo base_url()?>admin/lokasi">
                                <div class="dashboard-circle">
                                    <div class="icon">
                                        <i class="fas fa-search-location"></i>
                                    </div>
                                    <p class="text-center">Lokasi</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-sm-3 col-xs-6 text-center">
                            <a href="<?php echo base_url()?>admin/barang">
                                <div class="dashboard-circle">
                                    <div class="icon">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                    <p class="text-center">Barang</p>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 col-sm-3 col-xs-6 text-center">
                            <a href="<?php echo base_url()?>admin/transaksi">
                                <div class="dashboard-circle">
                                    <div class="icon">
                                        <i class="fas fa-reply"></i>
                                    </div>
                                    <p class="text-center">Transaksi</p>
                                </div>
                            </a>
                        </div>


                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>


<div class="container container-medium" style="margin-top: 20px">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <b>10 TRANSAKSI TERBARU</b>
                </div>
                <div class="panel-body">


                    <div id="postList0" class="list-group" style="font-size: 18px"></div>

                </div>
            </div>
        </div>

    </div>
</div>

<div class="modal fade modal-fullscreen" id="formTahunAjaran" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tahun Ajaran
                    <div class="pull-right">
                        <button onclick="submitTahunAjaran()" type="button" id="btn-ubah" class="btn btn-success">Simpan Pengaturan</button>
                        <a id="closetahunajaran" style="display: none;" href="#" class="btn btn-danger btn-sm btn-circle" data-dismiss="modal"><i class="fas fa-times"></i></a>
                    </div>
                </h4>
            </div>
            <div class="modal-body">

                <div class="container container-medium">
                    <p>Silahkan lakukkan pemilihan tahun ajaran, sebelum membuat dan memanagement soal soal
                        dan pastikan tahun ajaran yang Anda masukkan telah sesuai, agar soal yang tersedia tepat!.</p>
                    <p>Jangan lupa setelah memilih tahun ajaran klik <strong>Simpan</strong> di pojok kanan atas!</p>

                    <div class="row">

                        <div class="col-md-6">

                            <label>Pilih Tahun Ajaran <span class="text-danger">*</span></label><br/>
                            <select class="form-control selectpicker"  id="tahunajaran">
                                <?php
                                $t = date('Y');
                                $t_min = $t-3;
                                for($a = $t; $a>=$t_min; $a--){?>
                                    <option value="<?php echo $a.'/'.($a+1);?>">Tahun Ajaran <?php echo $a.'/'.($a+1);?></option>
                                    <?php
                                }
                                ?>
                            </select>

                        </div>

                        <div class="col-md-6">
                            <label>Pilih Semester <span class="text-danger">*</span></label><br/>
                            <select class="form-control selectpicker"  id="semester">
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>
</div>



<style type="text/css">
    body {
        font-family: sans-serif;
        color: #514d6a;
        font-size: 1.5em;
        overflow-x: hidden;
        background-color: #ddd;
    }
    nav.navbar {
        box-shadow: 2px 2px 2px 2px rgb(0 0 0 / 0%);
    }
    .position-absolute{
        margin-top: -20px;
        padding-top: 20px;
        background: #778e9a!important;
        box-shadow: 2px 2px 2px 2px rgb(0 0 0 / 11%);
    }
    .small-box .svg-inline--fa{
        font-size: 28px;
        color: #778e9a;
    }
    .small-box p{
        color: rgba(110, 110, 110, 0.69);
    }


    .homes .img-responsive {
        margin: 0 auto;
    }
    .homes p{
        color: #5B5B5B;
    }
    .homes .icon {
        -webkit-transition: all .3s linear;
        -o-transition: all .3s linear;
        transition: all .3s linear;
        text-align: center;
        z-index: 0;
        font-size: 50px;
        color: rgba(0,0,0,0.15);
    }
    .homes .icon:hover {
        text-decoration: none;
        color: #0092f9;
    }

    .img-home{
        padding: 10px;
    }


</style>


<script type="text/javascript">
    //$('.position-absolute').detach().appendTo( $('nav.navbar') );
    <?php if(!empty($tahunajaran) && !empty($semester)){?>
    $('#tahunajaran').val('<?php echo $tahunajaran;?>');
    $('#tahunajaran').selectpicker('refresh');

    $('#semester').val('<?php echo $semester;?>');
    $('#semester').selectpicker('refresh');

    //$('#formTahunAjaran').modal('hide');
    <?php }else{?>
    //$('#formTahunAjaran').modal('show');
    <?php }?>

    function closetahunajaran() {
        $('#closetahunajaran').show();
    }

    function submitTahunAjaran(){

        var tahunajaran = $("#tahunajaran").val();
        var semester = $("#semester").val();

        $.ajax({
            type:'POST',
            data: "tahunajaran="+tahunajaran+"&semester="+semester,
            url:'<?php echo base_url('index.php/admin/dashboard/simpantahunajaran') ;?>',
            beforeSend: function () {
                $('#loading_ajax').show();
            },
            success: function(){
                $('#formTahunAjaran').modal('hide');
                $('#loading_ajax').fadeOut("slow");

                setTimeout(function() {
                    window.location.assign("<?php echo base_url('index.php/admin/dashboard') ;?>");
                }, 300);
            }
        });
    }





    searchFilter0(0);
    function searchFilter0(page_num) {
        page_num = page_num?page_num:0;

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>index.php/admin/transaksi/ajaxPaginationData/'+page_num,
            data:'page='+page_num+'&limitBy=10',
            dataType:'json',
            beforeSend: function () {
                $('#loading_ajax').show();
            },
            success: function (responseData) {
                paginationData0(responseData.empData);
                $('#loading_ajax').fadeOut("slow");
            }
        });
    }


    function paginationData0(data) {


        $('#postList0').empty();
        var nomor = 0;

        if(data.length < 1 || !data){

            var empRow = ''+
                '<div class="row">'+
                '<div class="col-md-12">'+
                '<div class="bs-callout bs-callout-danger" id="callout-glyphicons-empty-only">'+
                '<h4>Tidak ada daftar transaksi</h4>'+
                '<p>Daftar transaksi akan terlihat ketika data tersedia!.</p>'+
                '</div>'+
                '</div>'+
                '</div>'+
                '<div class="clearfix"></div>'+
                '';
            $('#postList0').append(empRow);
        }else{

            for(emp in data){


                var empRow = '<div class="list-group-item">'+
                    '<p class="list-group-item-text title" style="text-align:center;">'+
                    ' <span class="label label-default">'+data[emp].transaksi_jenis+'</span>'+
                    ' <span class="label label-default">'+data[emp].transaksi_jumlah+' barang</span>'+
                    '</p><br/>'+


                    '<h4 class="list-group-item-heading name"><i class="fas fa-file"></i> '+ data[emp].transaksi_keterangan+'</h4>'+

                    '<p><i style="color:#999">'+data[emp].transaksi_peminjam+'</i></p>'+
                    '</div></div>'+


                    '<div class="clearfix"></div>'+
                    '</div>';
                nomor++;
                $('#postList0').append(empRow);
            }

        }

    }

</script>