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
	'regex' => '#^/preferences/$#',
	'base' => $base,
	'model' => 'Titulacion_Views',
	'method' => 'preferences',
);

/* Listado de carreras */
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

/* Listado de alumnos */
$ctl[] = array (
	'regex' => '#^/alumnos/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Alumno',
	'method' => 'index',
);

$ctl[] = array (
	'regex'=>'#^/alumnos/add/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Alumno',
	'method' =>'agregarAlumno'
);

$ctl[] = array (
	'regex' => '#^/alumno/(\w\d{8})/update/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Alumno',
	'method' => 'editarAlumno',
);

$ctl[] = array (
	'regex' => '#^/alumno/(\w\d{8})/json/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Alumno',
	'method' => 'jsonAlumno',
);

/* Modalidades de titulacion */
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

$ctl[] = array (
	'regex' => '#^/modalidad/(\d+)/json/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Modalidad',
	'method' => 'jsonOpcion',
);

/* Listado de actas de titulacion */
$ctl[] =array (
	'regex' => '#^/actas/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'index',
);

$ctl[] = array (
	'regex' => '#^/actas/add/(\w\d{8})/(\d+)/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'agregarActa',
);

$ctl[] =array(
	'regex' => '#^/acta/(\d+)/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'verActa',
);

$ctl[] =array(
	'regex' => '#^/acta/(\d+)/update/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'actualizarActa',
);

$ctl[] =array(
	'regex' => '#^/acta/(\d+)/imprimir/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'imprimirActa',
);

$ctl[] =array(
	'regex' => '#^/acta/(\d+)/imprimir/promedio/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'imprimirPromedio',
);

/* Listado de los planes de estudio */
$ctl[] = array (
	'regex' => '#^/planes/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_PlanEstudio',
	'method' => 'index',
);

/* Bloque para los maestros */
$ctl[] = array (
	'regex' => '#^/maestros/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Maestro',
	'method' => 'index',
);

$ctl[] = array(
	'regex' => '#^/maestros/add/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Maestro',
	'method' => 'agregarMaestro',
);

return $ctl;
