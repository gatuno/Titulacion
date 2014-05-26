<?php
$ctl_t = array ();
if (!isset ($base)) $base = Gatuf::config ('titulacion_base');
/* Bloque base:
$ctl_t[] = array (
	'regex' => '#^/ /$#',
	'base' => $base,
	'model' => 'Titulacion_',
	'method' => '',
);
*/

$ctl_t[] = array (
	'regex' => '#^/$#',
	'base' => $base,
	'model' => 'Titulacion_Views',
	'method' => 'index',
);

$ctl_t[] = array (
	'regex' => '#^/preferences/$#',
	'base' => $base,
	'model' => 'Titulacion_Views',
	'method' => 'preferences',
);

/* Listado de carreras */
$ctl_t[] = array (
	'regex' => '#^/carreras/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Carrera',
	'method' => 'index',
);

$ctl_t[] = array(
	'regex' => '#^/carrera/([A-Za-z]{3,5})/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Carrera',
	'method' => 'verCarrera',
);

$ctl_t[] = array(
	'regex' => '#^/carrera/([A-Za-z]{3,5})/update/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Carrera',
	'method' => 'actualizarCarrera',
);

$ctl_t[] = array (
	'regex' => '#^/carreras/add/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Carrera',
	'method' => 'agregarCarrera',
);

/* Listado de alumnos */
$ctl_t[] = array (
	'regex'=>'#^/alumnos/add/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Alumno',
	'method' =>'agregarAlumno'
);

$ctl_t[] = array (
	'regex' => '#^/alumno/seleccionar/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Alumno',
	'method' => 'seleccionarAlumno',
);

$ctl_t[] = array (
	'regex' => '#^/alumno/(\w\d{8})/update/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Alumno',
	'method' => 'editarAlumno',
);

/* Modalidades de titulacion */
$ctl_t[] = array (
	'regex' => '#^/opciones/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Modalidad',
	'method' => 'index',
);

$ctl_t[] = array (
	'regex' => '#^/opciones/add/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Modalidad',
	'method' => 'agregarOpcion',
);

$ctl_t[] = array (
	'regex' => '#^/opcion/(\d+)/update/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Modalidad',
	'method' => 'actualizarOpcion',
);

$ctl_t[] = array (
	'regex' => '#^/opcion/(\d+)/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Modalidad',
	'method' => 'verOpcion',
);

$ctl_t[] = array (
	'regex' => '#^/opcion/(\d+)/json/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Modalidad',
	'method' => 'jsonOpcion',
);

/* Listado de actas de titulacion */
$ctl_t[] =array (
	'regex' => '#^/actas/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'index',
);

$ctl_t[] = array (
	'regex' => '#^/actas/add/(\w\d{8})/(\d+)/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'agregarActa',
);

$ctl_t[] =array(
	'regex' => '#^/acta/(\d+)/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'verActa',
);

$ctl_t[] =array(
	'regex' => '#^/actas/f/o/(\d+)/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'porOpcion',
);

$ctl_t[] =array(
	'regex' => '#^/actas/f/p/(\d+)/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'porPlan',
);

$ctl_t[] =array(
	'regex' => '#^/actas/f/c/([a-zA-Z]{3})/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'porCarrera',
);

$ctl_t[] =array(
	'regex' => '#^/actas/f/a/(\d+)/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'porAnio',
);

$ctl_t[] =array(
	'regex' => '#^/actas/f/t/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'porFecha',
);

$ctl_t[] =array(
	'regex' => '#^/acta/nofiltro/([opcat])/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'eliminarFiltro',
);

$ctl_t[] =array(
	'regex' => '#^/acta/(\d+)/update/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'actualizarActa',
);

$ctl_t[] =array(
	'regex' => '#^/acta/(\d+)/imprimir/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'imprimirActa',
);

$ctl_t[] =array(
	'regex' => '#^/acta/(\d+)/protesta/$#',	
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'imprimirProtesta',
);

$ctl_t[] =array(
	'regex' => '#^/acta/(\d+)/citatorio/$#',	
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'imprimirCitatorio',
);

$ctl_t[] =array(
	'regex' => '#^/acta/(\d+)/eliminar/$#',	
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'eliminarActa',
);

$ctl_t[] =array (
	'regex' => '#^/actas/eliminadas/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_Acta',
	'method' => 'index_eliminadas',
);

/* Listado de los planes de estudio */
$ctl_t[] = array (
	'regex' => '#^/planes/$#',
	'base' => $base,
	'model' => 'Titulacion_Views_PlanEstudio',
	'method' => 'index',
);

return $ctl_t;
