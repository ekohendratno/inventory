<div class="container-flex">

    <div class="col-sm-12 col-md-12">

        <h4><i class='fa fa-file fa-fw'></i> BARANG <i class='fa fa-angle-right fa-fw'></i> DATA BARANG TERBARU</h4>
        <hr/>
        <div class="panel-title-button pull-right">
            <a href="#formSearch" data-toggle="modal" class="btn btn-sm" title="Search"><span class="fas fa-search"></span> Cari</a>
            <a href="#formFilter" data-toggle="modal" class="btn btn-sm" title="Filter"><span class="fas fa-filter"></span> Filter</a>
            <a title="Barcode" data-backdrop="static" data-keyboard="false" href="#form3" data-toggle="modal" onClick="submitBarcode()" class="btn btn-sm"><i class="fas fa-qrcode"></i> Cetak QRCode</a>
            <a title="Tambah Barang" data-backdrop="static" data-keyboard="false" href="#formDialog" data-toggle="modal" onClick="formDialog(0)" class="btn btn-sm btn-success  btn-sm btn-circle"><i class="fas fa-plus"></i></a>
        </div>

    </div>
    <!-- Blog Entries Column -->
    <div class="col-sm-12 col-md-8">
        <div>
            <div style="min-height:800px;">


                <div id="postList0" class="list-group" style="font-size: 18px"></div>
                <div id='pagination'></div>


            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-4">

        <div class="row">
            <div class="col-md-12">
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3><?php echo 0;?></h3>
                        <p>Total Barang</p>
                    </div>
                    <div class="inner">
                        <h3><?php echo 0;?></h3>
                        <p>Total Katalog</p>
                    </div>
                    <div class="inner">
                        <h3><?php echo 0;?></h3>
                        <p>Total Lokasi</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>



<div class="modal fade" id="formSearch" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">


                    <div class="col-md-12">
                        <div class="input-group input-group-lg">
                            <div class="input-group-addon"><i class="fas fa-search"></i></div>
                            <input type="text" class="form-control token" name="keywords" id="keywords" placeholder="Type keywords to filter posts" onkeyup="searchFilter()">
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade modal-fullscreen" id="formFilter" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Filter
                    <div class="pull-right">
                        <a href="<?php echo base_url(). "admin/barang/index"; ?>" class="btn btn-primary">Atur Ulang Setingan</a>
                        <a href="#" class="btn btn-danger btn-sm btn-circle" data-dismiss="modal"><i class="fas fa-times"></i></a>
                    </div>
                </h4>
            </div>
            <div class="modal-body">

                <div class="container container-small">

                    <div class="row">

                        <div class="col-sm-6">
                            <label>Urutkan</label><br/>
                            <select class="form-control"  id="sortBy" onchange="searchFilter()">
                                <option value="">Sort By</option>
                                <option value="asc">Ascending</option>
                                <option value="desc">Descending</option>
                            </select>


                        </div>
                        <div class="col-sm-6">

                            <label>Jumlah ditampilkan</label><br/>
                            <select class="form-control"  id="limitBy" onchange="searchFilter()">
                                <option value="10">10</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="150">150</option>
                                <option value="200">200</option>
                            </select>
                        </div>

                    </div>


                </div>


            </div>


        </div>
    </div>
</div>


<div class="modal fade" id="form3" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6" id="dataranga" >
                        <label for="dataranga">Dari Tanggal</label><br/>
                        <input type="text" name="dataranga" class="form-control">
                    </div>
                    <div class="col-md-6" id="datarangb" >
                        <label for="datarangb">Sampai Tanggal</label><br/>
                        <input type="text" name="datarangb" class="form-control">
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                <a href="#" id="cetak" onclick="cetak('semua')" class="btn btn-danger">Cetak</a>
            </div>

        </div>
    </div>
</div>



