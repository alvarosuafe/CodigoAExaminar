
<?php  


//NOTA:Se ha decidido escribir los comentarios y las salidas sin acentos para evitar posibles errores de formato

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

	obtenerFicheros("CodigoAExaminar/" , $arrayDir, $ficherosTodos); //en el array $ficherosTodos estaran todos los archivos

	
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
 //para recorrer los arrays 
			for($i=0; $i<count($ficherosTodos); $i++){
				  echo $ficherosTodos[$i];
				 // echo gettype($directoresExaminar[$i]);
				  echo "\n<br>";
			      }
		/*
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
		
		echo "<br><b>1 Existen los directorios especificados en el fichero Directories.conf y no hay ningún
		fichero más en el directorio principal que el index.php</b>";
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
		
		}
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
 	
//PARTE 2.2 mejorable, hay que pulir los mensajes de las salidas
   	   	
	
		
		 //obviamente si se mete dos criterios distintos para los ficheros de un mismo directorio pues va
   	   	 // a duplicar y dar errores que no son pues el programa no es adivino y claro no sabe que mas 
   	   	 //adelante va haber un criterio que le indica que lo que ahora es erroneo luego es valido y pun
   	   	 // no cuadra nada
		   	
				echo "<br><b>2 Los ficheros de vista, controlador y modelo tienen el nombre indicado en especificación en el fichero Files.conf</b>";
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
		   	
   	   	 
//PARTE 3 una rayada pero parece que va
 			echo "<br> <b>3 Los ficheros del directorio CodigoAExaminar tiene todos al principio del fichero comentada su función, autor y fecha</b>";
			
	   	   	for ($i=0; $i < count($ficherosTodos) ; $i++) { 
	   	   	//Iremos tratando fichero a fichero
	   	   		$bloqueComent = array();
	   	   	 	if(!preg_match("/.+\.(png|pdf|jpg|gif)$/" , $ficherosTodos[$i])){//para todos los ficheros que no son propietarios
	   	   	 		
	   	   	 		if (!$fConf = fopen($ficherosTodos[$i], "r")){
			   		 echo "<br>No se ha podido abrir el archivo";
					}//en if que cumprueba si el fichero se ha podido abrir
			  	    else{
			  	    //	echo "<br> Abriendo el archivo $ficherosTodos[$i]";
			  	    	if(filesize($ficherosTodos[$i]) <= 0){
							echo "<br> $ficherosTodos[$i]  <font color=\"red\"> ERROR : El archivo esta vacio</font>";
							$analizados += 1;
							$errores += 1;	
						} 
						else{
							//echo "<br> $ficherosTodos[$i] ";
							$flag = false;
							$flag2 = false;		
				   			while (($line = fgets($fConf)) !== false && $flag == false) {
					   			if(preg_match('/\s*<?php.*/', $line)){	
						   			$bloqueComent[] = $line;
							   	 	while (($line = fgets($fConf)) !== false && $flag == false) {
							   	 		if(preg_match('/^\s*((\/\/)|#)/', $line)){//si // al principio de la linea se guarda la linea
							   	 			$bloqueComent[] = $line;
							   	 			//echo"$line <br>";	   	 			
							   	 		}
							   	 		else if(preg_match('/^\s*\/\*/', $line)){//si /* al principio se guarda la linea y se pone el flag2 a true para saber que empezamos a tratar un bloque /* */
							   	 			$bloqueComent[] = $line;
							   	 			$flag2=true;
							   	 		}
							   	 	//	else if(preg_match('/^\s*[^\/*\s]+/', $line) && $flag2==false){//si se encuentra algo que no tenga que ver con comentario y no se esta tratando un bloque /* */ se pone flag a true para salir del while pues se habra llegado al primer trozo de codigo
							   	 	//		$flag = true;
							   	 	//	}
							   	 		else if(preg_match('/.*\*\/$/' , $line) && $flag2==true ){//si */ al final de la linea y ademas se esta tratando un bloque /* */ se guarda la linea y se pone el flag2 a false para indicar que se ha acabado de tratar dicho bloque
							   	 			$bloqueComent[] = $line;
							   	 			$flag2=false;
							   	 		}
							   	 		else if(!preg_match('/^\s*$/' , $line) && $flag2==true){ //mientras se este tratando un bloque /* */ cualquier linea que no este en blanco se almacena
							   	 			$bloqueComent[] = $line;
							   	 		}
							   	 		else if(!preg_match('/^\s*$/' , $line) && $flag2==false){//si finalmente se encuentra algo que no entro por alguno de los if anteriores y no se esta tratanto un bloque /* */ quiere decir que no es un comentario por lo que ha aparecido el primer codigo
							   	 			$flag = true;
							   	 		}
							   	 	}	
					   			}			    			
				    		}//end while que empieza a recorrer el fichero
				    		/*Tras meter cada linea de todos los comentarios antes de la primera linea de codigo en un array analizamos si hay en el las tres palabras para que se cumpla la especificacion*/
				    			$funcion = false;
				    			$autor = false;
				    			$fecha = false;
						    	for ($j=0; $j < count($bloqueComent); $j++) { 
						    		if(preg_match('/(funci(o|ó)n)|(function)/i' , $bloqueComent[$j])){
						    			$funcion = true;
						    		}
						    		if(preg_match('/(autor)|(author)/i' , $bloqueComent[$j])){
						    			$autor = true;
						    		}
						    		if(preg_match('/(fecha)|(date)/i' , $bloqueComent[$j])){
						    			$fecha = true;
						    		}
						    	}
						    	if($funcion == true && $autor == true && $fecha == true){
						    		echo"<br> $ficherosTodos[$i]  OK";
							 	 	 	$analizados += 1;
						    	}
						    	else{
						    		echo"<br> $ficherosTodos[$i] <font color=\"red\"> ERROR: NO TIENE COMENTARIOS DE CABECERA</font>";
						    			$analizados += 1;
										$errores += 1;	
						    	}
						}//end else que entra si el archivo no esta vacio
					}//end else grande
					fclose($fConf);
	   	   	 	}//end if que comprueba si son propietarios
	   	   	 	else{
	   	   	 		echo"<br>  $ficherosTodos[$i]  <font color=\"red\"> ERROR: NO ES PROPIETARIO </font>";
	   	   	 		$analizados += 1;
					$errores += 1;	
	   	   	 	}		
	   	   	 }//end for que recorre cada posicion del array ficherosTodos para ir comprobando si cada archivo tienen el comentario de cabecera
	   	   	 	 echo "<br>$analizados Elementos analizados / Numero de errores : $errores<br>";
			     $analizados = 0;
		   	   	 $errores = 0;

