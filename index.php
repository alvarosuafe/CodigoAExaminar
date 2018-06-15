
<?php  

//
	//En este array insertamos el nombre de los archivos .conf para más tarde extraer el contenido de cada uno de ellos
	$arrayConf = ["Files.conf" , "Directores.conf"];

	//Con esta funcion metemos en dos arrays los ficheros y directorios que son validos en CodigoAExaminar
	$filesExaminar = obtenerValidos($arrayConf[0]);
	$directoresExaminar = obtenerValidos($arrayConf[1]);

	$directoresReales = obtenerDirectorios("CodigoAExaminar/" , $arrayDir);


	//Se extraen los ficheros del directorio principal
	$ficherosDirPrinci = scandir("CodigoAExaminar/");

/* esto se soluciono despues del while en la funcion obtenerFicheros 
	for ($i=0; $i < count($ficherosDirPrinci); $i++) { 
		if(is_file("CodigoAExaminar/".$ficherosDirPrinci[$i])){
			$ficheros[] = "CodigoAExaminar/$ficherosDirPrinci[$i]";
		}
	}

	$ficherosReales = obtenerFicheros("CodigoAExaminar/" , $arrayDir, $ficheros);
*/

	obtenerFicheros("CodigoAExaminar/" , $arrayDir, $ficherosTodos);

	
	//rsort($ficheros);
	//sort($ficheros);
	//natsort ($ficheros);
	//usort($ficheros, "cmp");
	sort($ficherosTodos);

/* intento de ordenar el array
	function cmp($ficheros, $b) {
		$string1 = substr_count($ficheros , '/');
		$string2 = substr_count($b , '/');
		echo"<br$string1>";
		echo"<br$string2>";
    if ($string1 == $string2) {
        return 0;
    }
    	return ($string1 < $string2) ? -1 : 1;
	}


	usort($ficheros, 'cmp');
*/


	$analizados = 0;
	$errores = 0;
/* para recorrer los arrays 
			for($i=0; $i<count($ficheros); $i++){
				  echo $ficheros[$i];
				 // echo gettype($directoresExaminar[$i]);
				  echo "<br>";
			      }
		
			for($i=0; $i<count($directoresReales); $i++){
				  echo $directoresReales[$i];
				  echo gettype($directoresReales[$i]);
				  echo "<br>";
			      }
*/

//PARTE 1

		/*   Se uso para solucionar que las cadenas fuesen iguales    
		    echo "$directoresExaminar[2]<br>";
		    echo "$directoresReales[0]<br>";


		    //var_dump("$directoresExaminar[4]\n");
		    // var_dump("$directoresReales[0]\n");


		    echo strcasecmp($directoresExaminar[2],$directoresReales[0]);

			if (strcasecmp($directoresExaminar[2],$directoresReales[0]) === 0){
			echo "BBIIIIIEEENNNN";}
		*/	


		/*	
		echo "<br>1 Existen los directorios especificados en el fichero Directories.conf y no hay ningún
		fichero más en el directorio principal que el index.php";

		//Valida que existan los directorios especificados en el .conf
		for ($i=0; $i <  count($directoresExaminar); $i++) { 	
				//	echo "<br>$directoresExaminar[$i]<br>";
				//echo "$directoresExaminar[$i]";
				if(in_array("$directoresExaminar[$i]", $directoresReales)){

					echo "<br>$directoresExaminar[$i] OK";
					$analizados += 1;
					$directoresReales = array_diff($directoresReales, array($directoresExaminar[$i]));//Los que queden seran directorios que no estan en el .conf y por tanto deberian existir
					//unset($directoresReales['$directoresExaminar[$i]']);
				}
				else{

					echo "<br> <font color=\"red\"> $directoresExaminar[$i] ERROR: NO EXISTE EL DIRECTORIO</font>";
					$analizados += 1;
					$errores += 1;
				}

				
			/* una prueba
				for ($j=0; $j < count($directoresReales); $j++) { 
					//echo "<br>$directoresReales[$j]";
					if (strcmp($directoresExaminar[3],$directoresReales[3]) == 0) {
						echo "EXISTE";
					}
				}
			*/
		
		/*}



		foreach($directoresReales as $value){//se imprimen los directorios que no estan en el .conf y por tanto no pueden existir
			echo"<br> <font color=\"red\"> $value : ERROR NO PUEDE EXISTIR EL DIRECTORIO</font>";
			$analizados += 1;
			$errores += 1;
		}
		
		//valida que index.php es el unico fichero del directorio principal
		$ficherosDirPrinci = scandir("CodigoAExaminar/");

		for ($i=0; $i < count($ficherosDirPrinci); $i++) { 			
			if(preg_match("/.+\..+/", $ficherosDirPrinci[$i]) && $ficherosDirPrinci	[$i] != "index.php") {
				//$ficherosDirPrinci[] = "CodigoAExaminar/".$algo[$i];
				echo "<br><font color=\"red\">CodigoAExaminar/$ficherosDirPrinci[$i] ERROR: FICHERO NO PERMITIDO</font>";
				$analizados += 1;
				$errores += 1;
			}
		}
		
		

		echo "<br>$analizados Elementos analizados / Numero de errores : $errores<br>";
		$analizados = 0;
		$errores = 0;
		*/	


