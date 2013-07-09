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
	'regex' => '#^/carreras/add/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Carrera',
	'method' => 'agregarCarrera',
);

$ctl[] = array (
	'regex'=>'#^/alumnos/$#',
	'base'=> $base,
	'model'=>'Titulacion_Views_Alumno',
	'method'=>'index',
);

$ctl[] = array (
	'regex'=>'#^/alumnos/add/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Alumno',
	'method' =>'agregarAlumno'
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

$ctl[] =array (
	'regex' => '#^/actas/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'index',
);

$ctl[] = array (
	'regex' => '#^/planes/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_PlanEstudio',
	'method' => 'index',
);

return $ctl;
