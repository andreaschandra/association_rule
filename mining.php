<?php 
session_start();
if(!isset ($_SESSION['user']) && !isset($_SESSION['pass'])){
	header('location:index.php');
}
ini_set("max_execution_time", 0);
$awal = microtime(true);
require_once('connection.php'); 
//$sql = "SELECT * FROM detail_transaksi LIMIT 10";
//$result = mysqli_query($conn, $sql); 

class lower{
	private $num;
	
	function __construct($num){
		$this->num = $num;
	}
	function frequent($data){
		return ($data < $this->num) ? false : true;
	}
	function frequent2($data){
		return ($data < 0) ? false : true;
	}
}


function deletetablehasil(){
	require('connection.php'); 
	$sql = "DELETE FROM HASIL";
	mysqli_query($conn, $sql);
}

function mining($mins){
	$min = $mins;
	//koneksi database
	require('connection.php');
//=================================END===========================================

	function frequent($data,$min){
		return ($data < $min) ? false : true;
	}
	function frequent1($data,$min){
		return ($data < $min) ? false : true;
	}

//=================================END===========================================

	$query = "SElECT NAMA_BARANG FROM KATALOG LIMIT 1000"; 
		$sql = mysqli_query($conn, $query);
		while ($record = mysqli_fetch_assoc($sql)){
			$item[] = $record['NAMA_BARANG'];
		}
		
//=================================END===========================================

	$query = "SELECT faktur FROM transaksi";
	$sql = mysqli_query($conn, $query);
	if (mysqli_num_rows($sql) > 0){ 
		// output data of each row
		while($row = mysqli_fetch_assoc($sql)) {
			$faktur[] = $row['faktur'];
		}
	}
	$total_transaksi = count($faktur);
	//=================================END===========================================

	//menselect faktur tertentu dan di jadikan barisan array
	foreach($faktur as $i){
		$query = "select NAMA_BARANG from katalog join detail_transaksi on katalog.nomer_barang = detail_transaksi.nomer_barang where detail_transaksi.faktur_id = '$i'"; 
		$sql = mysqli_query($conn, $query);	
		
		while ($record = mysqli_fetch_assoc($sql)){
			$pecahan[] = $record['NAMA_BARANG'];
		}
		$belian[] = (implode(" , " , $pecahan)); 
		unset ($pecahan);
	}

//=================================END===========================================
	foreach ($item as $value) {
        $total_per_item[$value] = 0;
        foreach($belian as $item_belian) {
            if(strpos($item_belian,$value) !== false){
				$total_per_item[$value]++;
			}
        }
    }


    //echo "Step 1: Jumlah Mengikut Item\n";
	asort($total_per_item);
	$total_per_item = array_filter($total_per_item, array(new lower($min), 'frequent'));
	
	if($total_per_item == null){
		return $data = null;
	}
    
	foreach($total_per_item as $key => $val){
		$tpii[] = $key;
	}

//=================================END===========================================
	if($tpii != null){
		$item1 = count($tpii) - 1; // minus 1 from count
		//echo $item1."= item 1<br/>";
		$item2 = count($tpii); // 
		//echo $item2."= item 2<br/>";
		
		for($i = 0; $i < $item1; $i++) {
			//echo "ini punya I ".$i."<br/>"; //echo $item1."<br>";
			for($j = $i+1; $j < $item2; $j++) {
				$item_array[$tpii[$i].'-'.$tpii[$j]] = 0;
				foreach($belian as $item_belian) {
					if((strpos($item_belian, $tpii[$i]) !== false) && (strpos($item_belian, $tpii[$j]) !== false)) {
						$item_array[$tpii[$i].'-'.$tpii[$j]]++;
					}
				}
			}
		}
    }
    //echo "\r\nStep 2: Jumlah Gabungan 2 Item\r\n";
	$item_array = array_filter($item_array, array(new lower($min), 'frequent'));
    asort($item_array);
    
//=================================END===========================================
	$item1 = count($tpii) - 2;
	
    $item2 = count($tpii) - 1; // minus 1 from count
	
    $item3 = count($tpii); // 
	
	
	for($i = 0; $i < $item1; $i++){
		
	    for($j = $i+1; $j < $item2; $j++) {
	
        	for($k = $j+1; $k < $item3; $k++) {
	
	            $item_arrays[$tpii[$i].'-'.$tpii[$j].'-'.$tpii[$k]] = 0;
		        foreach($belian as $item_belian) {
                	if((strpos($item_belian, $tpii[$i]) !== false) && (strpos($item_belian, $tpii[$j]) !== false) && (strpos($item_belian, $tpii[$k]) !== false)) {
                    	$item_arrays[$tpii[$i].'-'.$tpii[$j].'-'.$tpii[$k]]++;
                	}
            	}
			}
        }
    }
    
    //echo "\r\nStep 3: Jumlah Gabungan 3 Item\r\n";
    $item_arrays = array_filter($item_arrays, array(new lower($min), 'frequent'));
	asort($item_arrays);
	
	if($item_arrays == null){
		return $data = null;
	}
    
//=================================END===========================================
	/*$itemsets = null;
	//echo "\r\nStep 4: Jumlah Gabungan Item\r\n";
    foreach ($item_array as $ia_key => $ia_value) {
        foreach ($total_per_item as $tpi_key => $tpi_value) {
            if ((strpos($ia_key, $tpi_key) !== false)) {
				//echo "[+] $ia_key($ia_value) --> $tpi_key($tpi_value) => ".  $ia_value / $tpi_value ."\r\n";
				$itemsets[] = "$ia_key --> $tpi_key";
				list($itemx, $itemy) = explode('-',$ia_key);
					if ($itemx == $tpi_key) { $theitem = $itemy; }
					else { $theitem = $itemx; }
						//echo "    ".round($ia_value / $total_transaksi * 100, 3)."% Support";
						//echo " dan ". round($ia_value / $tpi_value * 100, 2)."% Confidence\r\n\r\n";
						$support[] = round($ia_value / $total_transaksi * 100, 3);
						$confidence[] = round($ia_value / $tpi_value * 100, 3);
            }
        }
    }*/
	
//Extended
	if($item_arrays != null){
		foreach($item_arrays as $ias_key => $ias_value){
			foreach($total_per_item as $tpi_key => $tpi_value){
				if((strpos($ias_key,$tpi_key)) !== false){
					//echo "[+] $ias_key($ias_value) --> $tpi_key($tpi_value) => ".  $ias_value / $tpi_value ."\r\n";
					$itemsets[] = "$ias_key --> $tpi_key";
					list($itema,$itemb,$itemc) = explode('-',$ias_key);
					if($itema == $tpi_key){
						$the_itemq = $itema;
					}elseif($itemb == $tpi_key){
						$the_itemq = $itemb;
					}else{
						$the_itemq = $itemc;
					}
					//echo " ". round($ias_value / $tpi_value * 100, 2)."% yang membeli $tpi_key juga membeli $the_itemq\r\n\r\n";
					$support[] = round($ias_value / $total_transaksi * 100, 3);
					$confidence[] = round($ias_value / $tpi_value * 100, 3);
				}
			}
		}
	}
	
	if($itemsets == null || $support == null || $confidence == null){
		$datacomplete = null;
		return $datacomplete;
	}
	
	$i = 0;
	foreach($itemsets as $item_item){
		$datacomplete[$i]['itemset'] = $item_item;
		$datacomplete[$i]['support'] = $support[$i];
		$datacomplete[$i]['confidence'] = $confidence[$i];
		$i++;
	}

return $datacomplete;
//echo "</pre>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Data Mining for Toko Buku Togamas</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <link href="css/style.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <div class="logo-head">
                <a href="dashboard.php"><img src="asset/header_logo.jpg" /></a>
                </div>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> Administrator <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="destroysession.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li>
                        <a href="dashboard.php"><i class="fa fa-fw fa-dashboard"></i> Beranda</a>
                    </li>
					<li>
                        <a href="data.php"><i class="fa fa-fw fa-database"></i> Data</a>
                    </li>
					<li>
                        <a href="praproces.php"><i class="glyphicon glyphicon-tasks"></i> Preproses</a>
                    </li>
                    <li class="active">
                        <a href="mining.php"><i class="fa fa-fw fa-bar-chart-o"></i> Analisis</a>
                    </li>
                    <li>
                        <a href="howto.php"><i class="fa fa-fw fa-table"></i> Dokumentasi</a>
                    </li>
                    <li>
                        <a href="about.php"><i class="fa fa-fw fa-edit"></i> Tentang</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Analisis
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Analisis
                            </li>
                        </ol>
						<form role="form" action="" method="POST" class="form-inline">
							<label>Nilai Dukungan</label> <br />
                            <div class="form-group">
                                <input class="form-control" type="text" name="minsupp" placeholder="Masukan nilai">
                            </div>
                            <button type="submit" class="btn btn-primary" name="submit" value="submit"> Analisis </button>
						</form>
						<?php
						$data = [];
						$entity['itemset'] = array();
						if(isset($_POST['submit'])){
							if(isset($_POST['minsupp'])){
								$min = $_POST['minsupp'];
								deletetablehasil();
								$data = mining($min);
							}else{
								$min = 0;
								deletetablehasil();
								$data = mining($min);
							}
						}
						if($data == null){
							echo "";
						}
						?>
						<div class="">
							<h2>Result</h2>
						</div>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>									
                                        <th>Item</th>
                                        <th>Dukungan</th>
                                        <th>Kepercayaan</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								require('connection.php');
								if($data != null){
									insert($data);
									foreach($data as $entity){ ?>
										<tr>
											<td><?php echo $entity['itemset']; ?></td>
											<td><?php echo $entity['support']."%"; ?></td>
											<td><?php echo $entity['confidence']."%"; ?></td>
										</tr>
									<?php } 
								}else{ ?>
									<tr>
										<td><?php echo "data kosong" ?></td>
										<td><?php echo "data kosong" ?></td>
										<td><?php echo "data kosong" ?></td>
									</tr>
								<?php }?>
								<?php
									function insert($data){
										require('connection.php');
										if($data != null){
											foreach($data as $dat){
												$sql = "INSERT INTO hasil (ITEMSET, SUPPORT, CONFIDENCE) VALUES ('".$dat['itemset']."','".$dat['support']."','".$dat['confidence']."')";
												mysqli_query($conn, $sql);	
											}											
											?><script>alert("Data berhasil dimasukan"); </script><?php	
										}else{
											?><script>alert("Data gagal"); </script><?php	
										}
									}
								?>
                                </tbody>
                            </table>
                        </div>
                    
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php 
$akhir = microtime(true);
$totalwaktu = $akhir  - $awal;
echo "Halaman ini di eksekusi dalam waktu " . number_format($totalwaktu, 3, '.', '') . " detik!";
?>