//PARTE 4 

	//PARTE 4.1  ESTO VA A QUEDAR EN EL OLVIDO
			/*La idea era intentar hacer esta parte con la fucnion file para rellenar un array con todas
			las lineas del fichero a analizar sin tener en cuenta las lineas en blanco, el proble es que
			las lineas que estan en blanco pero tienen espacios o/y tabuladores si las guarda y eso suponia
			un problema por eso cambie de idea y pase a rellenar el array con un while que recorra linea 
			a linea el fichero a analizar pero omitiendo las lineas en blanco incluidar aquellas que tengan
			espacio y tabuladores
			*/
			/*$arrayFile = file('CodigoAExaminar/View/Entidad1_Add_View.php' , FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);			
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
					else if(preg_match('/^\s*\*\/\s*$/' , $array[$indice])){//Si aparece un '/ sin nada hay que tener cuidado porque en las lineas anteriores a el puede estar comentada la funcion
						$flag2 = true;
					}
					else if(preg_match('/^\s*\/\*\s*$/' , $array[$indice]) && $flag2==true){
						$flag2 = false;
					}
					else if(!preg_match('/^\s*$/' , $array[$indice]) && $flag2==true){//cuando aparece una linea normal y se esta tratando un bloque // quiere decir que SI hay algo comentado antes de la funcion
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
			}*/
			//	else if()
			//}


			echo "<b><br>4 Las funciones y métodos en el código del directorio CodigoAExaminar tienen comentarios con una descripción antes de su comienzo</b> <br>";
			
	   	   	for ($i=0; $i < count($ficherosTodos) ; $i++) { 
	   	   		//Iremos tratando fichero a fichero
	   	   		
	   	   		$contFunciones = 0;//para saber en que funcion estamos en cada momento
				$sinError = true; //se pondra a false si aparece una funcion que no esta comentada
				$funcionError = array();//para almacenar en nombre de cada funcion que no cumpla el requisito
				$numeroLinea = 0; //Para saber en que linea estamos del fichero
			  	$arrayFile = array(); //Array en el que guardaremos cada linea que nos interese del archivo
			  	$lineaError = array();//Array en el que guardamos el numero de la linea original de cada funcion que da error
			  	$arrayLinea = array();//Array en el que guardamos el numero de linea de cada funcion en el archivo original
	   	   	 	if(!preg_match("/.+\.(png|pdf|jpg|gif)$/" , $ficherosTodos[$i])){//para todos los ficheros que no son propietarios
	   	   	 		
	   	   	 		if (!$fConf = fopen($ficherosTodos[$i], "r")){
			   		 echo "No se ha podido abrir el archivo<br>";
					}//en if que cumprueba si el fichero se ha podido abrir
			  	    else{
			  	    	if(filesize($ficherosTodos[$i]) <= 0){
							echo "$ficherosTodos[$i]  <font color=\"red\"> ERROR : El archivo esta vacio</font><br>";
							$analizados += 1;
							$errores += 1;	
						} 
			  	    	
			  	    	else{
						   	while (($line = fgets($fConf)) !== false) {		
				   				//Nos aseguramos que solo guardamos la lineas que nos interesan, es decir, se omiten
				   				// aquellas en blanco, que puedan contener espacios y tabuladores y ademas las lineas
				   				//que estan comentadas pero no aportarian informacion es decir que no tienen texto
				   				//despues del comentario
				   				$numeroLinea++;  
					   	 		if(!preg_match('/^\s*(((((\/){2,}|#)*\s*)*)[^A-Za-z]*)*$/',$line) || preg_match('/^\s*(\/\*)|(\*\/)\s*$/',$line)) { 
					   	 			$arrayFile[] = $line;
					   	 		}
					   	 		//Dado a que vamos a eliminar las lineas en blanco y los comentarios que no aportan
					   	 		//nada las posiciones del array en el que se inserte el fichero no van a coincidir con las lineas
					   	 		//del fichero original. Para solucionar esto cada vez que aparezca una linea con una funcion guardaremos
					   	 		//dicha linea en un array para mas tarde imprimir por pantalla la linea original donde se produce el error
					   	 		if(preg_match('/^\s*function\s+[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/' , $line)){
					   	 			$arrayLinea[] = $numeroLinea; //Si aparece una funcion guardamos su numero de linea en el array
					   	 		}	
					   	 				
						    }//end while que recorre el fichero linea a linea	 
						  
				   		 	//si aparece un /**/ en distintas lineas lo da como bueno aunque no tenga cotenido en su interior
				
							if(count($arrayLinea) > 0){

								for($j=0; $j<count($arrayFile); $j++){//ahora recorremos el array que contiene el fichero buscando funciones
							
								//Parte de la primera expresion regular se ha sacado del manual de php
								//Si se encuentra una funcion lo que hay antes No es un comentario esa funcion no cumple el criterio
									if(preg_match('/^\s*function\s+[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/' , $arrayFile[$j]) && 
										!preg_match('/^\s*((\/\/)|#|(\/\*))/',$arrayFile[$j-1])  &&
											!preg_match('/^\s*\*\/\s*$/',$arrayFile[$j-1]) ) {
										//	echo "$contFunciones<br>";
										$lineaError[] = $arrayLinea[$contFunciones];//guardamos la linea original de las funciones que dan error
										//$contFunciones++;
										$funcionError[] = strstr($arrayFile[$j], ")" , true).")";//guardamos el nombre da la funcion erronea
										$sinError = false;
									}
				
									//Cada vez que aparce una funcion aumentamos el contador para saber que funcion estamos tratando
									if(preg_match('/^\s*function\s+[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/' , $arrayFile[$j])){
								   	 	$contFunciones++;
								   	}	
								}

									if($sinError == true){
										echo"$ficherosTodos[$i] OK<br>";
										$analizados += 1;
									}

									else{					
										echo"$ficherosTodos[$i] ERROR<br>";
										for($k=0; $k<count($lineaError); $k++){
											echo "$funcionError[$k] sin comentarios de descripcion en la linea $lineaError[$k]<br>";	
										}		
										$analizados += 1;
										$errores += 1;								
									}
							}

							else{
								echo"$ficherosTodos[$i] El archivo no tiene funciones <br>";
				   	   	 		$analizados += 1;
							}					
							fclose($fConf);
				   	   	}
				   	   	 	
					}
				}//end else grande
				else{//ESTO SE PUEDE QUITAR Y DEJARLO SOLO EN LA PARTE 3 PUES REPETIRIA EL ERROR
			   	   	 		echo"$ficherosTodos[$i]  <font color=\"red\"> ERROR: NO ES PROPIETARIO </font><br>";
			   	   	 		$analizados += 1;
							$errores += 1;	
			   	   	}				   	   				
	   	   	} //end for que recorre cada posicion del array ficherosTodos para ir comprobando si cada archivo tienen el comentario de cabecera
	   	   	 	 echo "<br>$analizados Elementos analizados / Numero de errores : $errores<br>";
			     $analizados = 0;
		   	   	 $errores = 0;


