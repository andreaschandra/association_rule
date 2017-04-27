<?php require_once('connection.php'); 

session_start();
if(!isset ($_SESSION['user']) && !isset($_SESSION['pass'])){
	header('location:index.php');
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

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	<script src="js/jquery.js"></script>
	
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

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
					<li class="active">
                        <a href="data.php"><i class="fa fa-fw fa-database"></i> Data</a>
                    </li>
					<li>
                        <a href="praproces.php"><i class="glyphicon glyphicon-tasks"></i> Preproses</a>
                    </li>
                    <li>
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
                            Data
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Data
                            </li>
                        </ol>
						<!-- Content -->
                        <div class="row">
                        	<div class="col-lg-10">
		                        <h2>Data Transaksi</h2>
        		                <div class="table-responsive loader">
                		            <table class="table table-bordered table-hover table-striped" id="myTable">
                        		        <thead>
                                		    <tr>
                                        		<th>No</th>
		                                        <th>No Faktur</th>
        		                                <th>No Barang</th>
                		                        <th>Nama Barang</th>
                        		            </tr>
                                		</thead>
	    	                            <tbody>
                                        <?php
										$sql = "SELECT detail_transaksi.ID, detail_transaksi.FAKTUR_ID, detail_transaksi.NOMER_BARANG,katalog.NAMA_BARANG from transaksi join detail_transaksi on transaksi.faktur = detail_transaksi.faktur_id join katalog on detail_transaksi.nomer_barang = katalog.nomer_barang where detail_transaksi.id ORDER BY detail_transaksi.ID";
										$result= mysqli_query($conn, $sql);
										while($data = mysqli_fetch_assoc($result)){
										?>
    	    	                            <tr>
                                                <td><?php echo $data['ID'] ?></td>
                                                <td><?php echo $data['FAKTUR_ID'] ?></td>
                                                <td><?php echo $data['NOMER_BARANG'] ?></td>
                                                <td><?php echo $data['NAMA_BARANG'] ?></td>
                                            </tr>
                                        <?php } ?>
		                                </tbody>
        		                    </table>
                    		    </div>
	                	    </div>
							
                        </div>
						<!-- End Table -->
						<div class="row">
                        	<div class="col-lg-10">
		                        <h2>Data Aturan Asosiasi</h2>
        		                <div class="table-responsive loader">
                		            <table class="table table-bordered table-hover table-striped">
                        		        <thead>
                                		    <tr>
                                        		<th>No</th>
		                                        <th>No Faktur</th>
        		                                <th>No Barang</th>
                		                        <th>Nama Barang</th>
                        		            </tr>
                                		</thead>
	    	                            <tbody>
                                        <?php
										$sql = "SELECT * FROM HASIL";
										$result= mysqli_query($conn, $sql);
										$i = 0;
										while($data = mysqli_fetch_assoc($result)){
										?>
    	    	                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <td><?php echo $data['ITEMSET'] ?></td>
                                                <td><?php echo $data['SUPPORT'] ?></td>
                                                <td><?php echo $data['CONFIDENCE'] ?></td>
                                            </tr>
                                        <?php $i++; } ?>
		                                </tbody>
        		                    </table>
                    		    </div>
	                	    </div>
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
    

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
    <script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready(function(){
		$('#myTable').DataTable();
	});
	</script>
</body>

</html>
