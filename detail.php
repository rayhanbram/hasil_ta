<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MamamYuk</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
img {
  width: 30%;
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
  float: center;
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
                        <h4>Detail Menu</h4>
                    </div>
                </div>
            </div>

<?php 
if (isset($_GET['menu_id']))  {
    echo' <div>
                    <div class="column">
											<div class="cardmenu">
    <h5 align="center">'.$_GET['menu_id'].' </strong></h5> <br />
     <img src='. $_GET['gambar'] .' alt="Gambar Menu" class="img">
     <h6 style="text-align:center;" class="text-danger" >'. $_GET['kategori'] .'</h6>
     <p style="text-align:center;">Umur : '. $_GET['umur'].' <br />
     
    </div>
    </div>';

    echo' <div>
                    <div class="column">
											<div class="cardmenu">
                      <p style="text-align:center;">Komposisi : '. $_GET['detail'].'
                      </div>
    </div>';
}
?>
</body>
</html>