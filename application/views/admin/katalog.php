<div class="container">


        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-4">
				<div class="panel panel-default">
					<div class="panel-body">
						<label>Judul Katalog</label>
						<input type="text" name="katalog_title" class="form-control" />
						<input type="hidden" name="id" value="" /><br>
						<label>Kode Katalog</label>
						<input type="text" name="katalog_kd" class="form-control" /><br>
						<div class="text-right">
							<button onclick="tambahdata()" type="button" id="btn-tambah" class="btn btn-primary">Tambah</button>
							<button onclick="submit('tambah')" type="button" id="btn-baru" class="btn btn-default">Baru</button>
							<button onclick="simpandata()" type="button" id="btn-ubah" class="btn btn-primary">Ubah</button> 
						</div>
					</div>
				</div>
			</div>
            <div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading text-center">
						<b>DATA KATALOG</b>
					</div>
					<div class="panel-body">

						
						<div class="row">
									<div class="col-md-4">
										<input class="form-control" type="text" id="keywords" placeholder="Type keywords to filter posts" onkeyup="searchFilter()"/>
									</div>
									<div class="col-md-4">										
										<a href="#form2" data-toggle="modal" class="btn btn-warning"><span class="glyphicon glyphicon-filter"></span> Filter</a>
										<a href="<?php echo base_url(). "index.php/admin/katalog/index"; ?>" class="btn btn-primary">Show All</a>
									</div>
						</div>
						<br/>
						<table id='postList' class="table table-striped table-hover table-bordered">
									<thead>				
										<tr>
											<th class="text-center">NO</th>
											<th class="text-center">JUDUL KATALOG</th>
											<th class="text-center">KODE KATALOG</th>
											<th class="text-center" width="150"><span class="glyphicon glyphicon-cog"></span></th>
										</tr>
									</thead>
									<tbody></tbody>		
						</table>
						<div id='pagination'></div>
						

						
						<div class="modal fade" id="form2" role="dialog">
							<div class="modal-dialog modal-smn">
								<div class="modal-content">
									<div class="modal-body">
										<div class="row">
											
											
										<div class="col-md-6">
											<label for="sortBy">Urutkan</label><br/>
											<select class="form-control"  id="sortBy" onchange="searchFilter()">
												<option value="">Sort By</option>
												<option value="asc">Ascending</option>
												<option value="desc">Descending</option>
											</select>
										</div>
										<div class="col-md-6">
											<label for="limitBy">Limit</label><br/>
											<select class="form-control"  id="limitBy" onchange="searchFilter()">
												<option value="10">10</option>
												<option value="30">30</option>
												<option value="50">50</option>
												<option value="100">100</option>
												<option value="200">200</option>
											</select>
										</div>
											
										<div class="clear"></div>
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
	<script src="<?php echo base_url();?>js/tinymce/tinymce.min.js"></script>
	<script type="text/javascript">
		$('#btn-baru').hide();
		$('#btn-ubah').hide();
		
		searchFilter(0);
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			var keywords = $('#keywords').val();
			var sortBy = $('#sortBy').val();
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>index.php/admin/katalog/ajaxPaginationData/'+page_num,
				data:'page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy,
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
			$('#postList tbody').empty();
			var nomor = 1;
			for(emp in data){
				
				
				var empRow = '<tr>'+
							'<td class="text-center">'+nomor+'</td>'+
							'<td>'+data[emp].katalog_title+'</td>'+
							'<td class="text-center">'+data[emp].katalog_kd+'</td>'+
							'<td class="text-center"><div class="btn-group" role="group"><a href="#form1" data-toggle="modal" onClick="submit('+data[emp].katalog_id+')"  class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-pencil"></span></a><a onclick="hapus('+data[emp].katalog_id+')" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span></a></div></td>'+
							+'</tr>';
				nomor++;
				$('#postList tbody').append(empRow);					
			}
		}
		
		
		
		function submit(x){
						
			$("[name='id']").val('');
			
			$("[name='katalog_title']").val('');
			$("[name='katalog_kd']").val('');
			
			$('.modal-status').hide();
			
			$('#loading_ajax').fadeOut("slow");		
			
			if(x == 'tambah'){
				
				$('#btn-tambah').show();
				$('#btn-baru').hide();
				$('#btn-ubah').hide();
			   
			}else{
				$('#loading_ajax').show();
				
				$('#btn-tambah').hide();
				$('#btn-baru').show();
				$('#btn-ubah').show();
				
				$.ajax({
					type:'POST',
					data: 'id='+x,
					url:'<?php echo base_url('index.php/admin/katalog/ambildatabyid') ;?>',
					dataType:'json',
					success: function(hasil){
						
						$("[name='id']").val(hasil[0].katalog_id);
						$("[name='katalog_title']").val(hasil[0].katalog_title);
						$("[name='katalog_kd']").val(hasil[0].katalog_kd);
						
						console.log(hasil);
						$('#loading_ajax').fadeOut("slow");	
						
					}
				});
			}
		}
		
		function tambahdata(){		
			
			$('#btn-tambah').removeClass('btn-primary');
			$('#btn-tambah').addClass('btn-default');
			
			var katalog_title = $("[name='katalog_title']").val();
			var katalog_kd = $("[name='katalog_kd']").val();
			
			$('#loading_ajax').show();	
			
			$.ajax({
				type:'POST',
				data: {
					'katalog_title': katalog_title,
					'katalog_kd': katalog_kd
				},
				url:'<?php echo base_url('index.php/admin/katalog/tambahdata') ;?>',
				dataType:'json',
				success: function(hasil){
					//console.log(hasil);
					
					$('#loading_ajax').fadeOut("slow");
					
					if(hasil.pesan == ''){
						
						searchFilter(0);
						$('#btn-tambah').removeClass('btn-default');
						$('#btn-tambah').addClass('btn-primary');
						
						$("[name='katalog_id']").val('');
						$("[name='katalog_title']").val('');
						$("[name='katalog_kd']").val('');

						//bersihkan form
					}else{
						$('#btn-tambah').removeClass('btn-default');
						$('#btn-tambah').addClass('btn-primary');
						
						$('.modal-status').show();
						$('.modal-status').html('<div class="alert alert-danger" role="alert">'+hasil.pesan+'</div>');
						
					}
				}
			});
		}

		
		
		
		function simpandata(){		
			
			$('#btn-tambah').removeClass('btn-primary');
			$('#btn-tambah').addClass('btn-default');
			
			var id = $("[name='id']").val();
			var katalog_title = $("[name='katalog_title']").val();
			var katalog_kd = $("[name='katalog_kd']").val();
			
			$('#loading_ajax').show();	
			
			$.ajax({
				type:'POST',
				data: {
					'id': id ,
					'katalog_title': katalog_title,
					'katalog_kd': katalog_kd
				},
				url:'<?php echo base_url('index.php/admin/katalog/simpandatabyid') ;?>',
				dataType:'json',
				success: function(hasil){
					//console.log(hasil);
					
					$('#loading_ajax').fadeOut("slow");
					
					if(hasil.pesan == ''){
						
						
						searchFilter(0);
						$('#btn-tambah').removeClass('btn-default');
						$('#btn-tambah').addClass('btn-primary');
						
						
						$('#btn-tambah').show();
						$('#btn-baru').hide();
						$('#btn-ubah').hide();
						
						$("[name='katalog_id']").val('');
						$("[name='katalog_title']").val('');
						$("[name='katalog_kd']").val('');


						//bersihkan form
					}else{
						$('#btn-tambah').removeClass('btn-default');
						$('#btn-tambah').addClass('btn-primary');
						
						$('.modal-status').show();
						$('.modal-status').html('<div class="alert alert-danger" role="alert">'+hasil.pesan+'</div>');
						
					}
				}
			});
		}
	
		function hapus(x){
			var tanya = confirm('Apakah yakin mau hapus data?');
			if(tanya){
				$.ajax({
				type:'POST',
				data: 'id='+x,
				url:'<?php echo base_url('index.php/admin/katalog/hapusdatabyid') ;?>',
				success: function(){					
					searchFilter(0);
				}
			});
			}
		}	
			
		function republish(x,y){
			$.ajax({
				type:'POST',
				data: 'id='+x+'&panding='+y,
				url:'<?php echo base_url('index.php/admin/katalog/republish') ;?>',
				success: function(){					
					searchFilter(0);
				}
			});
		}
	</script>