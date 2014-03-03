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
	
	$sql = 'CREATE VIEW '.$db->pfx.'opciones_view AS '."\n"
	    .'SELECT '.$opcion_tabla.'.*, '.$modalidad_tabla.'.descripcion as carrera_desc'."\n"
	    .'FROM '.$opcion_tabla."\n"
	    .'LEFT JOIN '.$modalidad_tabla.' ON '.$opcion_tabla.'.modalidad = '.$modalidad_tabla.'.id';
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

