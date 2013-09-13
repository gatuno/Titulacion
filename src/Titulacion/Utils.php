<?php

function Titulacion_Utils_grado ($sexo, $grado) {
	switch ($grado) {
		case 'I':
			return 'Ing.';
			break;
		case 'L':
			return 'Lic.';
			break;
		case 'D':
			if ($sexo == 'F') { 
				return 'Dra.';}
			else return 'Dr.';
			break;
		case 'M':
			 if ($sexo == 'F'){
				return 'Mtra.';}
			else return 'Mtro.';
			break;
		default: throw new Exception ('No implementado');
	}
}

function Titulacion_Utils_numeroLetra($numero) {
	$flotante = number_format($numero,1);
	
	$decenas = array (60 => 'SESENTA', 70 => 'SETENTA', 80 => 'OCHENTA', 90 => 'NOVENTA', 100 => 'CIEN');
	$enteroCali = array(1=> 'Y UNO', 2=> 'Y DOS', 3=> 'Y TRES', 4=> 'Y CUATRO', 5=> 'Y CINCO', 6=> 'Y SEIES', 7=> 'Y SIETE', 8=>'Y OCHO', 9=> 'Y NUEVE');
	$punto = array(1=> 'PUNTO UNO', 2=> 'PUNTO DOS', 3=>'PUNTO TRES', 4=> 'PUNTO CUATRO', 5=>'PUNTO CINCO' ,6=>'PUNTO SIES', 7=>'PUNTO SIETE', 8=>'PUNTO OCHO', 9=>'PUNTO NUEVE');
	$entero = array(1 => 'PRIMERO', 2 => 'DOS', 3 => 'TRES', 4 => 'CUATRO', 5 => 'CINCO', 6 => 'SEIS', 7 => 'SIETE', 8=> 'OCHO', 9=> 'NUEVE', 10=> 'DIEZ', 11=> 'ONCE', 12=> 'DOCE', 13=> 'TRECE', 14=> 'CATORCE', 15=> 'QUINCE', 16=> 'DIECISEIS', 17 =>'DIECISIETE',18=> 'DIECIOCHO', 19=> 'DIECINUEVE', 20=> 'VEINTE', 21=> 'VEINTIUNO', 22=>'VEINTIDOS', 23=> 'VEINTITRES', 24=> 'VEINTICUATRO', 25=> 'VEINTICINCO',26=> 'VEINTISEIS', 27=>'VEINTISIETE', 28=>'VEINTIOCHO', 29=> 'VEINTINUEVE', 30=> 'TREINTA', 31 =>'TREINTA Y UNO');
	$decimales = array (0,0);
	
	if ($flotante >= 60) {
		$decimales = explode(".",$flotante);
		if ($decimales[1] != 0){
			$x = $decimales[1];
			$punto[$x];
		} else if (($decimales[0]%10) != 0) {
			$x = $flotante%10;
			$entero[$x];
		}
		if (($decimales[0]%10) != 0) {
			$j= $flotante%10;
			$enteroCali[$j];
			$i = ($flotante-($flotante%10));
			$decenas[$i];
		}
		if (($decimales[1] != 0) && (($decimales[0]%10) != 0)) {
			$cadena= $decenas[$i].' '.$enteroCali[$j].' '.$punto[$x];
		} else if (($decimales[0]%10) != 0) {
			$cadena = $decenas[$i].' '.$enteroCali[$j];
		} else {
			$cadena = $decenas[$i];
		}
	} else if ($numero <32){
		$x = $numero;
		$entero[$x];
		$cadena = $entero[$x];
	}
	
	return $cadena;
}

function Titulacion_Utils_formatearTelefono ($numero) {
	if (strlen ($numero) < 10) {
		if (strlen ($numero) < 4) {
			return (string) $numero;
		}
		return substr ($numero, 0, -4).'-'.substr ($numero, -4);
	}
	
	$inicio = substr ($numero, 0, 2);
	
	if ($inicio == '33' || $inicio == '55' || $inicio == '81') {
		return '('.$inicio.') '.substr ($numero, 2, 4).'-'.substr ($numero, 6);
	} else {
		return '('.substr ($numero, 0, 3).') '.substr ($numero, 3, 3).'-'.substr ($numero, 6);
	}
}
