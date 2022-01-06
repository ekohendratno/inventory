<div class="container-flex">
    <div class="col-md-8">
        <div class="panel panel-default">
            <div class="panel-body" style="min-height:800px;">

                <h4><i class='fa fa-user fa-fw'></i> Akun <i class='fa fa-angle-right fa-fw'></i> Data Akun Ujian</h4>
                <hr />
                <div class="panel-title-button pull-right">
                    <a href="#formsearch" data-toggle="modal" class="btn" title="Filter"><span class="fas fa-search"></span></a>
                    <a href="#form2" data-toggle="modal" class="btn" title="Filter"><span class="fas fa-filter"></span></a>
                    <a href="#" onclick="cetakshow()" class="btn" title="Buat Kartu"><span class="fas fa-address-card"></span></a>
                    <a href="#" onclick="cetakhadir()" class="btn" title="Buat Daftar Hadir"><span class="fas fa-calendar-check"></span></a>
                    <a style="display: none" href="javascript:void(0);" onClick="resetData()" class="btn" title="Reset"><span class="fas fa-refresh"></span></a>
                    <a href="#form" data-toggle="modal" onclick="submit('tambah')" class="btn btn-sm btn-success" style="color:#fff;margin-top: -5px;" title="Tambah User"><span class="fas fa-plus"></span> Tambah User</a>
                </div>



                <div class="panel-body2">

                    <table id='postList' class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th width="50" class="text-center">NO</th>
                            <th class="text-center" width="100">FOTO</th>
                            <th>NAMA</th>
                            <th class="text-center" width="100"><span class="fas fa-cog"></span></th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                    <div id='pagination'></div>

                    <div class="modal fade" id="formsearch" role="dialog">
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

                                        <div class="clear"></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade modal-fullscreen" id="form" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">


                                <div class="modal-header">
                                    <h4 class="modal-title">Akun
                                        <div class="pull-right">
                                            <button onclick="tambahdata()" type="button" id="btn-tambah" class="btn btn-primary">Tambah</button>
                                            <button onclick="simpandata()" type="button" id="btn-ubah" class="btn btn-primary">Ubah</button>
                                            <button class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>

                                    </h4>
                                </div>
                                <div class="modal-body">
                                    <div class="col-md-8 col-md-offset-2">

                                    <div class="modal-status"></div>

                                    <input type="hidden" name="user_id" value="" />

                                    <label>Nama Akun</label>
                                    <input type="text" name="username" class="form-control" />

                                    <label>Kata Sandi</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="password" id="password">
                                        <span class="input-group-btn">
                                                    <button class="btn btn-success" onClick="generatepassword()"><span class="fas fa-key"></span> Generate Sandi</button>
                                                </span>
                                    </div>


                                    <label>Level</label>
                                    <select class="form-control" name="level"  id="level">
                                        <option value="siswa">Siswa</option>
                                        <option value="pengawas">Pengawas</option>
                                        <option value="admin">Admin</option>
                                    </select>


                                    </div>

                                </div>



                            </div>
                        </div>
                    </div>

                    <div class="modal fade modal-fullscreen" id="form1" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">

                                <div class="modal-header">
                                    <h4 class="modal-title">Kartu Akun
                                        <div class="pull-right">
                                            <a href="#" onclick="cetak()" class="btn btn-danger">Cetak</a>
                                            <button class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>

                                    </h4>
                                </div>
                                <div class="modal-body">

                                    <div class="col-md-8 col-md-offset-2">

                                    <label>Untuk</label><br/>
                                    <select class="form-control"  id="datauntuk">
                                        <option value="">Ujian</option>
                                        <option value="demo">Demo</option>
                                        <option value="nomor">Nomor</option>
                                    </select>
                                    <label>Kustom</label><br/>
                                    <input type="text" name="datauntukkustom" class="form-control" />

                                    <br/><br/>
                                    <label>Kelas</label><br/>
                                    <div class="input-group">
												  <span class="input-group-addon">
													<span class="glyphicon glyphicon-search"></span>
												  </span>
                                        <input type="text" name="siswa_kelas" class="form-control" />
                                    </div>

                                    <label>Jurusan</label><br/>
                                    <div class="input-group">
												  <span class="input-group-addon">
													<span class="glyphicon glyphicon-search"></span>
												  </span>
                                        <input type="text" name="siswa_jurusan" class="form-control" />
                                    </div>

                                    <label>Ruang</label><br/>
                                    <div class="input-group">
												  <span class="input-group-addon">
													<span class="glyphicon glyphicon-search"></span>
												  </span>
                                        <input type="text" name="siswa_jurusan_ke" class="form-control" />
                                    </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="modal fade modal-fullscreen" id="form2" role="dialog">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Filter Siswa
                                        <div class="pull-right">
                                            <a href="<?php echo base_url(). "admin/users/index"; ?>" class="btn btn-primary">Show All</a>
                                            <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                                        </div>
                                    </h4>
                                </div>
                                <div class="modal-body">

                                    <div class="col-md-8 col-md-offset-2">

                                    <label>Urutkan</label><br/>
                                    <select class="form-control"  id="sortBy" onchange="searchFilter()">
                                        <option value="">Sort By</option>
                                        <option value="asc">Ascending</option>
                                        <option value="desc">Descending</option>
                                    </select>

                                    <label>Jumlah ditampilkan</label><br/>
                                    <select class="form-control"  id="limitBy" onchange="searchFilter()">
                                        <option value="10">10</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                        <option value="150">150</option>
                                        <option value="200">200</option>
                                    </select>

                                    <label>Level</label><br/>
                                    <select class="form-control"  id="levelBy" onchange="searchFilter()">
                                        <option value="siswa">Siswa</option>
                                        <option value="admin">Admin</option>
                                        <option value="pengawas">Pengawas</option>
                                    </select>

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


    <div class="col-md-4">

        <div class="row">
            <div class="col-md-12">
                <div class="small-box bg-light">
                    <div class="inner">
                        <h3><?php echo 0;?></h3>
                        <p>Total Pelajaran</p>
                    </div>
                    <div class="inner">
                        <h3><?php echo 0;?>/<?php echo 0;?>/<?php echo 0;?></h3>
                        <p>Hari ini/Kemarin/Total Diujikan</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                </div>
            </div>
        </div>



    </div>


