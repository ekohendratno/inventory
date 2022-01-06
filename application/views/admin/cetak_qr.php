<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <title>CETAK KARTU PERPUS</title>

    <script>var base_url = '/';</script>

    <link href="<?php echo base_url('assets/admin/css/cetak2a.min.css') ?>" rel="stylesheet">


    <script src="<?php echo base_url('assets/admin/js/jquery.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/jquery-migrate-1.4.1.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/qrcode.min.js') ?>"></script>
	
</head>
<body>
	<style>
		.page {
			padding: 1cm;
		}

		td {
			padding: 5px;
		}
	</style>
	<?php
	$posisi = 0;
	$nomor = 0;
	$halaman = 0;
	foreach($barang as $item){
	    $jumlah_barang = $item['barang_jumlah'];

	    for($a =1; $a<=$jumlah_barang; $a++){


            if($halaman == 0){
                echo '
		<div class="page">
		<center>
			<table align="center" width="100%">
				<tbody>';
            }

            if($posisi == 0){
                echo '<tr>';
            }

            echo '<td style="padding:3px;">';

            echo '<table style="width:6.6cm;height:5.0cm;border:1px solid rgba(156,156,156,0.76);" class="kartu">
								<tbody>
								<tr><td style="text-align:center"><strong>' .strtoupper($item['barang_nama']).'</strong></td></tr>
								<tr><td style="text-align:center"><div class="qrcode1" id="qr_'.$item['barang_nomor'].' '.$a.'" data-value="'.$item['barang_nomor'].' '.$a.'" title="'.$item['barang_nomor'].' '.$a.'"></div></td></tr>
								<tr><td style="text-align:center">'.$item['barang_nomor'].' '.$a.'</td></tr>
								<tr><td style="text-align:center"><strong>SMK NEGERI 1 CANDIPURO</strong></td></tr>
								
							</tbody></table>';


            echo '</td>';

            if($posisi == 2){
                echo '</tr>';
            }

            $posisi++;
            $nomor++;
            $halaman++;

            if($posisi == 3) $posisi = 0;

            if($halaman == 15){
                echo '
				</tbody>
			</table>
		</center>
		</div>';

                if($halaman == 15) $halaman = 0;

            }




        }


	}
	?>
		
    <script>

        $('.qrcode1').each(function(){
            new QRCode(document.getElementById($(this).attr('id')), {
                text: $(this).attr('data-value'),
                width: 124,
                height: 124,
                colorDark : "#3A5B73",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });


        });

        setTimeout(function(){
            $('.qrcode1 img').removeAttr("style");
        },3000);


        //window.print();
    </script>

</body></html>