<?php

function Titulacion_Migrations_Install_setup ($params=null) {
	$models = array ('Titulacion_Acta',
	                 'Titulacion_ActaEliminada',
	                 'Titulacion_Carrera',
	                 'Titulacion_Domicilio',
	                 'Titulacion_Modalidad',
	                 'Titulacion_Opcion',
	                 'Titulacion_PlanEstudio',
	                 );
	Gatuf::loadFunction('Titulacion_DB_getConnection');
	$db = &Titulacion_DB_getConnection();
	$schema = new Gatuf_DB_Schema ($db);
	foreach ($models as $model) {
		$schema->model = new $model ();
		$schema->createTables ();
	}
	
	foreach ($models as $model) {
		$schema->model = new $model ();
		$schema->createConstraints ();
	}
	
	//Titulacion_Migrations_Install_1Vistas_setup ();
	Titulacion_Migrations_Install_2Modalidades_setup ();
	Titulacion_Migrations_Install_3Planes_setup ();
}

function Titulacion_Migrations_Install_teardown ($params=null) {
	$models = array ('Titulacion_Acta',
	                 'Titulacion_ActaEliminada',
	                 'Titulacion_Carrera',
	                 'Titulacion_Domicilio',
	                 'Titulacion_Modalidad',
	                 'Titulacion_Opcion',
	                 'Titulacion_PlanEstudio',
	                 );
	//Titulacion_Migrations_Install_1Vistas_teardown ();
	
	$db = Gatuf::db ();
	$schema = new Gatuf_DB_Schema ($db);
	
	foreach ($models as $model) {
		$schema->model = new $model ();
		$schema->dropConstraints();
	}
	
	foreach ($models as $model) {
		$schema->model = new $model ();
		$schema->dropTables ();
	}
}

function Titulacion_Migrations_Install_1Vistas_setup ($params = null) {
	/* Crear todas las vistas necesarias */
	Gatuf::loadFunction('Titulacion_DB_getConnection');
	$db = Titulacion_DB_getConnection();
	
	$opcion_tabla = Gatuf::factory ('Titulacion_Opcion')->getSqlTable ();
	$modalidad_tabla = Gatuf::factory ('Titulacion_Modalidad')->getSqlTable ();
	$alumno_tabla = Gatuf::factory ('Calif_Alumno')->getSqlTable ();
	$acta_tabla = Gatuf::factory ('Titulacion_Acta')->getSqlTable ();
	$plan_tabla = Gatuf::factory ('Titulacion_PlanEstudio')->getSqlTable ();
	$carrera_tabla = Gatuf::factory ('Titulacion_Carrera')->getSqlTable ();
	
	$sql = 'CREATE VIEW '.$db->pfx.'opciones_view AS '."\n"
	    .'SELECT '.$opcion_tabla.'.*, '.$modalidad_tabla.'.descripcion as modalidad_desc'."\n"
	    .'FROM '.$opcion_tabla."\n"
	    .'LEFT JOIN '.$modalidad_tabla.' ON '.$opcion_tabla.'.modalidad = '.$modalidad_tabla.'.id';
	$db->execute ($sql);
	
	$sql = 'CREATE VIEW '.$db->pfx.'actas_view AS '."\n"
	    .'SELECT '.$acta_tabla.'.*, YEAR (create_time) as anio, '.$alumno_tabla.'.nombre as alumno_nombre, '.$alumno_tabla.'.apellido as alumno_apellido, '.$opcion_tabla.'.descripcion as opcion_descripcion,'."\n"
	    .$plan_tabla.'.descripcion as plan_descripcion, '.$carrera_tabla.'.descripcion as carrera_descripcion'."\n"
	    .'FROM '.$acta_tabla."\n"
	    .'LEFT JOIN '.$alumno_tabla.' ON '.$acta_tabla.'.alumno = '.$alumno_tabla.'.codigo'."\n"
	    .'LEFT JOIN '.$opcion_tabla.' ON '.$acta_tabla.'.opcion = '.$opcion_tabla.'.id'."\n"
	    .'LEFT JOIN '.$plan_tabla.' ON '.$acta_tabla.'.plan = '.$plan_tabla.'.id'."\n"
	    .'LEFT JOIN '.$carrera_tabla.' ON '.$acta_tabla.'.carrera = '.$carrera_tabla.'.clave';
	$db->execute ($sql);
}

function Titulacion_Migrations_Install_1Vistas_teardown ($params = null) {
	$db = Gatuf::db ();
	
	$views = array ('opciones_view');
	
	foreach ($views as $view) {
		$sql = 'DROP VIEW '.$db->pfx.$view;
		
		$db->execute ($sql);
	}
}

function Titulacion_Migrations_Install_2Modalidades_setup ($params = null) {
	$modalidad_model = new Titulacion_Modalidad ();
	
	$modalidades = array ('Desempeño académico sobresaliente',
	                      'Exámenes',
	                      'Producción de materiales educativos',
	                      'Investigación y estudios de posgrados',
	                      'Tesis e Informes'
	                      );
	
	foreach ($modalidades as $mod) {
		$modalidad_model->descripcion = $mod;
		
		$modalidad_model->create (true);
	}
}

function Titulacion_Migrations_Install_3Planes_setup ($params = null) {
	$plan_model = new Titulacion_PlanEstudio ();
	
	$planes = array ('Créditos',
	                 'Rígido',
	                 'Créditos (Incorporadas)',
	                 'Rígido (Incorporadas)'
	);
	
	foreach ($planes as $plan) {
		$plan_model->descripcion = $plan;
		
		$plan_model->create (true);
	}
}