//PARTE 2.1
	
		/*
		echo "<br>2 Los ficheros de vista, controlador y modelo tienen el nombre indicado en especificación en el fichero Files.conf";
		//Se convierte % en una expresion regular
		$filesExaminar2 = str_replace("%" , "[0-9A-Za-z]+" , $filesExaminar);
		$filesExaminar2 = str_replace("." , "\." , $filesExaminar2); //Se convierte a una expr_reg cada fichero a analizar del Files.conf

		$filesComprobados[] = array();
		for ($i=0; $i < count($filesExaminar2) ; $i++) {
			$filesExaminar2[$i] = substr (strrchr($filesExaminar2[$i] , "/"),1);//extraemos el fichero de su ruta
			echo "<br>$filesExaminar2[$i]";
			}


		for($i=0; $i<count($filesExaminar2); $i++){
			//  echo "<br>$filesExaminar[$i]";
			$arrayEx = explode( "/" , $filesExaminar[$i]); //Separamos la ruta en un array
			  
			$arrayEx[count($arrayEx)-1]= null; // Eliminamos el fichero final de la ruta

			$ruta =  implode ("/" , $arrayEx); //Se vuelve unir todo para obtener la ruta sin el fichero final


			 //echo "<br> $ruta";

			if(is_dir($ruta)){//Con esto nos aseguramos que trabajaremos con directorios que realmente existen
				$ficheros =  scandir($ruta); 

			//echo "<br> <b>$filesExaminar[$i]</b>";

			for ($j=0; $j <  count($ficheros); $j++) { 

				//$ficheros[$j] = $ruta . $ficheros[$j]; //Concatenemos para obtener la ruta completa de cada fichero que se va a analizar

				// echo "<br> <b>$ficheros[$j]</b>";
				//if(is_file($ficheros[$j])) {
				if(preg_match("/.+\..+$/", $ficheros[$j])){
				 	 	 
			 	 	//echo "<br>$ficheros[$j]";

				

			 	$ficheros[$j] = $ruta . $ficheros[$j]; //Concatenemos para obtener la ruta completa de cada fichero que se va a analizar

			 	$patron = trim("/$filesExaminar2[$i]/");

			 	 	$cadena = trim($ficheros[$j]);
			 	   // echo "<br>$patron   PATROOOON";
				 	//echo "<br>$cadena   CADENAAA";

			 	 	if(preg_match($patron, $cadena) && in_array($ruta, $filesComprobados) == false){
			 	 	 	echo "<br> $ficheros[$j] OK";
			 	 	 	$analizados += 1;
			 	 	}

			 	 	else {
			 	 		if(in_array($ruta, $filesComprobados) == false){
			 	 	 	echo "<br><font color=\"red\">$ficheros[$j] ERROR </font>";
			 	 	 	$analizados += 1;
						$errores += 1;
						$filesComprobados[] =  	$ficheros[$j];
						}
			 	 	}
			 	}	
				//}	

				
			}	

			}

			else{//Puede darse el caso de que no existe el directorio del fichero especificado
				echo"<br> $filesExaminar[$i] ERROR : No existe el directorio del fichero especificado";	
			}


			


		 }

		 echo "<br>$analizados Elementos analizados / Numero de errores : $errores<br>";
	     $analizados = 0;
   	   	 $errores = 0;*/
 	

