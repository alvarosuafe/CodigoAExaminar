

<?php  

//En este array insertamos el nombre de los archivos .conf para más tarde extraer el contenido de cada uno de ellos

$arrayConf = ["Files.conf" , "Directores.conf"];


//Con esta funcion metemos en dos arrays los ficheros y directorios que son validos en CodigoAExaminar
$arrayFiles = obtenerValidos($arrayConf[0]);
$arrayDirectores = obtenerValidos($arrayConf[1]);



/*
for($i=0; $i<count($arrayDirectores); $i++)
      {
      //saco el valor de cada elemento
	  echo $arrayDirectores[$i];
	  echo "<br>";
      }
*/


$dirExaminar = ("CodigoAExaminar/");

echo "$dir<br>";


//algo($dir);



 
/*
function algo($abrir){


	$abrir = opendir($dir);

	echo $abrir;

	while (false !== ($entrada = readdir($abrir))){
        echo "$entrada<br>";

        algo($abrir.$entrada."/");
    }

}*/



obtenerDirectorios($dirExaminar);

//echo $arrayFiles[4];
//echo $arrayDirectores[4];


function obtenerValidos($fConf){
	
	if (!$fConf = fopen("$fConf", "r")){

    echo nl2br("No se ha podido abrir el archivo \n");

    return 0;

	}

    else{

    echo "Abriendo el archivo $fConf<br>";

	    while (($line = fgets($fConf)) !== false) {
	      //  echo $line;
	     //   echo nl2br("AAAAAAAAAAAAAAAA \n ");
	        $array[] = $line;
	    }

	    return $array;

	}

}


function obtenerDirectorios($dir){ 


   // abrir un directorio y listarlo recursivo 
   if (is_dir($dir)) { 
      if ($dh = opendir($dir)) { 
         while (($file = readdir($dh)) !== false) { 
            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio 
            //mostraría tanto archivos como directorios 
            //echo "<br>Nombre de archivo: $file : Es un: " . filetype($dir . $file); 
            if (is_dir($dir . $file) && $file!="." && $file!=".."){ 
               //solo si el archivo es un directorio, distinto que "." y ".." 
               echo "<br>Directorio: $dir$file"; 

               obtenerDirectorios($dir.$file."/"); 
            } 
         } 
      closedir($dh); 
      } 
   }else 
      echo "<br>No es ruta valida"; 
}

/*$contents = fread($fp, filesize($files));

echo " \n $contents \n";
*/

?>