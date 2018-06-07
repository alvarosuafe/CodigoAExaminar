
<?php  

//En este array insertamos el nombre de los archivos .conf para más tarde extraer el contenido de cada uno de ellos
$arrayConf = ["Files.conf" , "Directores.conf"];


//Con esta funcion metemos en dos arrays los ficheros y directorios que son validos en CodigoAExaminar
$filesExaminar = obtenerValidos($arrayConf[0]);
$directoresExaminar = obtenerValidos($arrayConf[1]);

$directoresReales = obtenerDirectorios("CodigoAExaminar/" , $arrayDir);


/* para recorrer los arrays 
	for($i=0; $i<count($directoresExaminar); $i++){
		  echo $directoresExaminar[$i];
		  echo gettype($directoresExaminar[$i]);
		  echo "<br>";
	      }

	for($i=0; $i<count($directoresReales); $i++){
		  echo $directoresReales[$i];
		  echo gettype($directoresReales[$i]);
		  echo "<br>";
	      }
*/



/*   Se uso para solucionar que las cadenas fuesen iguales    
    echo "$directoresExaminar[2]<br>";
    echo "$directoresReales[0]<br>";


    //var_dump("$directoresExaminar[4]\n");
    // var_dump("$directoresReales[0]\n");


    echo strcasecmp($directoresExaminar[2],$directoresReales[0]);

	if (strcasecmp($directoresExaminar[2],$directoresReales[0]) === 0){
	echo "BBIIIIIEEENNNN";}
*/	



	/*if(in_array(glob("*.*"), scandir(getcwd()) ) ) {
	    echo "";
	}
	*/

	//$algo = glob("*.*");


	$algo = scandir(getcwd());



	for($i=0; $i<count($algo); $i++){
			  echo $algo[$i];
			  //echo gettype($directoresExaminar[$i]);
			  echo "<br>";
		      }
	/*
	foreach($algo as $valor){

		if((preg_match('*.*' , $valor) == 0) && $valor !== "index.php" )

	}

	*/



echo "<br>1 Existen los directorios especificados en el fichero Directories.conf y no hay ningún
fichero más en el directorio principal que el index.php";
for ($i=0; $i <  count($directoresExaminar); $i++) { 	
		//	echo "<br>$directoresExaminar[$i]<br>";
		//echo "$directoresExaminar[$i]";
		if(in_array("$directoresExaminar[$i]", $directoresReales)){

			echo "<br>$directoresExaminar[$i] OK";
		}
		else{

			echo "<br>$directoresExaminar[$i] ERROR: NO EXISTE EL DIRECTORIO";
		}
	/*
		for ($j=0; $j < count($directoresReales); $j++) { 
			//echo "<br>$directoresReales[$j]";
			if (strcmp($directoresExaminar[3],$directoresReales[3]) == 0) {
				echo "EXISTE";
			}
		}
	*/
	
}




//echo $arrayFiles[4];
//echo $arrayDirectores[4];

   //  getDirContents("CodigoAExaminar/");


/*  una de las pruebas para sacar los dir 
	function getDirContents($dir, $filter = '', &$results = array()) {
	    $files = scandir($dir);

	    foreach($files as $key => $value){
	        $path = realpath($dir.DIRECTORY_SEPARATOR.$value); 

	        if(!is_dir($path)) {
	            if(empty($filter) || preg_match($filter, $path))
	             $results[] = $path;
	        } elseif($value != "." && $value != "..") {
	            getDirContents($path, $filter, $results);
	        }
	    }

	    return $results;
	} 

	// Simple Call: List all files
	//var_dump(getDirContents('CodigoAExaminar/'));

	$tt = getDirContents('CodigoAExaminar/');

	for($i=0; $i<count($tt); $i++)
	      {
	      //saco el valor de cada elemento
		  echo $tt[$i];
		  echo "<br>";
	      }

*/

function obtenerValidos($fConf){
	
	if (!$fConf = fopen("$fConf", "r")){

    echo nl2br("No se ha podido abrir el archivo \n");

    return 0;

	}

    else{

    echo "Abriendo el archivo $fConf<br>";

	    while (($line = fgets($fConf)) !== false) {
	     //echo "<br>$line";
	     //   echo nl2br("AAAAAAAAAAAAAAAA \n ");
	        $array[] = trim($line);//con la funcion trim  se elimina espacios del inicio y el final de la cadena
	    }

	    return $array;

	}

}




function obtenerDirectorios($dir, &$array ){

   if (is_dir($dir)) { 
      if ($gestorDir = opendir($dir)) { 
         while (($subDir = readdir($gestorDir)) !== false) {         	
            //esta línea la utilizaríamos si queremos listar todo lo que hay en el directorio 
            //mostraría tanto archivos como directorios 
            //echo "<br>Nombre de archivo: $file : Es un: " . filetype($dir . $file); 
            if (is_dir($dir.$subDir) && $subDir!="." && $subDir!=".."){ 
               //solo si el archivo es un directorio, distinto que "." y ".." 
               
              // echo "<br>Directorio: $dir$file"; 

            	$array[] = trim($dir.$subDir);
               obtenerDirectorios($dir.$subDir."/", $array); 
            }           
         } 
      closedir($gestorDir); 
      return $array;
      }   
   }
   else {
      echo "<br> $dir No es un directorio"; 
   }   
}

/*$contents = fread($fp, filesize($files));

echo " \n $contents \n";
*/

?>