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
	$db = Gatuf::db ();
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
	$db = Gatuf::db ();
	
	
}

function Titulacion_Migrations_Install_1Vistas_teardown ($params = null) {
	$db = Gatuf::db ();
	
	$views = array ();
	
	foreach ($views as $view) {
		$sql = 'DROP VIEW '.$db->pfx.$view;
		
		$db->execute ($sql);
	}
}