//PARTE 2.2 mejorable pero estoy hasta los cojones, hay que pulir los mensajes de las salidas

   	   	
	
		

		 //obviamente si se mete dos criterios distintos para los ficheros de un mismo directorio pues va
   	   	 // a duplicar y dar errores que no son pues el programa no es adivino y claro no sabe que mas 
   	   	 //adelante va haber un criterio que le indica que lo que ahora es erroneo luego es valido y pun
   	   	 // no cuadra nada
		   	/*
				echo "<br>2 Los ficheros de vista, controlador y modelo tienen el nombre indicado en especificación en el fichero Files.conf";
				//Se convierte % en una expresion regular
				$filesExaminar2 = str_replace("%" , "[0-9A-Za-z]+" , $filesExaminar);
				$filesExaminar2 = str_replace("." , "\." , $filesExaminar2); //Se convierte a una expr_reg cada fichero a analizar del Files.conf
			
				for ($i=0; $i < count($filesExaminar2) ; $i++) {
					$filesExaminar2[$i] = substr (strrchr($filesExaminar2[$i] , "/"),1);//extraemos el fichero de su ruta
					echo "<br>$filesExaminar2[$i]";
					}

				//iremos comprobando si se cumple cada critero especificado en la descripcion del .conf
				for($i=0; $i<count($filesExaminar2); $i++){
					//  echo "<br>$filesExaminar[$i]";
					//echo "<br> $filesExaminar[$i]";
					$arrayEx = explode( "/" , $filesExaminar[$i]); //Separamos la ruta en un array
					  
					$arrayEx[count($arrayEx)-1]= null; // Eliminamos el fichero final de la ruta

					$ruta =  implode ("/" , $arrayEx); //Se vuelve unir todo para obtener la ruta sin el fichero final
					 //echo "<br> $ruta";
					if(is_dir($ruta)){//Con esto nos aseguramos que trabajaremos con directorios que realmente existen
						$ficheros =  scandir($ruta); 
					//echo "<br> <b>$filesExaminar[$i]</b>";
						if(preg_match("/.*%.+/" , $filesExaminar[$i])){
								echo "<br> <b>$filesExaminar[$i]</b>";
								//vamos comprobando si los ficheros del directorio de la especificacion cumplen el criterio
								for ($j=0; $j <  count($ficheros); $j++) { 

									//$ficheros[$j] = $ruta . $ficheros[$j]; //Concatenemos para obtener la ruta completa de cada fichero que se va a analizar
								    
									//if(is_file($ficheros[$j])) {
									if(preg_match("/.+\..+$/", $ficheros[$j])){
									 	 	 
								 	 	//echo "<br>$ficheros[$j]";

								 		$ficheros[$j] = $ruta . $ficheros[$j]; //Concatenemos para obtener la ruta completa de cada fichero que se va a analizar

								 		$patron = trim("/$filesExaminar2[$i]/");

								 	 	$cadena = trim($ficheros[$j]);
								 	    // echo "<br>$patron   PATROOOON";
									 	//echo "<br>$cadena   CADENAAA";
								 	 	if(preg_match($patron, $cadena)){
								 	 	 	echo "<br> $ficheros[$j] OK";
								 	 	 	$analizados += 1;
								 	 	}
								 	 	else {
								 	 		
								 	 	 	echo "<br><font color=\"red\">$ficheros[$j] ERROR </font>";
								 	 	 	$analizados += 1;
											$errores += 1;								
								 	 	}
								 	}	
									//}			
								}	
						}
						else{
							for ($k=0; $k < count($ficheros); $k++) { 
								$ficheros[$k] = $ruta . $ficheros[$k];
						//		echo"<br> $ficheros[$i]";
							}					
							//echo "<br> $filesExaminar[$i]";
							if(in_array($filesExaminar[$i] , $ficheros)){
								echo"<br>$filesExaminar[$i] OKkkkkkkkkkkkkkk";
							 	$analizados += 1;

							}
							else{
								echo"<br>$filesExaminar[$i] ERRORrrrrrrrrrrr";
									$analizados += 1;
									$errores += 1;
							}
						}
					}
					else{//Puede darse el caso de que no existe el directorio del fichero especificado
						echo"<br> $filesExaminar[$i] ERROR : No existe el directorio del fichero especificado";	
					}
				 }
				 echo "<br>$analizados Elementos analizados / Numero de errores : $errores<br>";
			     $analizados = 0;
		   	   	 $errores = 0;
		   	*/
   	   	 


