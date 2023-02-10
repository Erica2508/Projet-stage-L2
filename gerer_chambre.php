<?php
$host = "localhost" ;
$user = "root" ;
$password = "" ;
$db = "erica" ;

if(array_key_exists("newid",$_POST)){
    $obj = new mysqli($GLOBALS["host"],$GLOBALS["user"],$GLOBALS["password"],$GLOBALS["db"]);
    $query = "insert into chambre(id,designation) values ('".$_POST["newid"]."','".$_POST["newdes"]."')";
    $ret = $obj->query($query);
    $obj->close();
}else if(array_key_exists("modifid",$_POST)){
    $obj = new mysqli($GLOBALS["host"],$GLOBALS["user"],$GLOBALS["password"],$GLOBALS["db"]);
    $query = "update chambre set designation=\"".$_POST["modifdes"]."\" WHERE id=\"".$_POST["modifid"]."\"";
    $ret = $obj->query($query);
    $obj->close();
}else if(array_key_exists("supprid",$_POST)){
    $obj = new mysqli($GLOBALS["host"],$GLOBALS["user"],$GLOBALS["password"],$GLOBALS["db"]);
    $query = "delete from chambre WHERE id=\"".$_POST["supprid"]."\"";
    $ret = $obj->query($query);
    $obj->close();
}
unset($_POST);

?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="bootstrap.min.css"/>
        <style>
            .link{
                cursor: pointer;
            }
        </style>
    </head>
    <body>

    <?php include 'home.php'; ?>
    <section class="">
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="height:120px;width:1500px;>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <a style="font-family: 'Calisto MT';font-size: larger" class="nav-link" href="home.php">Accueil<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a style="font-family: 'Calisto MT';font-size: larger" class="nav-link" href="gerer_chambre.php">Chambres</a>
                    </li>
                    <li class="nav-item">
                        <a style="font-family: 'Calisto MT';font-size: larger" class="nav-link" href="gest_hotel.php">Reservations</a>
                    </li>
                    </li>
                </ul>
                <h4 style="color:white;padding-right:100px;font-family:'Baskerville Old Face';font-size: x-large ">GESTIONS DE RESERVATION DE L'HOTEL « Le Cap »</h4>
                <button onclick="showNewChambreModal();" class="btn btn-success">Ajouter une chambre</button>

                <a href="gest_hotel.php" class="btn btn-dark">Gerer reservation</a>
                </form>
            </div>
        </nav>
    </section>

    <!-- Modal ajout -->
    <div class="modal fade" id="newChambreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Voulez vous vraiment quittrer?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" action="gerer_chambre.php">
                <div class="modal-body">

                        <div class="">
                            <div class="">
                                <label for="nom">id:</label>
                                <input type="number" class="form-control" name="newid" value="" id="nom"/>
                            </div>
                            <div>
                                <label for="des">Designation:</label>
                                <input type="text" class="form-control" name="newdes" value="" id="des"/>
                            </div>
                        </div>                </div>
                <div class="modal-footer">

                    <div>
                        <input type="submit" class="btn btn-primary" value="ajouter" id="btn_ajt" />
                        <input type="reset" class="btn btn-dark" value="annuler" id="btn_annul" data-dismiss="modal"/>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modifChambreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" action="gerer_chambre.php">
                <div class="modal-body">
                        <div class="">
                            <div class="">
                                <label for="nom">id:</label>
                                <input type="number" class="form-control" name="modifid" value="" id="modifid" readonly/>
                            </div>
                            <div>
                                <label for="des">Designation:</label>
                                <input type="text" class="form-control" name="modifdes" value="" id="modifdes"/>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">

                    <div>
                        <input type="submit" class="btn btn-primary" value="Modifier" id="btn_ajt" />
                        <input type="reset" class="btn btn-dark" value="Annuler" id="btn_annul" data-dismiss="modal"/>
                    </div>
                </div>

            </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="supprchambreModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    Voulez vous vraiment supprimer cet enregistrement ?

                </div>
                <div class="modal-footer">
                    <form method="post" action="gerer_chambre.php">
                        <input type="text" name="supprid" id="supprid" hidden/>
                        <input type="submit" value="supprimer" class="btn btn-primary">
                        <input type="button" value="annuler" data-dismiss="modal" class="btn btn-dark">
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="card mb-3">
        <div class="card-header">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Numero</th>
                        <th>Designation</th>
                        <th>Action</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $obj = new mysqli($GLOBALS["host"],$GLOBALS["user"],$GLOBALS["password"],$GLOBALS["db"]);
                    $query = "select id,designation from chambre ORDER BY id ASC";
                    $result = $obj->query($query);
                    $rows = $result->num_rows ;
                    $x = array() ;
                    for($i=0;$i<$rows;++$i)
                    {
                        $result->data_seek($i);
                        $cli = $result->fetch_array(MYSQLI_ASSOC);
                        echo "<tr>";
                        echo "<td>" . $cli["id"] . "</td>";
                        echo "<td>" . $cli["designation"] . "</td>";
                        echo "<td><span onclick=\"showModifChambreModal(this);\" class='btn btn-info'> Modifier </span></td>";
                        echo "<td><span onclick='showSupprChambreModal(this)' class='btn btn-danger'>Supprimer</span></td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div>
    </div>
        <script src="jquery.js" type="text/javascript"></script>
        <script src="bootstrap.bundle.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            function showNewChambreModal(){
                $("#newChambreModal").modal("show");
            }

            function showModifChambreModal(sender){
                $("#modifid").val(sender.parentNode.previousSibling.previousSibling.textContent);
                $("#modifdes").val(sender.parentNode.previousSibling.textContent);
                $("#modifChambreModal").modal("show");
            }

            function showSupprChambreModal(sender){
                $("#supprid").val(sender.parentNode.previousSibling.previousSibling.previousSibling.textContent);
                $("#supprchambreModal").modal("show");
            }
        </script>
    </body>
</html>