<div class="modal fade modal-fullscreen" id="formDialog" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-content-scroll">
            <form role="form" name="_form"  id="_form" novalidate>


                <input type="hidden" id="id" name="id" value="0"/>

                <div class="modal-header">


                    <div class="row">
                        <div class="col-md-4 col-xs-3">
                            <h4 class="modal-title"><span class="model-title-text">BARANG</span></h4>
                        </div>
                        <div class="col-md-8 col-xs-9">
                            <div class="pull-right">

                                <a href="#" onclick="submitSimpan()" class="btn btn-primary submitsimpan">Publikasi</a>

                                <a href="#" class="btn btn-danger btn-sm btn-circle" data-dismiss="modal"><i class="fas fa-times"></i></a>

                            </div>
                        </div>

                    </div>



                    <div class="clearfix"></div>


                </div>
                <div class="modal-body">



                    <div class="container-fluid">

                        <div class="row">

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group">
                                    <label>Nomor :</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" disabled name="barang_nomor" id="barang_nomor" placeholder="Masukan Nomor" value="<?php echo date('Y.m.d H.i.s'); ?>" />
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Kode :</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="barang_nomor_kode" id="barang_nomor_kode" placeholder="Masukan Nomor Kode" value="" />
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Registrasi :</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="barang_nomor_register" id="barang_nomor_register" placeholder="Masukan Nomor Registrasi" value="" />
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Nomor Seri Pabrik :</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="barang_nomor_seripabrik" id="barang_nomor_seripabrik" placeholder="Masukan Nomor Seri Pabrik" value="" />
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-6">


                                <div class="form-group">
                                    <label>Jenis Barang / Nama Barang :</label>
                                    <input  class="form-control" placeholder="Masukkan Nama Barang" id="barang_nama" name="barang_nama" maxlength="30" minlength="3" value="" />
                                </div>
                                <div class="form-group">
                                    <label>Merk/Type/Judul/Pencipta :</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="barang_merk" id="barang_merk" placeholder="Masukan Merk" value="" />
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Bahan :</label>
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="barang_bahan" id="barang_bahan" placeholder="Masukan Bahan" value="" />
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-default">
                                                <i class="glyphicon glyphicon-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <div class="col-md-3 col-sm-6">

                                <div class="form-group">
                                    <label>Ukuran :</label>
                                    <input  class="form-control" placeholder="Masukkan Ukuran" id="barang_ukuran" name="barang_ukuran" value="0" type="number" />
                                </div>

                                <div class="form-group">
                                    <label>Tahun Pembuatan/Pembelian :</label>
                                    <input  class="form-control" placeholder="Masukkan Tahun" id="barang_tahun_pembelian" name="barang_tahun_pembelian" value="<?php echo date('Y'); ?>" type="number" min="<?php echo date('Y')-10; ?>" max="<?php echo date('Y'); ?>" />
                                </div>

                                <div class="form-group">
                                    <label>Jumlah :</label>
                                    <input  class="form-control" placeholder="Masukkan Jumlah" id="barang_jumlah" name="barang_jumlah" value="1" type="number" min="1" max="200" />
                                </div>

                                <div class="form-group">
                                    <label>Harga (Rp):</label>
                                    <input  class="form-control" placeholder="Masukkan Harga" id="barang_harga" name="barang_harga" value="1000" type="number" min="1000" max="50000000" />
                                </div>


                            </div>
                            <div class="col-md-3 col-sm-6">


                                <div class="form-group">
                                    <label>Kondisi Input :</label>
                                    <select  class="form-control" name="barang_kondisi" id="barang_kondisi">
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak ringan">Rusak ringan</option>
                                        <option value="Rusak berat">Rusak berat</option>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Kondisi saat ini :</label>
                                    <select  class="form-control" name="barang_kondisi_saatini" id="barang_kondisi_saatini">
                                        <option value="Baik">Baik</option>
                                        <option value="Rusak ringan">Rusak ringan</option>
                                        <option value="Rusak berat">Rusak berat</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Katalog :</label>
                                    <select class="form-control"  name="barang_katalog">
                                        <option value="">Pilih Katalog</option>
                                        <?php foreach($this->m->getdata('katalog') as $item ){?>
                                            <option value="<?php echo $item->katalog_title?>"><?php echo $item->katalog_title?></option>
                                        <?php }?>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Lokasi :</label>
                                    <select class="form-control"  name="barang_lokasi">
                                        <option value="">Pilih Lokasi</option>
                                        <?php foreach($this->m->getdata('lokasi') as $item ){?>
                                            <option value="<?php echo $item->lokasi_title?>"><?php echo $item->lokasi_title?></option>
                                        <?php }?>
                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Keterangan :</label>
                                    <input  class="form-control" placeholder="Masukkan Keterangan" id="barang_keterangan" name="barang_keterangan" type="text" />
                                </div>
                            </div>

                        </div>


                    </div>

                </div>

            </form>

        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){			              // give $().bootstrapDP the bootstrap-datepicker functionality

        $('[name="dataranga"]').datepicker({
            format: "yyyy-mm-dd"
        });

        $('[name="datarangb"]').datepicker({
            format: "yyyy-mm-dd"
        });




        $('#_form').submit(function(e){
            var form = new FormData(this);

            e.preventDefault();
            $.ajax({
                type:'POST',
                data: form,
                url:'<?php echo base_url('index.php/admin/barang/simpan') ;?>',
                dataType:'json',
                processData :false,
                contentType :false,
                cache :false,
                async :false,
                tryCount : 0,
                retryLimit : 3,
                error : function(xhr, textStatus, errorThrown ) {
                    if (textStatus == 'timeout') {
                        this.tryCount++;
                        if (this.tryCount <= this.retryLimit) {
                            //try again
                            $.ajax(this);
                            return;
                        }
                        return;
                    }
                    if (xhr.status == 500) {
                        //handle error
                        $('#Notifikasi').html('<p class="alert alert-danger">Error 500, Terjadi gangguan server!</p>');
                        $("#Notifikasi").fadeIn('fast').show().delay(3000).fadeOut('fast');
                    } else {
                        //handle error
                    }
                },
                beforeSend: function () {
                    $('#loading_ajax').show();
                },
                success: function(hasil){
                    console.log(hasil);

                    if(hasil.status){

                        $('.buttonload').fadeOut("slow");
                        $('#loading_ajax').fadeOut("slow");
                        $('#Notifikasi').html('<p class="alert alert-success">'+hasil.pesan+'</p>');
                        $("#Notifikasi").fadeIn('fast').show().delay(3000).fadeOut('fast');

                        searchFilter();


                    }else{
                        $('.buttonload').fadeOut("slow");
                        $('#loading_ajax').fadeOut("slow");
                        $('#Notifikasi').html('<p class="alert alert-danger">'+hasil.pesan+'</p>');
                        $("#Notifikasi").fadeIn('fast').show().delay(3000).fadeOut('fast');

                    }

                    //$("#formDialog").modal('hide');


                },
                complete: function(){
                    $('#loading_ajax').fadeOut("slow");
                }
            });
        });

    });

    searchFilter(0);
    function searchFilter(page_num) {
        page_num = page_num?page_num:0;
        var keywords = $('#keywords').val();
        var sortBy = $('#sortBy').val();
        var limitBy = $('#limitBy').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>index.php/admin/barang/ajaxPaginationData/'+page_num,
            data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&limitBy='+limitBy,
            dataType:'json',
            beforeSend: function () {
                $('#loading_ajax').show();
            },
            success: function (responseData) {
                $('#pagination').html(responseData.pagination);
                paginationData(responseData.empData);
                $('#loading_ajax').fadeOut("slow");
            }
        });
    }


    function paginationData(data) {


        $('#postList0').empty();
        var nomor = 0;

        if(data.length < 1 || !data){

            var empRow = ''+
                '<div class="row">'+
                '<div class="col-md-12">'+
                '<div class="bs-callout bs-callout-danger" id="callout-glyphicons-empty-only">'+
                '<h4>Tidak ada daftar barang</h4>'+
                '<p>Daftar barang akan terlihat ketika data tersedia!.</p>'+
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
                    ' <span class="label label-default">Di '+data[emp].barang_lokasi+'</span>'+
                    ' <span class="label label-default">Merk '+data[emp].barang_merk+'</span>'+
                    ' <span class="label label-default">Tahun beli '+data[emp].barang_tahun_pembelian+'</span>'+
                    ' <span class="label label-default">Katalog '+data[emp].barang_katalog+'</span>'+
                    ' <span class="label label-default">Nomor '+data[emp].barang_nomor+'</span>'+
                    '</p><br/>'+

                    '<div class="col-md-8 col-sm-6 col-xs-8"><div class="row">'+

                    '<p><i style="color:#999">'+data[emp].barang_tanggal_diinput+' - '+data[emp].barang_tanggal_diupdate+'</i></p>'+


                    '<h4 class="list-group-item-heading name">'+ data[emp].barang_nama+'</h4>'+

                    '<p><i style="color:#999">'+data[emp].barang_kondisi_saatini+', '+data[emp].barang_keterangan+'</i></p>'+
                    '</div></div>'+
                    '<div class="col-md-4 col-sm-6 col-xs-4" style="text-align:center;"><div class="row">'+

                    '<a href="#" class="btn btn-circle btn-default">'+data[emp].barang_jumlah+'</a> '+
                    '<a title="Cetak QR Code Data" title="Cetak" onClick="formDialogCetak('+data[emp].barang_id+')" class="btn btn-circle btn-default" style="color: #577a92;" ><span class="fas fa-qrcode"></span></a>'+
                    '<a title="Ubah Data" title="Ubah" onClick="formDialog('+data[emp].barang_id+')" data-backdrop="static" data-keyboard="false" data-toggle="modal" href="#formDialog" class="btn btn-circle btn-default" style="color: #5cb85c;" ><span class="fas fa-pen"></span></a>'+
                    '<a title="Hapus" onclick="submitHapus('+data[emp].barang_id+')" class="btn btn-circle btn-default" style="color: #d9534f;"><span class="fas fa-trash"></span></a>'+



                    '</div></div>'+


                    '<div class="clearfix"></div>'+
                    '</div>';
                nomor++;
                $('#postList0').append(empRow);
            }

        }

    }


    function formDialog(id) {

        $(".model-title-text").html("TAMBAH BARANG");


        $('#id').val(0);

        $('.submitsimpan').html("");
        $('.submitsimpan').html("<i class=\"fa fa-circle-notch fa-spin buttonload\" style=\"display: none\"></i> Publikasi");
        if(id > 0){

            $(".model-title-text").html("UBAH BARANG");
            $('.submitsimpan').html("<i class=\"fa fa-circle-notch fa-spin buttonload\" style=\"display: none\"></i> Perbaharui");

            $.ajax({
                type: "GET",
                data: 'id='+id,
                url: "<?php echo site_url('admin/barang/ambildatabyid'); ?>",
                cache: false,
                dataType:'json',
                beforeSend: function () {
                    $('#loading_ajax').show();
                },
                success: function(data){
                    console.log(data);

                    $('#id').val(id);

                    $('[name="barang_nama"]').val(data.barang_nama);
                    $('[name="barang_nomor"]').val(data.barang_nomor);
                    $('[name="barang_nomor_kode"]').val(data.barang_nomor_kode);
                    $('[name="barang_nomor_register"]').val(data.barang_nomor_register);
                    $('[name="barang_nomor_seripabrik"]').val(data.barang_nomor_seripabrik);
                    $('[name="barang_merk"]').val(data.barang_merk);
                    $('[name="barang_ukuran"]').val(data.barang_ukuran);
                    $('[name="barang_bahan"]').val(data.barang_bahan);
                    $('[name="barang_tahun_pembelian"]').val(data.barang_tahun_pembelian);
                    $('[name="barang_kondisi"]').val(data.barang_kondisi);
                    $('[name="barang_jumlah"]').val(data.barang_jumlah);
                    $('[name="barang_harga"]').val(data.barang_harga);
                    $('[name="barang_keterangan"]').val(data.barang_keterangan);
                    $('[name="barang_kondisi_saatini"]').val(data.barang_kondisi_saatini);
                    $('[name="barang_katalog"]').val(data.barang_katalog);
                    $('[name="barang_lokasi"]').val(data.barang_lokasi);


                },
                complete: function(){
                    $('#loading_ajax').fadeOut("slow");
                }
            });
        }else{
            var today = new Date();
            var dd = today.getDate();

            var mm = today.getMonth() + 1;
            var yyyy = today.getFullYear();
            if (dd < 10) {
                dd = '0' + dd;
            }

            if (mm < 10) {
                mm = '0' + mm;
            }

            var hh = today.getHours();
            var ii = today.getMinutes();
            var ss = today.getSeconds();

            $('[name="barang_nomor"]').val(yyyy + '.' +mm + '.' + dd + ' ' +hh+'.'+ii+'.'+ss);

            searchFilter(0);
        }

    }


    function submitSimpan() {
        $('.buttonload').show();
        $('#loading_ajax').show();
        setTimeout(function(){
            $("#_form").submit();
        }, 0);
    }

    function submitHapus(x){
        var tanya = confirm('Apakah yakin mau hapus data?');
        if(tanya){
            $.ajax({
                type:'POST',
                data: 'id='+x,
                url:'<?php echo base_url('index.php/admin/barang/hapusdatabyid') ;?>',
                success: function(){
                    searchFilter(0);
                }
            });
        }
    }

    function formDialogCetak(x){

        window.open("<?php echo base_url();?>index.php/admin/barang/cetakqr?id="+x,'_blank');

    }
</script>