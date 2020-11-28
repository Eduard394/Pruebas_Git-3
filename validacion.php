<?php 

include "conn.php";

$_POST['barrio'] = "Alameda";
$_POST['estrato'] = "5";
$_POST['zona'] = "Cedritos";
$_POST['edificio'] = "Altos de Belmira";
$_POST['esApto'] = "1";
$_POST['esCasa'] = "0";


if(isset($_POST["barrio"]))
{
    $dbConn =  connect($db);


    $barrio   = $_POST['barrio'];
    $zona     = $_POST['zona'];
    $edificio = $_POST['edificio'];
    $estrato  = $_POST['estrato'];

    if($_POST["esCasa"] == "1" ){

      //Mostrar lista de post
      //$sql = $dbConn->prepare("SELECT * FROM documentos where tram_id=:id ");
      $sql = $dbConn->prepare("CREATE TEMPORARY TABLE `registros`( valor INTEGER, preciom2 INTEGER, area INTEGER, alcobas INTEGER, barrio varchar(250), zona varchar(250), edificio VARCHAR(250), direccion varchar(250), estrato INTEGER ); 
                                    INSERT INTO `registros` 
                                        SELECT val_valorventa as valor, 
                                        val_preciom2 as preciom2, 
                                        val_area as area, 
                                        val_alcobas as alcobas, 
                                        val_barrio as barrio, 
                                        val_zona as zona, 
                                        val_edificio as edificio, 
                                        val_direccion as direccion, 
                                        val_estrato as estrato 
                                    FROM `validacion`
                                    Where val_barrio LIKE '%:barrio%' 
                                    AND val_estrato = :estrato, 
                                    AND val_zona LIKE CONCAT('%:zona%');
                                SELECT barrio, estrato, zona, '', AVG(valor), AVG(area), AVG(alcobas), AVG(preciom2) FROM `registros`;
                                 drop temporary table if exists `registros`;");
          
          $sql->bindValue(':barrio', $_POST['barrio']);
          $sql->bindValue(':estrato', $_POST['estrato']);
          $sql->bindValue(':zona', $_POST['zona']);;
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      header("HTTP/1.1 200 OK");
      echo json_encode( $sql->fetchAll()  );
      exit();
    }else{
        if($_POST["esApto"] == "1"){
            
          //Mostrar lista de post
          
          /*
          $sql = $dbConn->prepare("CREATE TEMPORARY TABLE `registros`( valor INTEGER, preciom2 INTEGER, area INTEGER, alcobas INTEGER, barrio varchar(250), zona varchar(250), edificio VARCHAR(250), direccion varchar(250), estrato INTEGER ); 
                                    INSERT INTO `registros` 
                                        SELECT val_valorventa as valor, 
                                        val_preciom2 as preciom2, 
                                        val_area as area, 
                                        val_alcobas as alcobas, 
                                        val_barrio as barrio, 
                                        val_zona as zona, 
                                        val_edificio as edificio, 
                                        val_direccion as direccion, 
                                        val_estrato as estrato 
                                    FROM `validacion`
                                    Where val_barrio LIKE '%:barrio%' 
                                    AND val_estrato = :estrato
                                    AND val_edificio LIKE CONCAT('%:edificio%') 
                                    AND val_zona LIKE CONCAT('%:zona%');
                                 SELECT barrio, estrato, zona, edificio, AVG(valor), AVG(area), AVG(alcobas), AVG(preciom2) FROM `registros`
                                 
                                 drop temporary table if exists `registros`;");

          $sql->bindValue(':barrio', $_POST['barrio']);
          $sql->bindValue(':estrato', $_POST['estrato']);
          $sql->bindValue(':edificio', $_POST['edificio']);
          $sql->bindValue(':zona', $_POST['zona']);
          */

          $string = "CREATE TEMPORARY TABLE `registros`( valor INTEGER, preciom2 INTEGER, area INTEGER, alcobas INTEGER, barrio varchar(250), zona varchar(250), edificio VARCHAR(250), direccion varchar(250), estrato INTEGER ); 
                    INSERT INTO `registros` SELECT val_valorventa as valor, val_preciom2 as preciom2,  val_area as area, val_alcobas as alcobas,   val_barrio as barrio, val_zona as zona,  val_edificio as edificio,  
                    val_direccion as direccion,  val_estrato as estrato  
                    FROM `validacion` 
                    Where val_barrio LIKE '%"+$barrio+"%'  AND val_estrato = "+$estrato+" 
                    AND val_edificio LIKE CONCAT('%"+$edificio+"%') AND val_zona LIKE CONCAT('%"+$zona+"%'); 
                    SELECT barrio, estrato, zona, edificio, AVG(valor), AVG(area), AVG(alcobas), AVG(preciom2) FROM `registros`;  
                    drop temporary table if exists `registros`;";
                                 
          //echo $string;
          //die();
          $sql = $dbConn->prepare("CREATE TEMPORARY TABLE `registros`( valor INTEGER, preciom2 INTEGER, area INTEGER, alcobas INTEGER, barrio varchar(250), zona varchar(250), edificio VARCHAR(250), direccion varchar(250), estrato INTEGER ); 
                                    INSERT INTO `registros` 
                                        SELECT val_valorventa as valor, 
                                        val_preciom2 as preciom2, 
                                        val_area as area, 
                                        val_alcobas as alcobas, 
                                        val_barrio as barrio, 
                                        val_zona as zona, 
                                        val_edificio as edificio, 
                                        val_direccion as direccion, 
                                        val_estrato as estrato 
                                    FROM `validacion`
                                    Where val_barrio LIKE '%"+$barrio+"%' 
                                    AND val_estrato = "+$estrato+"
                                    AND val_edificio LIKE CONCAT('%"+$edificio+"%') 
                                    AND val_zona LIKE CONCAT('%"+$zona+"%');
                                 SELECT barrio, estrato, zona, edificio, AVG(valor), AVG(area), AVG(alcobas), AVG(preciom2) FROM `registros`
                                 
                                 drop temporary table if exists `registros`;");
          $sql->execute();
          
          $sql->setFetchMode(PDO::FETCH_ASSOC);
          header("HTTP/1.1 200 OK");
          echo json_encode( $sql->fetchAll()  );
          exit();
        }
    }
}	
//holas
?>