</div>


<script type="text/javascript">

        $('#formsearch').on('shown.bs.modal', function() {
            $('#keywords').trigger('focus');
        });
        $(document).ready(function() {
            $("[name='siswa_kelas']").autocomplete({
                source: "<?php echo site_url('sugest/kelas?');?>"
            });
            $("[name='siswa_jurusan']").autocomplete({
                source: "<?php echo site_url('sugest/jurusan?');?>"
            });
            $("[name='siswa_jurusan_ke']").autocomplete({
                source: "<?php echo site_url('sugest/jurusan_ke?');?>"
            });


			$(".selector").keyup(function(){ // Ketika user menekan tombol di keyboard
				if(event.keyCode == 13){ // Jika user menekan tombol ENTER
				   // Panggil function search
					$('#loading_ajax').show();
				}
			  });
			$(".selector").autocomplete({
				source: "<?php echo base_url()?>admin/users/autocompleteData",
				minLength: 1,
				select: function(event, ui) {
					$(".selector").val(ui.item.value);
					$("#siswa_id").val(ui.item.id);
				}
			}).data("ui-autocomplete")._renderItem = function( ul, item ) {
			return $( "<li class='ui-autocomplete-row'></li>" )
				.data( "item.autocomplete", item )
				.append( item.label )
				.appendTo( ul );
			};
		});

		searchFilter(0);
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			var keywords = $('#keywords').val();
			var sortBy = $('#sortBy').val();
			var limitBy = $('#limitBy').val();
			var levelBy = $('#levelBy').val();
			var jurusanBy = $('#jurusanBy').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>admin/users/ajaxPaginationData/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&limitBy='+limitBy+'&levelBy='+levelBy+'&jurusanBy='+jurusanBy,
				dataType:'json',
				beforeSend: function () {
					$('#loading_ajax').show();
				},
				success: function (responseData) {
					//console.log(responseData);
					$('#pagination').html(responseData.pagination);
					paginationData(responseData.empData);
					$('#loading_ajax').fadeOut("slow");
				}
			});
		}

		function paginationData(data) {
			$('#postList tbody').empty();
			var nomor = 1;
			for(emp in data){

				var connect_to = '<span class="label label-warning">N</span>';
				if(data[emp].id != ''){
					connect_to = '<span class="label label-success">Y</span>';
				}

				var avatar = data[emp].foto;
				if(data[emp].foto == ''){
					avatar = "<?php echo base_url()?>img/avatar.png";
				}

				var kelas = data[emp].kelas_sekarang;
				var level  = data[emp].level;



				var sex = '';

				if(data[emp].jk == 'L'){
					sex = '<span class="label label-success">L</span>';
				}else if(sex == 'P'){
					sex = '<span class="label label-warning">P</span>';
				}


				var nama = data[emp].nama;
				if(nama == '') nama = 'Admin/Pengawas';

				var empRow = '<tr>'+
							'<td class="text-center">'+nomor+'</td>'+
							'<td class="text-center"><img src="'+avatar+'" style="width: 60px; border:1px solid #ddd;"/></td>'+
							'<td>'+nama+'<br/>'+sex+' <span class="label label-default">'+data[emp].username+'</span> <span class="label label-default">'+data[emp].password+'</span></td>'+

							'<td class="text-center"><a href="#form" data-toggle="modal" onclick="submit('+data[emp].user_id+')" class="btn" style="color: #5cb85c;" ><span class="fas fa-pen"></span></a> <a onclick="hapus('+data[emp].user_id+')" class="btn" style="color: #d9534f;"><span class="fas fa-trash"></span></a></td>'+
							+'</tr>';
				nomor++;
				$('#postList tbody').append(empRow);
			}
		}


        function generatepassword(){
            $('#loading_ajax').show();
            var nama = $("[name='username']").val();
            if(nama != ''){
                //console.log(nama);
                $.ajax({
                    type:'POST',
                    data: 'string='+nama,
                    url:'<?php echo base_url('admin/users/generateuser') ;?>',
                    dataType:'json',
                    success: function(hasil){
                        $('#loading_ajax').fadeOut("slow");

                        //$("#username").val(hasil.username);
                        $("#password").val(hasil.password);
                    }
                });
            }else{
                $('#loading_ajax').fadeOut("slow");
                alert('Maaf User Name Kosong, harap disini');
            }
        }

		function tambahdata(){
			$('#loading_ajax').show();
			var username =  $("[name='username']").val();
			var password =  $("[name='password']").val();
            var level =  $("[name='level']").val();

			$.ajax({
				type:'POST',
				data: 'level='+level+'&username='+username+'&password='+password,
				url:'<?php echo base_url('admin/users/tambahdata') ;?>',
				dataType:'json',
				success: function(hasil){
					$('#loading_ajax').fadeOut("slow");
					$('.modal-status').show();
					$('.modal-status').html('<p class="bg-warning">'+hasil.pesan+'</p>');

					if(hasil.pesan == ''){
						$('#form').modal('hide');
						searchFilter(0);

						//bersihkan form
						$("[name='username']").val('');
						$("[name='password']").val('');
						$("[name='level']").val('');
					}
				}
			});
		}

		function submit(x){
			//bersihkan form
			$("[name='user_id']").val('');
			$("[name='username']").val('');
			$("[name='password']").val('');
			/*$("#nama").val('');
			$("#jk").val('');
			$("#kelas_sekarang").val('');
			$("#jurusan_id").val('');
			$("#ruang").val('');

			$("#avatar").empty();
			$("#avatar").hide();*/
			$('.modal-status').hide();
			if(x == 'tambah'){
				$('#btn-tambah').show();
				$('#btn-ubah').hide();
			}else{
				$('#loading_ajax').show();
				$('#btn-tambah').hide();
				$('#btn-ubah').show();


				$.ajax({
					type:'POST',
					data: 'id='+x,
					url:'<?php echo base_url('admin/users/ambildatabyid') ;?>',
					dataType:'json',
					success: function(hasil){
						console.log(hasil);
						$('#loading_ajax').fadeOut("slow");

						$("[name='user_id']").val(hasil.user_id);
						$("[name='username']").val(hasil.username);
						$("[name='password']").val(hasil.password);
                        $("[name='level']").val(hasil.level);
                        /*$("#nama").val(hasil.nama);
                        $("#jk").val(hasil.jk);
                        $("#kelas_sekarang").val(hasil.kelas_sekarang);
                        $("#jurusan_id").val(hasil.jurusan_id);
                        $("#ruang").val(hasil.ruang);

						if(hasil.foto != ''){
							$("#avatar").show();
							$("#avatar").append('<img src="'+hasil.foto+'" style="border:1px solid #ddd; width: 120px;"/>');
						}*/
					}
				});
			}
		}

		function simpandata(){
			$('#loading_ajax').show();
			var user_id =  $("[name='user_id']").val();
            var username =  $("[name='username']").val();
            var password =  $("[name='password']").val();
            var level =  $("[name='level']").val();

			$.ajax({
				type:'POST',
				data: 'user_id='+user_id+'&level='+level+'&username='+username+'&password='+password,
				url:'<?php echo base_url('admin/users/simpandatabyid') ;?>',
				dataType:'json',
				success: function(hasil){
					$('#loading_ajax').fadeOut("slow");
					$('.modal-status').show();
					$('.modal-status').html('<p class="bg-warning">'+hasil.pesan+'</p>');

					if(hasil.pesan == ''){
						$('#form').modal('hide');
						searchFilter();
					}
				}
			});
		}


		function cetak(){

            var untuk = $('#datauntuk').val();
            var kustom = $("[name='datauntukkustom']").val();
            var siswa_kelas = $("[name='siswa_kelas']").val();
			var siswa_jurusan = $("[name='siswa_jurusan']").val();
			var siswa_jurusan_ke = $("[name='siswa_jurusan_ke']").val();

			window.open("<?php echo base_url();?>admin/users/cetak?kelas="+siswa_kelas+"&jurusan="+siswa_jurusan+"&ke="+siswa_jurusan_ke+"&untuk="+untuk+"&kustom="+kustom,'_blank');

		}

		function cetakshow(){
			var levelBy = $('#levelBy').val();

            if(levelBy == 'pengawas' ){
                window.open("<?php echo base_url();?>admin/users/cetakpengawas",'_blank');
            }else if(levelBy == 'guru' ){
				window.open("<?php echo base_url();?>admin/users/cetakguru",'_blank');
			}else{

				$('#form1').modal('show');

			}
		}

        function cetakhadir(){
            var levelBy = $('#levelBy').val();

            if(levelBy == 'pengawas' ){
                window.open("<?php echo base_url();?>admin/users/cetakpengawas?hadir=1",'_blank');
            }else{
                window.open("<?php echo base_url();?>admin/users/cetaksiswa",'_blank');
            }
        }

		function hapus(x){
			$('#loading_ajax').show();
			var tanya = confirm('Apakah yakin mau hapus data?');
			if(tanya){
				$.ajax({
				type:'POST',
				data: 'id='+x,
				url:'<?php echo base_url('admin/users/hapusdatabyid') ;?>',
				success: function(){
					searchFilter(0);
				}
			});
			}else{
				$('#loading_ajax').fadeOut("slow");
			}
		}

        function  resetData() {

            $('#loading_ajax').show();
            var tanya = confirm('Apakah yakin mau hapus data?');
            if(tanya){
                $.ajax({
                    type:'POST',
                    url:'<?php echo base_url('admin/users/resetdata') ;?>',
                    beforeSend: function () {
                        $('#loading_ajax').show();
                    },
                    success: function(){
                        $('#loading_ajax').fadeOut("slow");
                        searchFilter(0);
                        window.location.assign("<?php echo base_url();?>auth/logout");
                    }
                });
            }
        }

	</script>