//LA SALIDA TIENEN QUE MOSTRAR LAS FUNCIONES QUE SE HAN ANAILIZADO NO LOS FICHEROS ANALIZADOS
//PARTE 5  
/*
En esta parte iremos recorriendo cada fichero a analizar y guardandolo en un array sin aquellas lineas que esten vacias
o que tengan comentarios redundantes(no aporten informacion), mientras hacemos esto aprovecharemos para ir obteniendo 
el nombre de cada nueva variable que aparece y guardarla en un array multidimensional junto a la linea en la que 
aparece en el fichero original(para luego imprimirla en caso de error) y junto a la posicion del array en la que se 
guarda la linea en la que aparece por primera vez dicha variable(para luego solamente consultar las posinones del 
array que contienen variables que aparecen por primera vez)
La idea es que si una variable aparece por primera vez ella sola en una linea y esta comentada en la misma linea o 
antes, dicha variable estara correcta, pero si no se cumple esto o directamente esta dentro de una estructura de 
control o funcion por primera vez sin haber sido inicializada antes, dara un error
*/
			echo "<b><br>5 En el codigo están todas las variables definidas antes de su uso y tienen un comentario antes o en la misma linea</b> <br>";
			
	   	   	for ($i=0; $i < count($ficherosTodos) ; $i++) { 
	   	   		//Iremos tratando fichero a fichero
	   	   		
	   	 
				$sinError = true; //se pondra a false si aparece una variable que no esta comentada
				$numeroLinea = 0; //Para saber en que linea estamos del fichero
			  	$arrayFile = array(); //Array en el que guardaremos cada linea que nos interese del archivo
			  	$arrayMulti = array();//Primera columna: Nombre de la variable   Segunda col: Linea de su primera apericion en el fichero   Tercera col: Posicion del array arrayFile en la que se guarda
	   	   	 	$arrayNomVar = array();//Se usa para llevar el control de las variables que ya han aparecido en el fichero
	   	   	 	$arrayMultiVarError = array();//Primera columna: Nombre de la variable no comentada Segunda: linea de la variable en el fichero original
	   	   	 	if(!preg_match("/.+\.(png|pdf|jpg|gif)$/" , $ficherosTodos[$i])){//para todos los ficheros que no son propietarios
	   	   	 		if (!$fConf = fopen($ficherosTodos[$i], "r")){
			   		 echo "No se ha podido abrir el archivo<br>";
					}//en if que cumprueba si el fichero se ha podido abrir
			  	    else{
			  	    	if(filesize($ficherosTodos[$i]) <= 0){
							echo "$ficherosTodos[$i]  <font color=\"red\"> ERROR : El archivo esta vacio</font><br>";
	
						} 
			  	    	
			  	    	else{
			  	    		$s=0;
						   	while (($line = fgets($fConf)) !== false) {		
				   				//Nos aseguramos que solo guardamos la lineas que nos interesan, es decir, se omiten
				   				// aquellas en blanco, que puedan contener espacios y tabuladores y ademas las lineas
				   				//que estan comentadas pero no aportarian informacion es decir que no tienen texto
				   				//despues del comentario
				   				$numeroLinea++;  
					   	 		if(!preg_match('/^\s*(((((\/){2,}|#)*\s*)*)[^A-Za-z]*)*$/',$line) || preg_match('/^\s*(\/\*)|(\*\/)\s*$/',$line)) { 
					   	 			$arrayFile[] = $line;
					   	 		//	echo"$line<br>";
					   	 		}
					   	 		if(preg_match('/\$[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/' , $line)){
					   	 			 //Si aparece una variable guardamos su numero de linea en el array
					   	 			$arrayString = array();//Si la linea tienen variable la recorremos como si fuese un array y vamos almacenando las posiciones desde el primer dolar hasta el final de la variable en un array que luego pasaremos a string y asi sacamos los nombres de las variables
					   	 			$nombreVar = "";// para guardar el nombre de la variable actual
					   	 			$flagVariable = false;//para saber cuando estamos guardando una variable
					   	 			
					   	 			for ($x=0; $x <strlen($line) ; $x++) { 
					   	 				
					   	 				if($flagVariable == true && preg_match('/[a-zA-Z0-9_]/' , $line[$x])){//Si se esta guardando una variable y es un caracter valido para una variable se sigue guardando
					   	 					$arrayString[] = $line[$x]; 
					   	 				}
					   	 				else if($flagVariable == true && !preg_match('/[a-zA-Z0-9_]/' , $line[$x])){//Si se esta guardadno una variable pero el caracter ya no es valido para una variable paramos
					   	 					$flagVariable = false;
					   	 					$nombreVar = implode("",$arrayString);
					   	 					if(!in_array($nombreVar,$arrayNomVar)){
					   	 						$arrayNomVar[] = $nombreVar;//Para llevar el control de la variables que aparecen varias veces, solo nos interesa su primera aparicion
					   	 						$arrayMulti[$s][0] = $nombreVar; //ESTO SE PUEDE CAMBIAR POR UN CLAVE VALOR DONDE LA CLAVE SERIA EL NUMERO DE LINEA Y EL VALOR EL NOMBRE DE LA VARIABLE EVITANDONOS ASI ANDAR JUGANDO CON DOS ARRAYS A LA VEZ
					   	 						$arrayMulti[$s][1] = $numeroLinea;
					   	 						$arrayMulti[$s][2] = count($arrayFile)-1;
					   	 						$s++;
					   	 					}
					   	 					$arrayString = array();
					   	 					
					   	 				}
					   	 				if(preg_match('/\$/' ,$line[$x]) && preg_match('/[a-zA-Z_\x7f-\xff]/' ,$line[$x+1]) && $flagVariable == false){//Si aparece el comienzo de una variable empezamos a guardar el nombre se dicha variable
					   	 					$arrayString[] = $line[$x];
					   	 					$x++;
					   	 					$arrayString[] = $line[$x];
					   	 					$flagVariable = true;
					   	 				}
					   	 			}
					   	 		}			   	 		
					   	 				
						    }//end while que recorre el fichero linea a linea	 
				   		 	//si aparece un /**/ en distintas lineas lo da como bueno aunque no tenga cotenido en su interior				
							if(count($arrayMulti) > 0){//Si su tamaño es > 0 entonces podremos afirmar que el archivo tiene almenos una variable
								$indice = 0;
								for($j=0; $j<count($arrayMulti); $j++){//solo accederemos a las posiciones de arrayFile que tengan variables que aparecen por primera vez en el fichero
							
									//Si la variable que aparece por primera vez cumple el criterio no se hace nada
									if(preg_match('/^\s*(var\s+)?\$[a-zA-Z_][a-zA-Z0-9_]*\s*(=\s*.*)?;?((\/){2,}|#+|(\/\*))(.*([A-Za-z]+\s*)+.*)*+$/' , $arrayFile[$arrayMulti[$j][2]]) || (preg_match('/^\s*(var\s+)?\$[a-zA-Z_][a-zA-Z0-9_]*\s*(=\s*.*)?;?$/' , $arrayFile[$arrayMulti[$j][2]]) && (
										preg_match('/^\s*((\/\/)|#|(\/\*))/',$arrayFile[$arrayMulti[$j][2]-1])  ||
											preg_match('/^\s*\*\/\s*$/',$arrayFile[$arrayMulti[$j][2]-1]) ) ) ) {
												$analizados += 1;
								
									}
									else{//si no se almacena para luego imprimir el error
										$sinError = false;
										$arrayMultiVarError[$indice][0] = $arrayMulti[$j][0];
										$arrayMultiVarError[$indice][1] = $arrayMulti[$j][1];
										$indice ++;
										$analizados += 1;
										$errores += 1;	
									}
				
								}
									if($sinError == true){//En caso de que todas las variables esten comentadas en su primer uso damos el OK
										echo"$ficherosTodos[$i]  OK<br>";
										$analizados += 1;
									}
									else{//en caso contrario indicamos que variables no estan comentadas en su primer uso y su linea					
										echo"$ficherosTodos[$i] ERROR<br>";
										for($k=0; $k<count($arrayMultiVarError); $k++){
											echo $arrayMultiVarError[$k][0]." sin comentarios de descripcion en la linea ".$arrayMultiVarError[$k][1]."<br>";	
										}		
							
									}
							}
							else{
								echo"$ficherosTodos[$i] El archivo no tiene variables <br>";
				   	   	 		
							}					
							fclose($fConf);
				   	   	}
				   	   	 	
					}
				}//end else grande
				else{//ESTO SE PUEDE QUITAR Y DEJARLO SOLO EN LA PARTE 3 PUES REPETIRIA EL ERROR
			   	   	 		echo"$ficherosTodos[$i]  <font color=\"red\"> ERROR: NO ES PROPIETARIO </font><br>";
			   	   	}				   	   				
	   	   	} //end for que recorre cada posicion del array ficherosTodos para ir comprobando si cada archivo tienen el comentario de cabecera
	   	   	 	 echo "<br>$analizados Variables analizadas / Numero de errores : $errores<br>";
			     $analizados = 0;
		   	   	 $errores = 0;


