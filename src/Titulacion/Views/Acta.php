<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_Acta {
	
	public $index_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.visualizar-titulacion'));
	public function index($request, $match) {
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Alumno_Seleccionar ($request->POST, array ());
			if ($form->isValid ()) {
				$codigo = $form->save ();
				
				$alumno = new Titulacion_Alumno ();
				if (false === ($alumno->getAlumno ($codigo))) {
					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Alumno::agregarAlumno', array (), array ('acta' => 1));
				} else {
					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Alumno::editarAlumno', array ($alumno->codigo), array ('acta' => 1));
				}
				
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Alumno_Seleccionar (null, array ());
		}
		$actas=new Titulacion_Acta ();
		
		$pag = new Gatuf_Paginator($actas);
		$pag->action = array ('Titulacion_Views_Acta::index');
		$pag->sumary = 'Lista de actas registradas';
		
		$list_display = array (
			array('folio', 'Gatuf_Paginator_FKLink', 'Folio'),
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
		$pag->setFromRequest($request);
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/acta/index.html',
												array('page_title' => 'Actas de titulacion',
												'form' => $form,
												'paginador'  => $pag),
												$request);
	}
	
	public $agregarActa_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.generar-actas'));
	public function agregarActa ($request, $match) {
		$alumno = new Titulacion_Alumno ();
		
		if (false === ($alumno->getAlumno ($match[1]))) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$domicilio = new Titulacion_Domicilio ();
		
		if (false === ($domicilio->getDomicilio ($match[2]))) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		if ($alumno->codigo != $domicilio->alumno) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$extra = array ('alumno' => $alumno, 'domicilio' => $domicilio);
		
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Acta_Agregar ($request->POST, $extra);
			
			if ($form-> isValid ()) {
				$acta = $form->save (false);
				
				$acta->creador = $request->user->codigo;
				$acta->modificador = $request->user->codigo;
				
				$acta->create ();
				
				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index');
				return new Gatuf_HTTP_Response_Redirect($url);
			}
		} else {
			$form = new Titulacion_Form_Acta_Agregar (null, $extra);
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
		$opcion->getOpcion ($acta->modalidad);
		
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
		
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/acta/ver-acta.html',
		                                         array ('acta' => $acta,
		                                                'alumno' => $alumno,
		                                                'opcion' => $opcion,
		                                                'modalidad' => $modalidad,
		                                                'carrera' => $carrera,
		                                                'plan' => $plan,
		                                                'director' => $director,
		                                                'secretario' => $secretario,
		                                                'jurado1' => $jurado1,
		                                                'jurado2' => $jurado2,
		                                                'jurado3' => $jurado3,
		                                                'page_title' => 'Ver Acta'
		                                         ),
		                                         $request);
	}
	
	/*Aqui se hace la prueba para generar el PDF*/
	//queda pendiente hacer que cuando se descargue el pdf tenga por nombre: codigo.pdf
	public function imprimirActa ($request, $match){
		$acta = new Titulacion_Acta ();
		$match[1];
		if (false == $acta->getActa ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$alumno = new Titulacion_Alumno ();
		$alumno->getAlumno ($acta->alumno);
		
		$opcion = new Titulacion_Opcion ();
		$opcion->getOpcion ($acta->modalidad);
		
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
		
		$pdf = new Titulacion_PDF_Acta ('P', 'mm','Legal');
		
		$pdf->acta = $acta;
		$pdf->jurado1 = $jurado1;
		$pdf->jurado2 = $jurado2;
		$pdf->jurado3 = $jurado3;
		$pdf->carrera = $carrera;
		$pdf->opcion = $opcion;
		$pdf->modalidad = $modalidad;
		$pdf->director = $director;
		$pdf->secretario = $secretario;
		$pdf->renderBase ();
		
		$pdf->Close ();
		$nombre_pdf = $acta->alumno;
 		
		$nombre_pdf .= '.pdf';
		$pdf->Output ('/tmp/'.$nombre_pdf, 'F');
		
		return new Gatuf_HTTP_Response_File ('/tmp/'.$nombre_pdf, $nombre_pdf, 'application/pdf', true);
	}

	
	public function imprimirPromedio ($request, $match) {
		$acta = new Titulacion_Acta ();
		
		if (false == $acta->getActa ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		throw new Exception ('No implementado');
	}
	
	public function actualizarActa ($request, $match) {
		$acta = new Titulacion_Acta ();
		
		if (false == $acta->getActa ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		throw new Exception ('No implementado');
	}
}
