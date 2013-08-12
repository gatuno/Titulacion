<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_Acta {
	
	public $index_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.visualizar-titulacion'));
	public function index($request, $match) {
		$actas=new Titulacion_Acta ();
		
		$pag = new Gatuf_Paginator ($actas);
		$pag->action = array ('Titulacion_Views_Acta::index');
		$pag->sumary = 'Lista de actas registradas';
		
		$list_display = array (
			array('folio', 'Gatuf_Paginator_DisplayVal', 'Folio'),
			array('acta','Gatuf_Paginator_DisplayVal', 'Numero de acta'),
			array('carrera','Gatuf_Paginator_FKExtra','Carrera'),
			array('alumno','Gatuf_Paginator_DisplayVal', 'Codigo del alumno'),
			array('alumno_nombre','Gatuf_Paginator_DisplayVal', 'Nombre'),
			array('alumno_apellido','Gatuf_Paginator_DisplayVal', 'Apellidos'),
			array('plan_descripcion','Gatuf_Paginator_DisplayVal','Plan de estudios'),
			array('modalidad_descripcion','Gatuf_Paginator_DisplayVal', 'Opcion de titulacion'),
			array('fechaHora','Gatuf_Paginator_DisplayVal','Fecha/Hora'),
			array('ingreso','Gatuf_Paginator_DisplayVal','Calendario de ingreso'),
			array('egreso','Gatuf_Paginator_DisplayVal','Calendario de egreso')
		);
		
		$pag->items_per_page = 25;
		$pag->no_results_text = 'No hay actas de titulacion disponibles';
		$pag->max_number_pages = 3;
		$pag->configure ($list_display,
				array ('alumno','folio','acta','ingreso','egreso','carrera'),
				array ('alumno','folio','acta','ingreso','egreso','carrera')
		        );
		$pag-> setFromRequest($request);
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/acta/index.html',
												array('page_title' => 'Actas de titulacion',
												'paginador'  => $pag),
												$request);
	}
	
	public $agregarActa_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.generar-actas'));
	public function agregarActa ($request, $match) {
		if($request->method == 'POST'){
			$form = new Titulacion_Form_Acta_Agregar ($request->POST, array());
			
			if($form-> isValid ()){
				$acta = $form->save ();
				
				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index');
				return new Gatuf_HTTP_Response_Redirect($url);
			}
		}else {
			$form = new Titulacion_Form_Acta_Agregar (null, array ());
		}
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/acta/edit-acta.html',
												array('page_title' => 'Nueva acta de titulacion',
													   'form' => $form),
												$request);
	
	
	}
	
	public $verActa_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.visualizar-titulacion'));
	public function verActa($request, $match, $params = array ()){
		$acta = new Titulacion_Acta ();
		
		if (false == $acta->getActa ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$alumno = new Titulacion_Alumno ();
		$alumno->getAlumno ($acta->alumno);
		
		$opcion = new Titulacion_Opcion ();
		$opcion->getOpcion ($acta->opcion);
		
		$modalidad = new Titulacion_Modalidad ();
		$modalidad->getModalidad ($opcion->modalidad);
		
		$carrera = new Titulacion_Carrera ();
		$carrera->getCarrera ($acta->carrera);
		
		$plan = new Titulacion_PlanEstudio ();
		$plan->getPlan ($acta->plan);
		
		$director = new Titulacion_Maestro ();
		$director->getMaestro ($acta->director_division);
		
		$secretario = new Titulacion_Maestro ();
		$secretario->getMaestro ($acta->secretario_division);
		
		$jurado1 = new Titulacion_Maestro ();
		$jurado1->getMaestro ($acta->jurado1);
		
		$jurado2 = new Titulacion_Maestro ();
		$jurado2->getMaestro ($acta->jurado2);
		
		$jurado3 = new Titulacion_Maestro ();
		$jurado3->getMaestro ($acta->jurado3);
	}
	
}
