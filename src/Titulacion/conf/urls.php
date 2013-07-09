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
	'regex' => '#^/$#',
	'base' => $base,
	'model' => 'Titulacion_Views',
	'method' => 'index',
);

$ctl[] = array (
	'regex' => '#^/login/$#',
	'base' => $base,
	'model' => 'Titulacion_Views',
	'method' => 'login',
	'name' => 'login_view'
);

$ctl[] = array (
	'regex' => '#^/logout/$#',
	'base' => $base,
	'model' => 'Titulacion_Views',
	'method' => 'logout',
);

/* Recuperación de contraseñas */
$ctl[] = array (
	'regex' => '#^/password/$#',
	'base' => $base,
	'model' => 'Titulacion_Views',
	'method' => 'passwordRecoveryAsk',
);

$ctl[] = array (
	'regex' => '#^/password/ik/$#',
	'base' => $base,
	'model' => 'Titulacion_Views',
	'method' => 'passwordRecoveryInputCode',
);

$ctl[] = array (
	'regex' => '#^/password/k/(.*)/$#',
	'base' => $base,
	'model' => 'Titulacion_Views',
	'method' => 'passwordRecovery',
);

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

$ctl[] = array (
	'regex' => '#^/maestros/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Maestro',
	'method' => 'index',
);

$ctl[] = array (
	'regex' => '#^/maestros/add/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Maestro',
	'method' => 'agregarMaestro',
);


return $ctl;