//PARTE 3 una rayada pero parece que va
   	
 /*  	   	



			echo "<br>4 Las funciones y métodos en el código del directorio CodigoAExaminar tienen comentarios con una descripción antes de su comienzo";
			
	   	 //  	for ($i=0; $i < count($ficherosTodos) ; $i++) { 
	   	   	//Iremos tratando fichero a fichero
	   	   		
	   	  // 	 	if(!preg_match("/.+\.(png|pdf|jpg|gif)$/" , $ficherosTodos[$i])){//para todos los ficheros que no son propietarios
	   	   	 		
	   	   	 		if (!$fConf = fopen('CodigoAExaminar/View/Entidad1_Add_View.php', "r")){

			   		 echo "<br>No se ha podido abrir el archivo";
					}//en if que cumprueba si el fichero se ha podido abrir

			  	    else{

			  	    //	echo "<br> Abriendo el archivo $ficherosTodos[$i]";

				

							//echo "<br> $ficherosTodos[$i] ";
						
				   			while (($line = fgets($fConf)) !== false) {

		    					if(!preg_match('/^\s*$/' , $line)){

		    						$arrayFile[] = $line;

		    					}
				    		}//end while que empieza a recorrer el fichero


						

					}//end else grande

					fclose($fConf);

	   	   	// 	}//end if que comprueba si son propietarios

	   	   	 /*	else{
	   	   	 		echo"<br>  $ficherosTodos[$i]  <font color=\"red\"> ERROR: NO ES PROPIETARIO </font>";
	   	   	 		$analizados += 1;
					$errores += 1;	
	   	   	 	}*/		

	   	   	// }//end for que recorre cada posicion del array ficherosTodos para ir comprobando si cada archivo tienen el comentario de cabecera


	   	   	 /*	 echo "<br>$analizados Elementos analizados / Numero de errores : $errores<br>";
			     $analizados = 0;
		   	   	 $errores = 0;*/

/*
for($i=0; $i<count($arrayFile); $i++){
				  echo $arrayFile[$i];
				 // echo gettype($directoresExaminar[$i]);
				  echo "<br>";
			      }
*/






$arrayFile = file('CodigoAExaminar/View/Entidad1_Add_View.php' , FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);

/*
for($i=0; $i<count($arrayFile); $i++){
				  echo $arrayFile[$i];
				 // echo gettype($directoresExaminar[$i]);
				  echo "<br>";
			      }*/

		for($i=0; $i<count($arrayFile); $i++){
				//La primera expresion regular se ha sacado del manual de php

				//if(preg_match('/\s*function\s+[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/' , $arrayFile[$i]) && preg_match('/^\s*((\/){2,}|(#)|(\*\/))+\s*$/' , $arrayFile[$i-1])){

			if(preg_match('/\s*function\s+[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/' , $arrayFile[$i]) ){


				encontrarComent($arrayFile , $i);
			}




			//echo "$arrayFile[$i] SIIIIIIIIIIII<br>";
				//}

			}

//AQUIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIIII
			
			function encontrarComent($array, $indice){
				$flag = false;
				$flag2 = false;
				while($indice >= 0 && $flag == false){

					if(preg_match('/^\s*((\/){2,}|(#))+\s*$/' , $array[$indice])){// si aparecen comentario de tipo '//' o '#' pero sin nada mas, pasamos de ellos pues la funcion sigue sin estar comentada
	
					}

					else if(preg_match('/^\s*((\/){2,}|(#))+.*$/' , $array[$indice])){//si aparece un comentario de linea con algo mas la funcion esta comentada y salimos del while para dar el OK
						$comentario = true;
						$flag = true;
					}


					else if(preg_match('/^\s*\*\/\s*$/' , $array[$indice])){//Si aparece un '*/' sin nada hay que tener cuidado porque en las lineas anteriores a el puede estar comentada la funcion
						$flag2 = true;
					}
					else if(preg_match('/^\s*\/\*\s*$/' , $array[$indice]) && $flag2==true){
						$flag2 = false;
					}
					else if(!preg_match('/^\s*$/' , $array[$indice]) && $flag2==true){//cuando aparece una linea normal y se esta tratando un bloque /**/ quiere decir que SI hay algo comentado antes de la funcion
						$comentario = true;
						$flag = true;
					}
					else if(!preg_match('/^\s*$/' , $array[$indice]) && $flag2==false){//si se encuentra una linea que no pertenece a un comentario quiere decir que ya hemos encontrado un tozo de codigo por lo que la funciion no esta comentada
						$comentario=false;
					}


					$indice--;

				}


			//	if(preg_match('/^\s*((\/){2,}|(#)|(\*\/))+\s*$/' , $array[$indice])){
			//		 encontrarComent($array, $indice-1);
			}
			//	else if()


			//}

//	FUNCIONES
	function obtenerValidos($fConf){
		if (!$fConf = fopen("$fConf", "r")){
	   		 echo nl2br("No se ha podido abrir el archivo \n");
	   		 return 0;
		}
	    else{
	   		 echo "Abriendo el archivo $fConf<br>";
		   	 while (($line = fgets($fConf)) !== false) {
		       	 $array[] = trim($line);//con la funcion trim  se elimina espacios del inicio y el final de la cadena
		    }
		    return $array;

		}

	}


	function obtenerDirectorios($dir, &$array ){
	   if (is_dir($dir)) { 
	      if ($gestorDir = opendir($dir)) { 
	         while (($subDir = readdir($gestorDir)) !== false) {	          
	            if (is_dir($dir.$subDir) && $subDir!="." && $subDir!=".."){            
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


	function obtenerFicheros($dir, &$array2 , &$ficheros){
		if (is_dir($dir)){
	      if ($gestorDir = opendir($dir)){
	         while (($subDir = readdir($gestorDir)) !== false) {
				
	         	if (is_file("$dir$subDir")){

	         		$ficheros[] = "$dir$subDir";
	         		//echo "<br>$dir$subDir";
	         	}


	            if (is_dir($dir.$subDir) && $subDir!="." && $subDir!=".."){
	               
	              // $subDir .= "/";
	             //  $array = scandir($dir.$subDir);
	               //echo "<br> subDir";
	               //for ($i=0; $i < count($array); $i++){ 
	               	//	if(is_file("$dir$subDir".$array[$i])){
	               		//	$ficheros[] = "$dir$subDir".$array[$i];
	               	//	}
	             //  }
	               $array2[] = trim($dir.$subDir);
	               obtenerFicheros($dir.$subDir."/", $array2, $ficheros); 
	            }   
	          //  echo "<br> $subDir";        
	         } 
	      closedir($gestorDir); 
	      return $ficheros;
	      }   
	   }
	   else{
	      echo "<br> $dir No es un directorio"; 
	   }   
	}

	
?>