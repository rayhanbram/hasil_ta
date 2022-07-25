<?php 

//index.php

include('db_connection.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MamamYuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
p.profil {
  text-align: center;
}
img {
  /* width: 40%; */
  height: 100px;
  display: block;
  margin-left: auto;
  margin-right: auto;
}
.cardmenu{
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            margin-bottom: 10px;
            margin-top: 10px;
        }
        .column {
  float: left;
  width: 50%;
  padding: 0 20px;
}

.row {margin: 0 -5px;}

.row:after {
  content: "";
  display: table;
  clear: both;
}

@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 0px;
  }
}
</style>
</head>
<body>
    
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-3">
                    <div class="card-header">
                      <button type="submit" class="btn btn-primary btn-sm float-end">Home</button>
                        <h4>Rekomendasi Menu MPASI</h4>
                    </div>
                    <div class="card-header">
                        <h5>Berdasarkan Profil Orang Tua</h5>
                    </div>
                </div>
            </div>

            <!-- Pilihan filter  -->
            <div class="col-md-3">
                <form action="" method="GET">
                    <div class="card shadow mt-3">
                        <div class="card-header">
                            <h5>Filter 
                                <button type="submit" class="btn btn-primary btn-sm float-end">Search</button>
                            </h5>
                        </div>
                        <div class="card-body">
                            <h6> Umur (Usia Anak)</h6>
                            <hr>
                            <?php
                                $con = mysqli_connect("localhost","root","","codingan_ta");
								//$con = mysqli_connect("localhost","root","","tugas_akhir_2");

                               
                                        ?>
                                            <div>
                                                <input type="radio" name="umur" 
                                                    <?php if (isset($_GET['umur']) && $_GET['umur']==1) {echo "checked";}?> 
                                                    value=1> 6-8 Bulan
												<br />
                                                <input type="radio" name="umur" 
                                                    <?php if (isset($_GET['umur']) && $_GET['umur']==2) {echo "checked";}?> 
                                                    value=2> 9-11 Bulan
												<br />
                                                 <input type="radio" name="umur" 
                                                    <?php if (isset($_GET['umur']) && $_GET['umur']==3) {echo "checked";}?> 
                                                    value=3> 12-23 Bulan
                                               
                                            </div>
                                        
                        </div>
                        <div class="card-body">
                        <p class="profil"><b>Profil Orang Tua</b></p>
                            <h6>Daerah</h6>
                            <hr>
                            
                                <div>
								
								<?php
									$daerah_query = "SELECT * FROM lokasi";
									$daerah_query_run  = mysqli_query($con, $daerah_query);
									
									if(mysqli_num_rows($daerah_query_run) > 0)
									{
										foreach($daerah_query_run as $daerahlist)
										{											
											?>
											<input type="radio" name="lokasi" 
												 <?php if (isset($_GET['lokasi']) && $_GET['lokasi']== $daerahlist['lokasi_id']) {echo "checked";}?> 
												 value= <?php echo $daerahlist['lokasi_id'] ?> > <?php echo $daerahlist['nama']?>
											<br />
											<?php
										}
									}
									
								?>  
                                </div>
                        </div>
                        <div class="card-body">
                            <h6> Kebiasaan Makan Orang Tua </h6>
                            <h7> Makanan:</h7>
                            <hr>
                            <?php
                                

                                $kesukaan_query = "SELECT * FROM preferensi";
                                $kesukaan_query_run  = mysqli_query($con, $kesukaan_query);

                                if(mysqli_num_rows($kesukaan_query_run) > 0)
                                {
                                    foreach($kesukaan_query_run as $kesukaanlist)
                                    {
                                        $checked = [];
                                        if(isset($_GET['jenis']))
                                        {
                                            $checked = $_GET['jenis'];
                                        }
                                        ?>
                                            <div>
                                                <input type="checkbox" name="jenis[]" value="<?= $kesukaanlist['preferensi_id']; ?>" 
                                                    <?php if(in_array($kesukaanlist['preferensi_id'], $checked)){ echo "checked"; } ?>
                                                 />
                                                <?= $kesukaanlist['jenis']; ?>
                                            </div>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo "Tidak ada Preferensi yang cocok";
                                }
                            ?>
                        </div>
                    </div>
                </form>
            </div>

            <!-- processing data -->
            <?php 
                if(isset($_GET['umur'])) $umur = $_GET['umur'];
                if(isset($_GET['lokasi'])) $lokasi = $_GET['lokasi'];
                if(isset($_GET['jenis'])) $prefs = $_GET['jenis'];

                $isQueryHaveData = false;
                
                
                $query = "select distinct  a.menu_id id, a.menu menu, a.gambar, a.detail, b.umur umur, c.deskripsi kategori from 
                            menu_mpasi a 
                            join umur b on a.umur_id = b.umur_id
                            join kategori c on a.kategori_id = c.kategori_id
                            left join menu_lokasi d on d.menu_id = a.menu_id
                            join (
                                    select a.menu_id
                                    from menu_mpasi a 											
                                
                            ";
                if(isset($prefs)){
                    if(isset($prefs[0])) $query .= " join menu_preferensi d on a.menu_id = d.menu_id and d.preferensi_id = $prefs[0]";
                    if(isset($prefs[1])) $query .= " join menu_preferensi c on a.menu_id = c.menu_id and c.preferensi_id = $prefs[1]";
                    if(isset($prefs[2])) $query .= " join menu_preferensi b on a.menu_id = b.menu_id and b.preferensi_id = $prefs[2]";
                }		

                $query .= ") pref on a.menu_id = pref.menu_id
                                where 1=1 ";
                                
                
                if(isset($umur)) $query .= " and b.umur_id = $umur";
                if(isset($lokasi)) $query .= " and d.lokasi_id = $lokasi";

                $query .= " order by c.deskripsi desc";
                
                
                $menu_run = mysqli_query($con, $query);
                if(mysqli_num_rows($menu_run) > 0) {$isQueryHaveData = true;}

                $dataArray = array();

                foreach($menu_run as $menuitems) :
                    if(!array_key_exists($menuitems['kategori'], $dataArray)){
                        $dataArray[$menuitems['kategori']] = array();
                    }

                    array_push($dataArray[$menuitems['kategori']], $menuitems);
                endforeach;

                
            ?>

            <!-- end processing data -->
			

            <!-- Menampilkan Pilihan -->
            
            <div class="col-md-9 mt-3">            
                <div class="card ">

                    <?php
                        if($isQueryHaveData){
                            foreach($dataArray as $data_key => $data_val) :

                                echo '<div class="card-body row"><h1>'.$data_key.'</h1>';
                                echo '<div class="container mt-5 mb-3"><div class="row">';
                                foreach($data_val as $menuitems) :
                                    
                                    echo'
                                    
                                                                <div class="col-md-4">
                                                                    <div class="card p-3 mb-2">
                                                                        <div>
                                                                            <img src='. $menuitems['gambar'] .' alt="Gambar Menu" class="img" />
                                                                        </div>
                                                                        <div class="mt-5">
                                                                            <h3 class="heading"><a href="detail.php?menu_id='.$menuitems['menu'].'&umur='.$menuitems['umur'].'&kategori='.$menuitems['kategori'].'&gambar='.$menuitems['gambar'].'&detail='.$menuitems['detail'].'">'. $menuitems['menu'] .'</a></h3>
                                                                            <div class="mt-5">
                                                                                <div class="mt-3"> <span class="text1">'. $menuitems['umur'].'</span><br><span class="text1">'. $menuitems['kategori'] .'</span> </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                    ';
    
    
                                endforeach;
                                echo '</div></div>';
    
    
                                echo '</div>';
    
                            endforeach;
                        }else{
                            echo "Rekomendasi Belum Tersedia";
                        }
                        
                    ?>
                    
                    
                </div>
            </div> 
        </div>
                    
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>