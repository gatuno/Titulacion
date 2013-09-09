<?php

public function Titulacion_Utils_grado ($sexo, $grado) {
	switch ($grado) {
		case 'I':
			return 'Ing.';
			break;
		case 'L':
			return 'Lic.';
			break;
		case 'D':
			if ($sexo == 'M') { 
				return 'Dra.';}
			else return 'Dr.';
			break;
		case 'M':
			 if ($sexo == 'M'){
				return 'Mtra.';}
			else return 'Mtro.';
			break;
		default: return 'No implementado';
	}
}