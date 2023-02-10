<?php
/**
 * Created by PhpStorm.
 * User: Jems
 * Date: 15/01/2019
 * Time: 14:28
 */

$host = "localhost" ;
$user = "root" ;
$password = "" ;
$db = "erica" ;

$mois = ["Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Aout","Septembre","Octobre","Novembre","Decembre"];

class Reservation{
    private $dt;
    private $nom;
    private $numero;
    private $paye;
    private $chambre;

    /**
     * @return mixed
     */
    public function getDt()
    {
        return $this->dt;
    }

    /**
     * @param mixed $dt
     */
    public function setDt($dt)
    {
        $this->dt = $dt;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getPaye()
    {
        return $this->paye;
    }

    /**
     * @param mixed $paye
     */
    public function setPaye($paye)
    {
        $this->paye = $paye;
    }

    /**
     * @return mixed
     */
    public function getChambre()
    {
        return $this->chambre;
    }

    /**
     * @param mixed $chambre
     */
    public function setChambre($chambre)
    {
        $this->chambre = $chambre;
    }
}

class Custom{
    public $chambre;
    public $occ = array();
}

class Occupe{
    private $nom;
    private $numero;
    private $paye;
    private $date;

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * @param mixed $numero
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;
    }

    /**
     * @return mixed
     */
    public function getPaye()
    {
        return $this->paye;
    }

    /**
     * @param mixed $paye
     */
    public function setPaye($paye)
    {
        $this->paye = $paye;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }
}

function ajouter(){
    $nom = $_POST["nom"];
    $numero = $_POST["numero"];
    $paye = $_POST["paye"];
    $date = $_POST["date"];
    $chambre = $_POST["chambre"];
    $date = explode(" ",$date);
    $a = $date[0];
    $date[0] = $date[2];
    $date[2] = $a;

    $mois = $GLOBALS["mois"];

    $i = 0;
    while($date[1] != $mois[$i++]);
    $date[1] = $i;

    $obj = new mysqli($GLOBALS["host"],$GLOBALS["user"],$GLOBALS["password"],$GLOBALS["db"]);
    $query = "insert into reservation(dt,nom,numero,paye,chambre) values ('".$date[0]."/".$date[1]."/".$date[2]."','".$nom."','".$numero."','".$paye."','".$chambre."')";
    $ret = $obj->query($query);
    $obj->close();
    return true;
}

function lister(){
    $m = $_POST["mois"];
    $a = $_POST["annee"];
    $dd=0;
    if($m%2 == 0){
        $dd = 31;
    }
    else if($m%2 == 1){
        if($m == 1){
            $dd=28;
        }
        else
            $dd=30;
    }
    $m++;
    $d1 = $a."-".$m."-01";
    $d2 = $a."-".$m."-".$dd;
    $obj = new mysqli($GLOBALS["host"],$GLOBALS["user"],$GLOBALS["password"],$GLOBALS["db"]);
    //$query = "select chambre,dt,nom,numero,paye from reservation where dt BETWEEN '".$d1."'AND'".$d2."' ORDER BY chambre ASC";
    $query = "select DISTINCT id as \"chambre\",nom,numero,paye,dt from chambre left outer join reservation on (chambre.id=reservation.chambre and (dt BETWEEN '".$d1."'AND'".$d2."' or dt IS NULL))  ORDER BY id ASC";
    $result = $obj->query($query);
    $rows = $result->num_rows ;
    $x = array() ;
    for($i=0;$i<$rows;++$i)
    {
        $result->data_seek($i);
        $cli = $result->fetch_array(MYSQLI_ASSOC);
        array_push($x,new Reservation()) ;
        current($x)->setDt($cli["dt"]);
        current($x)->setNom($cli["nom"]);
        current($x)->setNumero($cli["numero"]);
        current($x)->setPaye($cli["paye"]);
        current($x)->setChambre($cli["chambre"]);
        next($x) ;
    }
    $obj->close();
    $occup = array();
    $cust = array();
    $s = false;
    //rangement
    for($i=0;$i<count($x);$i++){
        $s=false;
        foreach($cust as $c){
            //si egal, copier occuper sous forme tableau et sortir
            if($x[$i]->getChambre() == $c->chambre){
                array_push($c->occ,new Occupe());
                end($c->occ)->setNom($x[$i]->getNom());
                end($c->occ)->setNumero($x[$i]->getNumero());
                end($c->occ)->setPaye($x[$i]->getPaye());
                end($c->occ)->setDate(explode("-",$x[$i]->getDt())[2]);
                $s = true;
                break;
            }
        }
        if($s){
            continue;
        }
        else{
            array_push($cust,new Custom());
            end($cust)->chambre = $x[$i]->getChambre();
            if($x[$i]->getDt()!= ""){
                array_push(end($cust)->occ,new Occupe);
                end(end($cust)->occ)->setNom($x[$i]->getNom());
                end(end($cust)->occ)->setNumero($x[$i]->getNumero());
                end(end($cust)->occ)->setPaye($x[$i]->getPaye());
                end(end($cust)->occ)->setDate(explode("-",$x[$i]->getDt())[2]);
            }
        }

    }
    $annee = $a;
    $mois = $GLOBALS["mois"][$m-1];
    if($m == 2)
        $date = "[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28]";
    else if($m%2==1)
        $date = "[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31]";
    else
        $date = "[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30]";
    $donne = "[";
    $donne .= "{\"annee\":\"".$annee."\",\"mois\":\"".$mois."\",\"date\":".$date."}";
    foreach($cust as $c){
        if($donne[-1]=="}")
            $donne .= ",";
        $donne .="{\"chambre\":".$c->chambre.",\"occupe\":[";
        foreach ($c->occ as $o){
            if($donne[-1]=="}")
                $donne .= ",";
            $donne .= "{\"nom\":\"".$o->getNom()."\",\"numero\":\"".$o->getNumero()."\",\"paye\":\"".$o->getpaye()."\",\"date\":\"".$o->getDate()."\"}";
        }
        $donne .= "]}";
    }
    $donne .= "]";
    return $donne;
}

