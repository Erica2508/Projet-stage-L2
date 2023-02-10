<!DOCTYPE HTML>
<html>
	<head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/bootstrap.css">
		<style>

		</style>
	</head>
	<body>
    <?php include 'home.php'; ?>
    <div style="position: static" class="container">
            <form>
            <label class="container" style="font-family: 'Times New Roman' ;for="mois"></label>
                <label class="container" style="font-family: 'Times New Roman' ;for="mois"></label>
                <label class="container" style="font-family: 'Times New Roman' ;for="mois"></label>
                <label class="container" style="font-family: 'Times New Roman' ;for="mois"></label>
                <label class="container" style="font-family: 'Times New Roman' ;for="mois"></label>
                <label class="container" style="font-family: 'Times New Roman' ;for="mois"></label>
            <label style="font-family: 'Times New Roman' ;for="mois">Mois:</label>
            <select style="font-family: 'Times New Roman';" id="mois" >
                <option value="0">Janvier</option>
                <option value="1">Février</option>
                <option value="2">Mars</option>
                <option value="3">Avril</option>
                <option value="4">Mai</option>
                <option value="5">Juin</option>
                <option value="6">Juillet</option>
                <option value="7">Août</option>
                <option value="8">Septembre</option>
                <option value="9">Octobre</option>
                <option value="10">Novembre</option>
                <option value="11">Decembre</option>
            </select>
            <label style="font-family: 'Times New Roman';" for="Annee">Annee:</label>
            <input type="text" name="numero" value="" id="Annee"/>
            </form>
        </div>
		<div>
            <h1 style="font-family: 'Times New Roman';" id="capt"></h1>
                <table style="font-family: 'Times New Roman'" id="tbl" class="table table-bordered">
                    <thead>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
		</div>
        <div>
            <a href="gerer_chambre.php" class="btn btn-primary">
                Gerer chambre
            </a>
        </div>
        <div class="modal fade" id="gest_reserv_modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                    <form>
                        <div class="">
                                <div class="">
                                    <label for="nom">Nom:</label>
                                    <input type="text" class="form-control" name="nom" value="" id="nom"/>
                                </div>
                                <div>
                                    <label for="numero">Numero:</label>
                                    <input type="text" class="form-control" name="numero" value="" id="numero"/>
                                </div>
                                <div>
                                    <label for="paye">Paye:</label>
                                    <input type="text" class="form-control" name="paye" value="" id="paye"/>
                                </div>
                                <div>
                                    <input type="text" class="form-control" name="date" value="" id="date" hidden readonly/>
                                    <input type="text" class="form-control" name="chambre" value="" id="chambre" hidden readonly/>
                                </div>
                        </div>
                        <div class="modal-footer">
                            <input type="button" class="btn btn-primary" value="Ajouter" id="btn_ajt" />
                            <input type="button" class="btn btn-secondary" value="Supprimer" id="btn_suppr" onclick="supprimer()"/>
                            <input type="reset" class="btn btn-dark" value="Annuler" id="btn_annul" data-dismiss="modal"/>
                        </div>
                    </form>
                    </div>
                </div>
            </div>
        </div>
		<script src="jquery.js" type="text/javascript"></script>
        <script src="bootstrap.bundle.min.js" type="text/javascript"></script>
		<script type="text/javascript">
			$data = [
				{
				    "annee": "2019",
				    "mois": "Janvier",
					"date":[1,2,3,4,5,6,7,8,9,10,11,12,13,14,16],
				},
			    {
					"chambre":1,
					"occupe":[
						{
							"nom":"rabe",
							"numero": "",
							"paye" :"",
							"date":[1,2,5,6,7,8,9],
						},
						{
							"nom":"Rakoto",
                            "numero": "",
                            "paye" :"",
							"date":[3,4],
						},
					],
				},
                {
                    "chambre":2,
                    "occupe":[
                        {
                            "nom":"Rabia",
                            "numero": "",
                            "paye" :"",
                            "date":[1,2,7,8,9],
                        },
                        {
                            "nom":"Razaka",
                            "numero": "",
                            "paye" :"",
                            "date":[3,4,5,11,13],
                        },
                    ],
                },

			];

			$(document).ready(function(){
                $d = new Date();
                $("#mois").val($d.getMonth());
                $("#Annee").val($d.getFullYear());
                lister();
			});
			$("#mois").on("change",function(){
			   lister();
            });
            $("#Annee").on("keyup",function(){
               lister();
            });

			function charger($data){
			    // Vider le tableau au debut
                $("#tbl thead").empty();
                $("#tbl tbody").empty();
                $datmax = $data[0].date.length;
                $("#tbl thead").append(genLin($datmax+1));
                setLinDate($("#tbl thead tr")[0],$data[0]);
                $("#capt").text($data[0].mois+" "+$data[0].annee);
                $ii=1;
                while($ii<$data.length){
                    $("#tbl tbody").append(genLin($datmax+1));
                    setLinDateHidden($("#tbl tbody tr")[$ii-1],$data[0]);
                    setLinChambreHidden($("#tbl tbody tr")[$ii-1],$data[$ii]);
                    setLin($("#tbl tbody tr")[$ii-1],$data[$ii]);
                    $ii++;
                }
			}

            function setTextContent($balise,$txt){
                $balise.appendChild(document.createTextNode($txt));
                return $balise;
            }

			function genLin(nbCol){
				$tr = document.createElement("tr");
				while(nbCol>0){
				    $tr.append(mkOnclickEvent(document.createElement("td")));
				    nbCol--;
				}
				return $tr;
			}

			function setLinDate($lin,$data){
                $first = $lin.firstChild;
                $first.textContent = "Date";
                $l = $first.nextSibling;
                $last = $lin.lastChild;
                $doagain = true;
                $stop = false;
                $i = 0;
                while(!$stop){
                    $l.textContent = $data.date[$i];
                    $i++;
                    //pour aller jusqu'au bout du tableau
                    if(!$doagain)
                        $stop = true;
                    $l = $l.nextSibling;
                    if($l == $last)
                        $doagain = false;
                }
			}

			function setLin($lin,$data){
				$first = $lin.firstChild;
				$first.textContent = "Chambre "+$data.chambre;
				$l = $first.nextSibling;
				$last = $lin.lastChild;
				$i = 1;
				$doagain = true;
				$stop = false;
				while(!$stop){
				    //pour aller jusqu'au bout du tableau
				    if(!$doagain)
				        $stop = true;
                    $k = 0;
				    $occ = $data.occupe;
					while($k<$occ.length){
                        $dt = $data.occupe[$k].date;
                        $j=0;
                            if($i == $data.occupe[$k].date){
                                $l.innerHTML = "Nom:<span>"+$data.occupe[$k].nom+"</span><br/>Numero:<span>"+$data.occupe[$k].numero+"</span><br/>Paye:<span>"+$data.occupe[$k].paye+"</span><span hidden>"+$data.occupe[$k].date+"</span>"+"<span hidden>"+$data.chambre+"</span>";
                            }
                        $k++;
					}
				    $l = $l.nextSibling;
				    $i++;
				    if($l == $last)
				        $doagain = false;
				}
			}

			function setLinDateHidden($lin,$data){
                $first = $lin.firstChild;
                $first.textContent = "Chambre "+$data.chambre;
                $l = $first.nextSibling;
                $last = $lin.lastChild;
                $doagain = true;
                $stop = false;
                $i = 0;
                while(!$stop){
                    $l.innerHTML = "<span hidden>"+$data.date[$i]+"</span>";
                    $i++;
                    //pour aller jusqu'au bout du tableau
                    if(!$doagain)
                        $stop = true;
                    $l = $l.nextSibling;
                    if($l == $last)
                        $doagain = false;
                }
			    return $lin;
			}

            function setLinChambreHidden($lin,$data){
                $first = $lin.firstChild;
                $l = $first.nextSibling;
                $last = $lin.lastChild;
                $doagain = true;
                $stop = false;

                while(!$stop){
                    $l.innerHTML += "<span hidden>"+$data.chambre+"</span>";

                    //pour aller jusqu'au bout du tableau
                    if(!$doagain)
                        $stop = true;
                    $l = $l.nextSibling;
                    if($l == $last)
                        $doagain = false;
                }
                return $lin;
            }

			function mkOnclickEvent($elem){
			    $elem.setAttribute("onclick","afficher(this)");
			    return $elem;
			}

			function fullEvent($lin){
                $first = $lin.firstChild;
                $first.textContent = "Chambre "+$data.chambre;
                $l = $first.nextSibling;
                $last = $lin.lastChild;
                $doagain = true;
                $stop = false;
                while(!$stop){
                    $l.setAttribute("onclick","afficher(this)");
                    //pour aller jusqu'au bout du tableau
                    if(!$doagain)
                        $stop = true;
                    $l = $l.nextSibling;
                    if($l == $last)
                        $doagain = false;
                }
            }

            function afficher($elem){
				if($elem.getElementsByTagName("span").length==5){
                    $("#nom").val($elem.getElementsByTagName("span")[0].textContent);
                    $("#numero").val($elem.getElementsByTagName("span")[1].textContent);
                    $("#paye").val($elem.getElementsByTagName("span")[2].textContent);
                    $("#date").val($elem.getElementsByTagName("span")[3].textContent +" "+$("#capt").text());
                    $("#chambre").val($elem.getElementsByTagName("span")[4].textContent);
                    $("#btn_ajt").val("Modifier");
                    $("#btn_ajt").attr('onclick',"modifier()");
                    $("#gest_reserv_modal").modal("show");
				}
				else if($elem.getElementsByTagName("span").length==2){
                    $("#date").val($elem.getElementsByTagName("span")[0].textContent +" "+$("#capt").text());
                    $("#chambre").val($elem.getElementsByTagName("span")[1].textContent);
                    $("#btn_ajt").val("Ajouter");
                    $("#btn_ajt").attr("onclick","ajouter()");
                    $("#gest_reserv_modal").modal("show");
				}
			}

			function ajouter(){
                $nom = $("#nom").val();
                $numero = $("#numero").val();
                $paye = $("#paye").val();
                $date = $("#date").val();
				$chambre = $("#chambre").val();
                $.ajax({
				    type: "POST",
					url:"server.php",
					data:"req_type=ajouter&nom="+$nom+"&numero="+$numero+"&paye="+$paye+"&date="+$date+"&chambre="+$chambre,
					//dataType:"json",
					success:function(rep){
						//alert(rep);
                        $nom = $("#nom").val("");
                        $numero = $("#numero").val("");
                        $paye = $("#paye").val("");
                        $date = $("#date").val("");
                        $chambre = $("#chambre").val("");
                        lister();
					},
					error:function(err,txt){
					}
				});
                $("#gest_reserv_modal").modal("hide");
			}

            function lister(){
			    $mois = $("#mois").val();
			    $annee = $("#Annee").val();
			    $valid = new RegExp("^[0-9]{4}$","g");
			    if(!$valid.test($annee))
			        return;
                $.ajax({
                    type: "POST",
                    url:"server.php",
                    data:"req_type=lister&mois="+$mois+"&annee="+$annee,
                    dataType:"json",
                    success:function(rep){
                        //alert(rep);
                        charger(rep);
                    },
                    error:function(err,txt){
                        //charger(err);
                    }
                });
            }

			function supprimer(){
                $nom = $("#nom").val();
                $numero = $("#numero").val();
                $paye = $("#paye").val();
                $date = $("#date").val();
                $chambre = $("#chambre").val();
                $.ajax({
                    type: "POST",
                    url:"server.php",
                    data:"req_type=supprimer&nom="+$nom+"&numero="+$numero+"&paye="+$paye+"&date="+$date+"&chambre="+$chambre,
                    //dataType:"json",
                    success:function(rep){
                        lister();
                    },
                    error:function(err,txt){
                    }
                });
                $("#gest_reserv_modal").modal("hide");
			}

			function modifier(){
                $nom = $("#nom").val();
                $numero = $("#numero").val();
                $paye = $("#paye").val();
                $date = $("#date").val();
                $chambre = $("#chambre").val();
                $.ajax({
                    type: "POST",
                    url:"server.php",
                    data:"req_type=modifier&nom="+$nom+"&numero="+$numero+"&paye="+$paye+"&date="+$date+"&chambre="+$chambre,
                    //dataType:"json",
                    success:function(rep){
                        lister();
                    },
                    error:function(err,txt){
                    }
                });
                $("#gest_reserv_modal").modal("hide");
			}
		</script>
	</body>
</html>