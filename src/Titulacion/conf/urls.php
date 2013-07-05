<?php
$base = Gatuf::config('titulacion_base');
$ctl = array ();

/* Bloque base:
$ctl[] = array (
	'regex' => '#^/ /$#',
	'base' => $base,
	'model' => 'Titulacion_',
	'method' => '',
);
*/

$ctl[] = array (
	'regex' => '#^/carreras/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Carrera',
	'method' => 'index',
);

$ctl[] = array (
	'regex'=>'#^/alumnos/$#',
	'base'=>$base,
	'model'=>'Titulacion_Views_Alumno',
	'method'=>'index',
);

$ctl[] = array (
	'regex' => '#^/modalidades/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Modalidad',
	'method' => 'index',
);

$ctl[] = array (
	'regex' => '#^/modalidades/add/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Modalidad',
	'method' => 'agregarOpcion',
);

return $ctl;