//PARTE 6

	echo "<b><br>6 En el codigo están comentadas todas las estructuras de control antes de uso o en la misma linea</b> <br>";
			
	   	  	for ($i=0; $i < count($ficherosTodos) ; $i++) { 
	   	   		//Iremos tratando fichero a fichero
	   	   		
	   	 
				$sinError = true; //Se pondra a false si aparece una estructura que no esta comentada
				$numeroLinea = 0; //Para saber en que linea estamos del fichero
			  	$arrayFile = array(); //Array en el que guardaremos cada linea que nos interese del archivo
	   	   	 	$arrayEstructuras = array();//Primera columna: Nombre de la estructura   Segunda col: Linea en la que se encuentra en el fichero   Tercera col: Posicion del array arrayFile en la que se guarda
	   	   	 	$arrayEstructurasError = array();//Array en el que se guardaran los datos de aquellas estructuras que no esten comentadas


	   	   	 	if(!preg_match("/.+\.(png|pdf|jpg|gif)$/" , $ficherosTodos[$i])){//para todos los ficheros que no son propietarios
	   	   	 		if (!$fConf = fopen($ficherosTodos[$i], "r")){
			   		 echo "No se ha podido abrir el archivo<br>";
					}//en if que cumprueba si el fichero se ha podido abrir
			  	    else{
			  	    	if(filesize($ficherosTodos[$i]) <= 0){
							echo "$ficherosTodos[$i]  <font color=\"red\"> ERROR : El archivo esta vacio</font><br>";
	
						} 
			  	    	
			  	    	else{
			  	    		$s=0;
			  	    		$arrayEstructuras = array();
						   	while (($line = fgets($fConf)) !== false) {		
				   				//Nos aseguramos que solo guardamos la lineas que nos interesan, es decir, se omiten
				   				// aquellas en blanco, que puedan contener espacios y tabuladores y ademas las lineas
				   				//que estan comentadas pero no aportarian informacion es decir que no tienen texto
				   				//despues del comentario
				   				$numeroLinea++;  
					   	 		if(!preg_match('/^\s*(((((\/){2,}|#)*\s*)*)[^A-Za-z]*)*$/',$line) || preg_match('/^\s*(\/\*)|(\*\/)\s*$/',$line)) { 
					   	 			$arrayFile[] = $line;
					   	 		//	echo"$line<br>";
					   	 		}

					   	 		//Se ira comprobando cada posible estructura de control y en caso que aparezca alguna guardaremos
					   	 		//su nombre, numero de linea en el fichero y la posicion en la que se guarda en el array
					   	 		if(preg_match('/if\s*\(.*\)/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "IF";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}
					   	 		else if(preg_match('/\s*else/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "ELSE";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}
					   	 		else if(preg_match('/else\s*if\s*\(.*\)/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "ELSEIF";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}	
					   	 		else if(preg_match('/\s*while\s*\(.*\)\s*((\{)|(:))/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "WHILE";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}
					   	 		else if(preg_match('/\s*do\s*\{/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "DO";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}
					   	 		else if(preg_match('/\s*for\s*\((.*;.*;.*)\)\s*/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "FOR";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}	
					   	 		else if(preg_match('/\s*foreach\s*\((.*;.*;.*)\)/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "FOREACH";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;

					   	 		}		
					   	 		else if(preg_match('/\s*continue[^\w]/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "CONTINUE";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}			   	 		
					   	 		else if(preg_match('/\s*switch\s*\((.*)\)/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "SWITCH";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}
					   	 		else if(preg_match('/\s*declare[^\w]/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "DECLARE";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}							   	
					   	 		else if(preg_match('/\s*require[^\w]/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "REQUIRE";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}		   	 		
					   	 		else if(preg_match('/\s*include[^\w]/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "INCLUDE";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 	
					   	 			$s++;
					   	 		}						   	 
					   	 		else if(preg_match('/\s*goto[^\w]/' , $line)){
					   	 			$arrayEstructuras[$s][0] = "GOTO";
					   	 			$arrayEstructuras[$s][1] = $numeroLinea; 
					   	 			$arrayEstructuras[$s][2] = count($arrayFile)-1; 
					   	 			$s++;
					   	 		}				


						    }//end while que recorre el fichero linea a linea	 
				   		 	//si aparece un /**/ en distintas lineas lo da como bueno aunque no tenga cotenido en su interior				

							if(count($arrayEstructuras) > 0){//Si su tamaño es > 0 entonces podremos afirmar que el archivo tiene almenos una variable
								$indice = 0;
								for($j=0; $j<count($arrayEstructuras); $j++){//solo accederemos a las posiciones de arrayFile que tengan variables que aparecen por primera vez en el fichero
							
									//Si la estrucutra de control esta comentada antes o en su propia linea no se hace nada
									if(preg_match('/(if|else|else\s*if|while|do|for|foreach|continue|switch|declare|require|include|goto).*((\/){2,}|#+|(\/\*))(.*([A-Za-z]+\s*)+.*)*+$/' , $arrayFile[$arrayEstructuras[$j][2]]) || (preg_match('/(if|else|else\s*if|while|do|for|foreach|continue|switch|declare|require|include|goto)/' , $arrayFile[$arrayEstructuras[$j][2]]) && (
										preg_match('/^\s*((\/\/)|#|(\/\*))/',$arrayFile[$arrayEstructuras[$j][2]-1])  ||
											preg_match('/^\s*\*\/\s*$/',$arrayFile[$arrayEstructuras[$j][2]-1]) ) ) ) {
												$analizados += 1;
								
									}

									else{//si no se almacena para luego imprimir el error
										$sinError = false;
										$arrayEstructurasError[$indice][0] = $arrayEstructuras[$j][0];
										$arrayEstructurasError[$indice][1] = $arrayEstructuras[$j][1];
										$indice ++;
										$analizados += 1;
										$errores += 1;	
									}
				
								}

									if($sinError == true){//En caso de que todas las estructuras de control
										echo"$ficherosTodos[$i]  OK<br>";
										$analizados += 1;
									}

									else{//en caso contrario indicamos que estructuras de control no estan comentadas				
										echo"$ficherosTodos[$i] ERROR<br>";
										for($k=0; $k<count($arrayEstructurasError); $k++){
											echo "<font color=\"red\">".$arrayEstructurasError[$k][0]." sin comentarios de descripcion en la linea ".$arrayEstructurasError[$k][1]."</font><br>";	
										}		
							
									}
							}

							else{
								echo"$ficherosTodos[$i] El archivo no tiene estructuras de control <br>";
				   	   	 		
							}					
							fclose($fConf);
				   	   	}
				   	   	 	
					}
				}//end else grande

				else{//ESTO SE PUEDE QUITAR Y DEJARLO SOLO EN LA PARTE 3 PUES REPETIRIA EL ERROR
			   	   	 		echo"$ficherosTodos[$i]  <font color=\"red\"> ERROR: NO ES PROPIETARIO </font><br>";
			   	   	}		

	   	   	} //end for que recorre cada posicion del array ficherosTodos para ir comprobando si cada archivo tienen el comentario de cabecera
	   	   	 	 echo "<br>$analizados Estructuras de control analizadas / Numero de errores : $errores<br>";
			     $analizados = 0;
		   	   	 $errores = 0;





/*NOTAS

-Si el comentario contiene una letra ya se da por bueno, esto se puede modificar para que tenga que tener mas letras


*/



//	FUNCIONES

	$fConf;
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

	$dir;
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