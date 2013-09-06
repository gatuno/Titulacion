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
				
}