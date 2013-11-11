<?php

$user_model = Gatuf::config('gatuf_custom_user','Gatuf_User');
$m = array ();

$m['Titulacion_ActaEliminada'] = array ('relate_to' => array ('Titulacion_Acta', $user_model));
$m['Titulacion_Domicilio'] = array ('relate_to' => array ('Calif_Alumno'));
$m['Titulacion_Opcion'] = array ('relate_to' => array ('Titulacion_Modalidad'));
$m['Titulacion_Acta'] = array ('relate_to' => array ('Titulacion_PlanEstudio', 'Titulacion_Carrera', 'Calif_Alumno', 'Titulacion_Opcion', 'Calif_Maestro', 'Titulacion_Domicilio', $user_model));

/* Conexión de señales aquí */
return $m;
