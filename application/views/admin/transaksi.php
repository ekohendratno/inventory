<div class="container-flex">

    <div class="col-sm-12 col-md-12">

        <h4><i class='fa fa-file fa-fw'></i> TRANSAKSI <i class='fa fa-angle-right fa-fw'></i> DATA TRANSAKSI TERBARU</h4>
        <hr/>
        <div class="panel-title-button pull-right">
            <a href="#formSearch" data-toggle="modal" class="btn btn-sm" title="Search"><span class="fas fa-search"></span> Cari</a>
            <a href="#formFilter" data-toggle="modal" class="btn btn-sm" title="Filter"><span class="fas fa-filter"></span> Filter</a>
            <a title="Tambah transaksi" data-backdrop="static" data-keyboard="false" href="#formDialog" data-toggle="modal" onClick="formDialog(0)" class="btn btn-sm btn-success  btn-sm btn-circle"><i class="fas fa-plus"></i></a>
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
                        <p>Total transaksi</p>
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
                        <a href="<?php echo base_url(). "admin/transaksi/index"; ?>" class="btn btn-primary">Atur Ulang Setingan</a>
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

            <div class="modal-header">


                <div class="row">
                    <div class="col-md-4 col-xs-3">
                        <h4 class="modal-title"><span class="model-title-text">Transaksi</span></h4>
                    </div>
                    <div class="col-md-8 col-xs-9">
                        <div class="pull-right">



                            <button type='button' class='btn btn-warning' id='actionCetakStruk'>Cetak (F9)</button>

                            <button type='button' class='btn btn-primary' id='actionSimpan'>Simpan (F10)</button>

                            <a href="#" title="Pengaturan" class="btn btn-default btn-sm btn-circle submitpengaturan">
                                <i class="fas fa-arrow-down"></i>
                            </a>
                            <a href="#" class="btn btn-danger btn-sm btn-circle" data-dismiss="modal"><i class="fas fa-times"></i></a>

                        </div>
                    </div>

                </div>



                <div class="clearfix"></div>

                <div class="container container-medium">

                    <div class="col-md-12">
                        <div id="pengaturan" class="row" style="padding-top: 30px">

                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="control-label">No. Nota</label>
                                    <input type='text' name='nomor_nota' class='form-control input-sm' id='nomor_nota' value="<?php echo strtoupper(uniqid()).$this->session->userdata('ap_id_user'); ?>" readonly>

                                </div>

                            </div>


                            <div class="col-md-6">

                                <div class="form-group">
                                    <label class="control-label">Tanggal</label>
                                    <input type='text' name='tanggal' class='form-control input-sm' id='tanggal' value="<?php echo date('Y-m-d H:i:s'); ?>" disabled>
                                </div>

                            </div>

                            <br>

                            <div class="text-right" style="display: none">
                                <a href="javascript:void();" class="btn btn-default submitpengaturanhide">Sembunyikan</a>
                            </div>


                        </div>
                    </div>

                </div>


            </div>
            <div class="modal-body">



                <div class="container container-medium">

                    <table class='table table-hover' id='TabelTransaksi'>
                        <thead>
                        <tr>
                            <th style='width:25px;'>#</th>
                            <th style='width:260px;'>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th style='width:75px;'>Qty</th>
                            <th style='width:40px;'></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>

                    <div class='alert alert-warning TotalBayar'>
                        <button id='BarisBaru' class='btn btn-default pull-left'>Tambah Baris Baru (F7)</button>
                        <h2>Total jumlah barang : <span id='TotalBayar'>0</span></h2>
                        <input type="hidden" id='TotalBayarHidden'>
                    </div>

                    <div class='row'>
                        <div class='col-sm-7'>
                            <textarea name='catatan' id='catatan' class='form-control' rows='2' placeholder="Catatan Transaksi (Jika Ada)" style='resize: vertical; width:83%;'></textarea>

                            <br />
                            <p><i class='fa fa-keyboard fa-fw'></i> <b>Shortcut Keyboard : </b></p>
                            <div class='row'>
                                <div class='col-sm-6'>F7 = Tambah baris baru</div>
                                <div class='col-sm-6'>F9 = Cetak Struk</div>
                                <div class='col-sm-6'>F8 = Fokus ke field bayar</div>
                                <div class='col-sm-6'>F10 = Simpan Transaksi</div>
                            </div>
                        </div>
                        <div class='col-sm-5'>
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Peminjam</label>
                                    <div class="col-sm-6">
                                        <input type='text' name='Peminjam' id='Peminjam' class='form-control'>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>



                </div>

            </div>


        </div>
    </div>
