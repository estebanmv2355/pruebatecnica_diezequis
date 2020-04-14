<?php
		session_start();
		include('Conexion.php');
		date_default_timezone_set('America/Bogota');
		$usuario= $_POST['usuario'];
		$contrasena= $_POST['contrasena'];
		$sesion= $_POST['sesion'];
		$contrasenaEncript= md5($contrasena);
		
		function decrypt($string, $key) 
		{
			$result = "";
			$string = base64_decode($string);
			for($i=0; $i<strlen($string); $i++) 
			{
				$char = substr($string, $i, 1);
				$keychar = substr($key, ($i % strlen($key))-1, 1);
				$char = chr(ord($char)-ord($keychar));
				$result.=$char;
			}
			return $result;
		}
			
		if($sesion == '')
		{
			$sesion = 0;
		}
		
		if (($contrasena == NULL)or($usuario == NULL))
		{
			$contrasenaMala= "1";
			header("LOCATION:../index.php?varContrasena=$contrasenaMala");     
			session_destroy();
		}
		else
		if($contrasena != '' and $usuario != '')
		{
			$contrasenaMala= "2";
			//$con = mysqli_query($conectar,"select * from usuario where UPPER(usu_usuario) = UPPER('".$usuario."') and UPPER(usu_clave) = UPPER('".$contrasena."')");
			$con = mysqli_query($conectar,"select * from usuario where UPPER(usu_usuario) = UPPER('".$usuario."')");
			$dato = mysqli_fetch_array($con);
			$usu = $dato['usu_usuario'];
			$contra = $dato['usu_clave'];
			
			//if(strtoupper($usu) != strtoupper($usuario) || strtoupper($contra) != strtoupper($contrasena))
			if(strtoupper($usu) != strtoupper($usuario) || $contrasena != decrypt($contra,"p4v4svasquez"))//hash_hmac('sha512', 'salt' . $contrasena, 'p4v4svasquez')
			{
				header("LOCATION:../index.php?varContrasena=$contrasenaMala");
				session_destroy();
			}
			else
			{
				$con = mysqli_query($conectar,"select usu_sw_activo from usuario where usu_usuario = '".$usuario."'");
				$dato = mysqli_fetch_array($con);
				$act = $dato['usu_sw_activo'];
				$obr = $dato['obr_clave_int'];
				if($act == 0)
				{
					header("LOCATION:../index.php?varContrasena=3");
					session_destroy();
				}
				else
				{					
					$_SESSION['persona']= $contra;
					$_SESSION['usuario']= $usuario;
					setcookie("usIdentificacion",$usuario);
					setcookie("clave",$contra);
					$identificador= session_id();
					$fecha=date("Y/m/d H:i:s");
					/*$sql = mysqli_query($conectar,"select * from sesion where usu_usuario = '".$usu."'");
					$dato = mysqli_fetch_array($sql);
					$u = $dato['usu_usuario'];
					if($u == $usu)
					{
						$sql = mysqli_query($conectar,"update sesion set ses_activa = '".$sesion."' where usu_usuario = '".$usu."'");
					}
					else
					{
						$sql = mysqli_query($conectar,"insert into sesion values('null','".$usu."','".$sesion."')");
					}*/
					//echo "insert into log_actividades(loa_clave_int,ven_clave_int,tia_clave_int,ash_clave_int,asd_clave_int,art_clave_int,obr_clave_int,loa_usu_actualiz,loa_fec_actualiz) values(null,,4,,,,'".$obr."','".$usuario."','".$fecha."')";
					mysqli_query($conectar,"insert into log_actividades(loa_clave_int,ven_clave_int,tia_clave_int,loa_usu_actualiz,loa_fec_actualiz) values(null,'',4,'".$usuario."','".$fecha."')");//Tercer campo tia_clave_int. 4=Inicio Sesion
					header("LOCATION:../principal.php");
				}
			}
		}
?> 