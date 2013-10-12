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

function Titulacion_Utils_numeroLetra($numero, $decimales = 1) {
	$flotante = number_format($numero,$decimales);
	
	$decenas_letra = array (3 => 'TREINTA', 4 => 'CUARENTA', 5 => 'CINCUENTA', 6 => 'SESENTA', 7 => 'SETENTA', 8 => 'OCHENTA', 9 => 'NOVENTA', 10 => 'CIEN');
	$unidades_letra = array(0 => '', 1 => 'Y UNO', 2 => 'Y DOS', 3 => 'Y TRES', 4 => 'Y CUATRO', 5 => 'Y CINCO', 6 => 'Y SEIS', 7 => 'Y SIETE', 8 => 'Y OCHO', 9 => 'Y NUEVE');
	$especiales_letra = array(0 => 'CERO', 1 => 'UNO', 2 => 'DOS', 3 => 'TRES', 4 => 'CUATRO', 5 => 'CINCO', 6 => 'SEIS', 7 => 'SIETE', 8 => 'OCHO', 9 => 'NUEVE', 10 => 'DIEZ', 11 => 'ONCE', 12 => 'DOCE', 13 => 'TRECE', 14 => 'CATORCE', 15 => 'QUINCE', 16 => 'DIECISEIS', 17 =>'DIECISIETE', 18 => 'DIECIOCHO', 19 => 'DIECINUEVE', 20 => 'VEINTE', 21 => 'VEINTIUNO', 22 => 'VEINTIDOS', 23 => 'VEINTITRES', 24 => 'VEINTICUATRO', 25 => 'VEINTICINCO', 26 => 'VEINTISEIS', 27 => 'VEINTISIETE', 28 => 'VEINTIOCHO', 29 => 'VEINTINUEVE');
	
	$explote = explode (".", $flotante);
	$parte_entera = (int) $explote[0];
	$parte_flotante = (int) $explote[1];
	
	if ($parte_entera < 30) {
		$cadena_entero = $especiales_letra[$parte_entera];
	} else {
		$unidad = $parte_entera % 10;
		$decena = ($parte_entera - $unidad) / 10;
		$cadena_entero = trim ($decenas_letra[$decena].' '.$unidades_letra[$unidad]);
	}
	
	$cadena_flotante = '';
	if ($parte_flotante != 0) {
		if ($parte_flotante < 30) {
			$cadena_flotante = 'PUNTO '.$especiales_letra[$parte_flotante];
		} else {
			$unidad = $parte_flotante % 10;
			$decena = ($parte_flotante - $unidad) / 10;
			$cadena_flotante = trim ('PUNTO '.$decenas_letra[$decena].' '.$unidades_letra[$unidad]);
		}
	}
	
	return trim ($cadena_entero.' '.$cadena_flotante);
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

function Titulacion_Utils_formatearDomicilio ($dom) {
	return $dom->calle.' #'.$dom->numero_exterior.(($dom->numero_interior != '') ? ' Int '.$dom->numero_interior : '').', colonia '.$dom->colonia.' C.P. '.$dom->codigo_postal.'.'.(($dom->telefono_casa != '') ? ' Tel. '.Titulacion_Utils_formatearTelefono($dom->telefono_casa) : '').(($dom->telefono_celular != '') ? ' Cel. '.Titulacion_Utils_formatearTelefono ($dom->telefono_celular) : '');
}