</div>


<div class="modal fade modal-fullscreen" id="formDialogDetail" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content modal-content-scroll">

            <div class="modal-header">


                <div class="row">
                    <div class="col-md-4 col-xs-3">
                        <h4 class="modal-title"><span class="model-title-text">Transaksi Detail</span></h4>
                    </div>
                    <div class="col-md-8 col-xs-9">
                        <div class="pull-right">


                            <a href="#" class="btn btn-danger btn-sm btn-circle" data-dismiss="modal"><i class="fas fa-times"></i></a>

                        </div>
                    </div>

                </div>



                <div class="clearfix"></div>


            </div>
            <div class="modal-body">



                <div class="container container-medium">


                    <div id="postList1" class="list-group" style="font-size: 18px"></div>


                </div>

            </div>


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

        $(".submitpengaturanhide").click(function(){
            $("#pengaturan").hide(300);
        });


        $(".submitpengaturan").click(function(){
            var side = $(".submitpengaturan .fa-arrow-up").attr('class');
            if(side){
                $(".submitpengaturan .fa-arrow-up").removeClass("fa-arrow-up").addClass("fa-arrow-down");
            }else{
                $(".submitpengaturan .fa-arrow-down").removeClass("fa-arrow-down").addClass("fa-arrow-up");
            }

            $("#pengaturan").slideToggle();
        });


        for(B=1; B<=1; B++){
            BarisBaru();
        }


        $('#BarisBaru').click(function(){
            BarisBaru();
        });

        $("#TabelTransaksi tbody").find('input[type=text],textarea,select').filter(':visible:first').focus();

    });


    function BarisBaru(){
        var Nomor = $('#TabelTransaksi tbody tr').length + 1;
        var Baris = "<tr>";
        Baris += "<td>"+Nomor+"</td>";
        Baris += "<td>";
        Baris += "<input type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode / Nama Barang'>";
        Baris += "<div id='hasil_pencarian'></div>";
        Baris += "</td>";
        Baris += "<td></td>";
        Baris += "<td><input min='1' type='number' class='form-control' id='jumlah_barang' name='jumlah_barang[]' onkeypress='return check_int(event)' disabled></td>";
        Baris += "<td><button class='btn btn-sm btn-default btn-circle' id='HapusBaris'><i class='fa fa-times' style='color:red;'></i></button></td>";
        Baris += "</tr>";

        $('#TabelTransaksi tbody').append(Baris);

        $('#TabelTransaksi tbody tr').each(function(){
            $(this).find('td:nth-child(2) input').focus();
        });

        HitungTotalBarang();
    }

    function AutoCompleteGue(Lebar, KataKunci, Indexnya) {
        $('div#hasil_pencarian').hide();
        var Lebar = Lebar + 25;

        var Registered = '';
        $('#TabelTransaksi tbody tr').each(function(){
            if(Indexnya !== $(this).index())
            {
                if($(this).find('td:nth-child(2) input').val() !== '')
                {
                    Registered += $(this).find('td:nth-child(2) input').val() + ',';
                }
            }
        });

        if(Registered !== ''){
            Registered = Registered.replace(/,\s*$/,"");
        }

        $.ajax({
            url: "<?php echo site_url('admin/transaksi/barang_kode'); ?>",
            type: "POST",
            cache: false,
            data:'keyword=' + KataKunci + '&registered=' + Registered,
            dataType:'json',
            success: function(json){
                if(json.status == 1)
                {
                    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').css({ 'width' : Lebar+'px' });
                    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
                    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(json.datanya);
                }
                if(json.status == 0)
                {
                    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
                    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').prop('disabled', true).val('');
                }
            }
        });

        HitungTotalBarang();
    }

    function SimpanTransaksi() {
        var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
        FormData += "&tanggal="+encodeURI($('#tanggal').val());
        FormData += "&" + $('#TabelTransaksi tbody input').serialize();
        FormData += "&peminjam="+$('#Peminjam').val();
        FormData += "&catatan="+encodeURI($('#catatan').val());
        FormData += "&grand_total="+$('#TotalBayarHidden').val();

        //console.log(FormData);

        $('#ModalGue').modal('hide');

        $.ajax({
            type:'POST',
            data: FormData,
            url:'<?php echo base_url('index.php/admin/transaksi/simpan') ;?>',
            dataType:'json',
            cache :false,
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


    }



    $(document).on('click', '#HapusBaris', function(e){
        e.preventDefault();
        $(this).parent().parent().remove();

        var Nomor = 1;
        $('#TabelTransaksi tbody tr').each(function(){
            $(this).find('td:nth-child(1)').html(Nomor);
            Nomor++;
        });

        HitungTotalBarang();
    });

    $(document).on('keyup', '#pencarian_kode', function(e){
        if($(this).val() !== '')
        {
            var charCode = e.which || e.keyCode;
            if(charCode == 40)
            {
                if($('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0)
                {
                    var Selanjutnya = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').next();
                    $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');

                    Selanjutnya.addClass('autocomplete_active');
                }
                else
                {
                    $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
                }
            }
            else if(charCode == 38)
            {
                if($('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0)
                {
                    var Sebelumnya = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').prev();
                    $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');

                    Sebelumnya.addClass('autocomplete_active');
                }
                else
                {
                    $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
                }
            }
            else if(charCode == 13)
            {
                var Field = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)');
                var Kodenya = Field.find('div#hasil_pencarian li.autocomplete_active span#kodenya').html();
                var Barangnya = Field.find('div#hasil_pencarian li.autocomplete_active span#barangnya').html();
                var Harganya = Field.find('div#hasil_pencarian li.autocomplete_active span#harganya').html();

                Field.find('div#hasil_pencarian').hide();
                Field.find('input').val(Kodenya);

                $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(3)').html(Barangnya);
                $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) input').removeAttr('disabled').val(1);

                var IndexIni = $(this).parent().parent().index() + 1;
                var TotalIndex = $('#TabelTransaksi tbody tr').length;
                if(IndexIni == TotalIndex){
                    BarisBaru();

                    $('html, body').animate({ scrollTop: $(document).height() }, 0);
                }
                else {
                    $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) input').focus();
                }
            }
            else
            {
                AutoCompleteGue($(this).width(), $(this).val(), $(this).parent().parent().index());
            }
        }
        else
        {
            $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian').hide();
        }

        HitungTotalBarang();
    });

    $(document).on('click', '#daftar-autocomplete li', function(){
        $(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());

        var Indexnya = $(this).parent().parent().parent().parent().index();
        var NamaBarang = $(this).find('span#barangnya').html();
        var Harganya = $(this).find('span#harganya').html();

        $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
        $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang);
        $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').removeAttr('disabled').val(1);

        var IndexIni = Indexnya + 1;
        var TotalIndex = $('#TabelTransaksi tbody tr').length;
        if(IndexIni == TotalIndex){
            BarisBaru();
            $('html, body').animate({ scrollTop: $(document).height() }, 0);
        }
        else {
            $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').focus();
        }

        HitungTotalBarang();
    });

    $(document).on('change', '#jumlah_barang', function(){
        var Indexnya = $(this).parent().parent().index();
        var JumlahBeli = $(this).val();
        var KodeBarang = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();

        $.ajax({
            url: "<?php echo site_url('admin/barang/stok'); ?>",
            type: "GET",
            cache: false,
            data: "kode="+encodeURI(KodeBarang)+"&stok="+JumlahBeli,
            dataType:'json',
            success: function(data){
                if(data.status == 1)
                {
                    var SubTotal = parseInt(JumlahBeli);
                    if(SubTotal > 0){
                        var SubTotalVal = SubTotal;
                        SubTotal = SubTotal;
                    } else {
                        SubTotal = '';
                        var SubTotalVal = 0;
                    }

                    //$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(SubTotalVal);
                    //$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) span').html(SubTotal);
                    HitungTotalBarang();
                }
                if(data.status == 0)
                {
                    $('.modal-dialog').removeClass('modal-lg');
                    $('.modal-dialog').addClass('modal-sm');
                    $('#ModalHeader').html('Oops !');
                    $('#ModalContent').html(data.pesan);
                    $('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
                    $('#ModalGue').modal('show');

                    var JumlahBeliBalik = JumlahBeli-1;
                    $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(JumlahBeliBalik);
                }
            }
        });
    });

    $(document).on('keyup', '#jumlah_barang', function(e){
        var charCode = e.which || e.keyCode;
        if(charCode == 9){
            var Indexnya = $(this).parent().parent().index() + 1;
            var TotalIndex = $('#TabelTransaksi tbody tr').length;
            if(Indexnya == TotalIndex){
                BarisBaru();
                return false;
            }
        }

        HitungTotalBarang();
    });


    $(document).on('click', '#actionSimpan', function(){
        $('.modal-dialog').removeClass('modal-lg');
        $('.modal-dialog').addClass('modal-sm');
        $('#ModalHeader').html('Konfirmasi');
        $('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
        $('#ModalFooter').html("<button type='button' class='btn btn-primary' id='actionSimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
        $('#ModalGue').modal('show');

        setTimeout(function(){
            $('button#actionSimpanTransaksi').focus();
        }, 500);
    });

    $(document).on('click', 'button#actionSimpanTransaksi', function(){
        SimpanTransaksi();
    });


    function check_int(evt) {
        var charCode = ( evt.which ) ? evt.which : event.keyCode;
        return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
    }


    function HitungTotalBarang() {
        var Total = 0;
        $('#TabelTransaksi tbody tr').each(function(){
            if($(this).find('td:nth-child(4) input').val() > 0)
            {
                var SubTotal = $(this).find('td:nth-child(4) input').val();
                Total = parseInt(Total) + parseInt(SubTotal);
            }
        });

        $('#TotalBayar').html(Total);
        $('#TotalBayarHidden').val(Total);

        $('#Peminjam').val('');
    }









    searchFilter(0);
    function searchFilter(page_num) {
        page_num = page_num?page_num:0;
        var keywords = $('#keywords').val();
        var sortBy = $('#sortBy').val();
        var limitBy = $('#limitBy').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>index.php/admin/transaksi/ajaxPaginationData/'+page_num,
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
                    ' <span class="label label-default">Tanggal pinjam '+data[emp].transaksi_tanggal_pinjam+'</span>'+
                    ' <span class="label label-default">Tanggal kembali '+data[emp].transaksi_tanggal_kembali+'</span>'+
                    ' <span class="label label-default">'+data[emp].transaksi_jumlah+' barang</span>'+
                    '</p><br/>'+

                    '<div class="col-md-8 col-sm-6 col-xs-8"><div class="row">'+

                    '<p><i style="color:#999">'+data[emp].transaksi_peminjam+'</i></p>'+

                    '<a title="Data Detail" title="Detail" onClick="formDialogDetail(\''+data[emp].transaksi_nota+'\')" data-backdrop="static" data-keyboard="false" data-toggle="modal" href="#formDialogDetail" ><h4 class="list-group-item-heading name"><i class="fas fa-file"></i> '+ data[emp].transaksi_nota+'</h4></a>'+

                    '<p><i style="color:#999">'+data[emp].transaksi_keterangan+'</i></p>'+
                    '</div></div>'+
                    '<div class="col-md-4 col-sm-6 col-xs-4" style="text-align:center;"><div class="row">'+


                    //'<a title="Ubah Data" title="Ubah" onClick="formDialog('+data[emp].transaksi_id+')" data-backdrop="static" data-keyboard="false" data-toggle="modal" href="#formDialog" class="btn btn-circle btn-default" style="color: #5cb85c;" ><span class="fas fa-pen"></span></a>'+
                    '<a title="Hapus" onclick="submitHapus('+data[emp].transaksi_id+')" class="btn btn-circle btn-default" style="color: #d9534f;"><span class="fas fa-trash"></span></a>'+



                    '</div></div>'+


                    '<div class="clearfix"></div>'+
                    '</div>';
                nomor++;
                $('#postList0').append(empRow);
            }

        }

    }


    function formDialog(id) {

        $(".model-title-text").html("TAMBAH TRANSAKSI");

        $("#pengaturan").hide();

        $('#id').val(0);

        $('.submitsimpan').html("");
        $('.submitsimpan').html("<i class=\"fa fa-circle-notch fa-spin buttonload\" style=\"display: none\"></i> Publikasi");
        if(id > 0){

            $(".model-title-text").html("UBAH TRANSAKSI");
            $(".submitpengaturan .fa-arrow-up").removeClass("fa-arrow-up").addClass("fa-arrow-down");
            $("#pengaturan").hide();

            $('.submitsimpan').html("<i class=\"fa fa-circle-notch fa-spin buttonload\" style=\"display: none\"></i> Perbaharui");

            $.ajax({
                type: "GET",
                data: 'id='+id,
                url: "<?php echo site_url('admin/transaksi/ambildatabyid'); ?>",
                cache: false,
                dataType:'json',
                beforeSend: function () {
                    $('#loading_ajax').show();
                },
                success: function(data){
                    console.log(data);

                    $('#id').val(id);

                    $('[name="transaksi_nama"]').val(data.transaksi_nama);
                    $('[name="transaksi_nomor"]').val(data.transaksi_nomor);
                    $('[name="transaksi_nomor_kode"]').val(data.transaksi_nomor_kode);
                    $('[name="transaksi_nomor_register"]').val(data.transaksi_nomor_register);
                    $('[name="transaksi_nomor_seripabrik"]').val(data.transaksi_nomor_seripabrik);
                    $('[name="transaksi_merk"]').val(data.transaksi_merk);
                    $('[name="transaksi_ukuran"]').val(data.transaksi_ukuran);
                    $('[name="transaksi_bahan"]').val(data.transaksi_bahan);
                    $('[name="transaksi_tahun_pembelian"]').val(data.transaksi_tahun_pembelian);
                    $('[name="transaksi_kondisi"]').val(data.transaksi_kondisi);
                    $('[name="transaksi_jumlah"]').val(data.transaksi_jumlah);
                    $('[name="transaksi_harga"]').val(data.transaksi_harga);
                    $('[name="transaksi_keterangan"]').val(data.transaksi_keterangan);
                    $('[name="transaksi_kondisi_saatini"]').val(data.transaksi_kondisi_saatini);
                    $('[name="transaksi_katalog"]').val(data.transaksi_katalog);
                    $('[name="transaksi_lokasi"]').val(data.transaksi_lokasi);


                },
                complete: function(){
                    $('#loading_ajax').fadeOut("slow");
                }
            });
        }else{


            searchFilter(0);
        }

    }





    function formDialogDetail(nota) {

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>index.php/admin/transaksi/transaksi_detail',
            data:'notaBy='+nota,
            dataType:'json',
            beforeSend: function () {
                $('#loading_ajax').show();
            },
            success: function (responseData) {
                paginationDataDetail(responseData);
                $('#loading_ajax').fadeOut("slow");
            }
        });
    }

    function paginationDataDetail(data) {
        $('#postList1').empty();
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
            $('#postList1').append(empRow);
        }else{
            //console.log(data[0].barang[0].barang_jumlah);


            for(emp1 in data[0].barang){


                var empRow = '<div class="list-group-item">'+
                    '<p class="list-group-item-text title" style="text-align:center;">'+
                    '</p><br/>'+

                    '<div class="col-md-8 col-sm-6 col-xs-8"><div class="row">'+


                    '<h4 class="list-group-item-heading name">'+ data[0].barang[emp1].barang_nama+'</h4>'+

                    '</div></div>'+
                    '<div class="col-md-4 col-sm-6 col-xs-4" style="text-align:center;"><div class="row">'+


                    '<a href="#" class="btn btn-circle btn-default" >'+data[0].barang[emp1].barang_jumlah+'</a>'+


                    '</div></div>'+


                    '<div class="clearfix"></div>'+
                    '</div>';
                nomor++;
                $('#postList1').append(empRow);
            }

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
                url:'<?php echo base_url('index.php/admin/transaksi/hapusdatabyid') ;?>',
                success: function(){
                    searchFilter(0);
                }
            });
        }
    }

    function cetak(x){

        if(x == 'semua'){

            var ranga = $('[name="dataranga"]').val();
            var rangb = $('[name="datarangb"]').val();

            window.open("<?php echo base_url();?>index.php/admin/transaksi/cetak?ranga="+ranga+"&rangb="+rangb,'_blank');

        }else{

            window.open("<?php echo base_url();?>index.php/admin/transaksi/cetak?id="+x,'_blank');

        }

    }
</script>

<style type="text/css">

    #daftar-autocomplete {
        list-style:none;
        margin:0;
        padding:0;
        width:100%;
    }

    #daftar-autocomplete li {
        padding: 5px 10px 5px 10px;
        background:#FAFAFA;
        border-bottom:#ddd 1px solid;
    }

    #daftar-autocomplete li:hover,
    #daftar-autocomplete li.autocomplete_active {
        background:#2a84ae;
        color:#fff;
        cursor: pointer;
    }

    #hasil_pencarian{
        padding: 0px;
        display: none;
        position: absolute;
        max-height: 350px;
        overflow: auto;
        border:1px solid #ddd;
        z-index: 1;
    }


    .TotalBayar {
        text-align: right;
        margin-bottom: 20px;
    }

    .TotalBayar h2 {
        margin-top: 0px;
        margin-bottom: 0px;
    }
</style>