function modifier(){
    $nom = $_POST["nom"];
    $numero = $_POST["numero"];
    $paye = $_POST["paye"];
    $date = $_POST["date"];
    $chambre = $_POST["chambre"];
    $date = explode(" ",$date);
    $a = $date[0];
    $date[0] = $date[2];
    $date[2] = $a;

    $mois = $GLOBALS["mois"];

    $i = 0;
    while($date[1] != $mois[$i++]);
    $date[1] = $i;

    $obj = new mysqli($GLOBALS["host"],$GLOBALS["user"],$GLOBALS["password"],$GLOBALS["db"]);
    //$query = "insert into reservation(dt,nom,numero,paye,chambre) values ('".$date[0]."/".$date[1]."/".$date[2]."','".$nom."','".$numero."','".$paye."','".$chambre."')";
    $query = "update reservation set nom=\"".$nom."\",numero=\"".$numero."\",paye=\"".$paye."\" where dt=\"".$date[0]."/".$date[1]."/".$date[2]."\" AND chambre=\"".$chambre."\"";
    $ret = $obj->query($query);
    $obj->close();
    return true;
}

function supprimer(){
    $nom = $_POST["nom"];
    $numero = $_POST["numero"];
    $paye = $_POST["paye"];
    $date = $_POST["date"];
    $chambre = $_POST["chambre"];
    $date = explode(" ",$date);
    $a = $date[0];
    $date[0] = $date[2];
    $date[2] = $a;

    $mois = $GLOBALS["mois"];

    $i = 0;
    while($date[1] != $mois[$i++]);
    $date[1] = $i;

    $obj = new mysqli($GLOBALS["host"],$GLOBALS["user"],$GLOBALS["password"],$GLOBALS["db"]);
    //$query = "insert into reservation(dt,nom,numero,paye,chambre) values ('".$date[0]."/".$date[1]."/".$date[2]."','".$nom."','".$numero."','".$paye."','".$chambre."')";
    $query = "delete from reservation where dt=\"".$date[0]."/".$date[1]."/".$date[2]."\" AND chambre=\"".$chambre."\"";
    $ret = $obj->query($query);
    $obj->close();
    return true;
}

if(array_key_exists('req_type',$_POST)){

    if($_POST["req_type"]=="ajouter"){
        echo ajouter();
    }
    else if($_POST["req_type"]=="lister"){
        echo lister();
    }
    else if($_POST["req_type"]=="modifier"){
        echo modifier();
    }
    else if($_POST["req_type"]=="supprimer"){
        echo supprimer();
    }
    unset($_POST);
}