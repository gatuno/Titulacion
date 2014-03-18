<?php

Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');
Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');

class Titulacion_Views_Acta {
	public $index_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.visualizar-actas'));
	public function index($request, $match) {
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Alumno_Seleccionar ($request->POST, array ());
			if ($form->isValid ()) {
				$codigo = $form->save ();

				$alumno = new Calif_Alumno ();
				if (false === ($alumno->get ($codigo))) {
					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Alumno::agregarAlumno', array (), array ('acta' => 1, 'alumno' => $codigo), false);
				} else {
					$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Alumno::editarAlumno', array ($alumno->codigo), array ('acta' => 1), false);
				}

				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Alumno_Seleccionar (null, array ());
		}
		$acta = new Titulacion_Acta ();
		
		$pag = new Gatuf_Paginator($acta);
		$pag->model_view = 'paginador';
		
		/* Solo las actas válidas */
		$filtro_elim = new Gatuf_SQL ('eliminada=%s', 0);
		$filtro = array();
		
		$pag->action = array ('Titulacion_Views_Acta::index');
		$pag->sumary = 'Lista de actas registradas';
		
		/* Verificar filtro de materias por opcion */
		$filtro['o'] = $request->session->getData('filtro_acta_opcion',null);
		if (!is_null ($filtro['o']) ){
			$sql = new Gatuf_SQL ('opcion=%s', $filtro['o']);
			$filtro_elim->SAnd($sql);
			$filtro['o'] = (new Titulacion_Opcion ($filtro['o']))->descripcion;
		}
		
		/* Verificar filtro de materias por plan de estudios */
		$filtro['p'] = $request->session->getData('filtro_acta_plan',null);
		if(!is_null ($filtro['p']) ){
			$sql = new Gatuf_SQL ('plan=%s', $filtro['p']);
			$filtro_elim->SAnd($sql);
			$filtro['p'] = (new Titulacion_PlanEstudio ($filtro['p']))->descripcion;
		}
		
		/* Verificar filtro de materias por plan de estudios */
		$filtro['c'] = $request->session->getData('filtro_acta_carrera',null);
		if(!is_null ($filtro['c']) ){
			$sql = new Gatuf_SQL ('carrera=%s', $filtro['c']);
			$filtro_elim->SAnd($sql);
			$filtro['c'] = (new Titulacion_Carrera ($filtro['c']))->descripcion;
		}
		
		/* Filtro por años */
		$filtro['a'] = $request->session->getData ('filtro_acta_anio', null);
		if (!is_null ($filtro['a'])) {
			$sql = new Gatuf_SQL ('anio=%s', $filtro['a']);
			$filtro_elim->SAnd ($sql);
			$filtro['a'] = 'Por año: '.$filtro['a'];
		}
		
		$pag->forced_where = $filtro_elim;
		
		$list_display = array (
			array('folio', (is_null ($filtro['a']) ? 'Gatuf_Paginator_FKLink' : 'Gatuf_Paginator_FKExtra'), 'Folio'),
			array('plan', (is_null ($filtro['p']) ? 'Gatuf_Paginator_FKLink' : 'Gatuf_Paginator_FKExtra'),'Plan de estudios'),
			array('carrera',(is_null ($filtro['c']) ? 'Gatuf_Paginator_FKLink' : 'Gatuf_Paginator_FKExtra') ,'Carrera'),
			array('opcion',(is_null ($filtro['o']) ? 'Gatuf_Paginator_FKLink' : 'Gatuf_Paginator_FKExtra'), 'Opcion de titulacion'),
			array('alumno','Gatuf_Paginator_DisplayVal', 'Codigo del alumno'),
			array('alumno_nombre','Gatuf_Paginator_DisplayVal', 'Nombre'),
			array('alumno_apellido','Gatuf_Paginator_DisplayVal', 'Apellidos'),
			array('fechahora','Gatuf_Paginator_DateYMDHM','Fecha ceremonia'),
			array('ingreso','Gatuf_Paginator_DisplayVal','Calendario de ingreso'),
			array('egreso','Gatuf_Paginator_DisplayVal','Calendario de egreso')
		);
		
		$pag->items_per_page = 25;
		$pag->no_results_text = 'No hay actas de titulacion disponibles';
		$pag->max_number_pages = 3;
		$pag->configure ($list_display,
			array ('alumno','folio','ingreso','egreso','carrera', 'alumno_nombre', 'alumno_apellido', 'opcion_descripcion', 'plan_descripcion', 'carrera_descripcion'),
			array ('alumno','folio','ingreso','egreso','carrera')
		);
		$pag->setFromRequest($request);
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/acta/index.html',
		                                         array('page_title' => 'Actas de titulacion',
		                                               'form' => $form,
		                                               'paginador'  => $pag,
													   'filtro' => $filtro,
													   ),
		                                         $request);
	}
	public function porCarrera ($request, $match){
		$carrera = new Titulacion_Carrera ();
		
		if (false === ($carrera->get ($match[1]))) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$request->session->setData('filtro_acta_carrera',$carrera->clave);
		
		$url = Gatuf_HTTP_URL_urlForView('Titulacion_Views_Acta::index');
		return new Gatuf_HTTP_Response_Redirect ($url);
	}
	
	public function porOpcion ($request, $match){
		$opcion = new Titulacion_Opcion ();
		
		if (false === ($opcion->get ($match[1]))) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$request->session->setData('filtro_acta_opcion',$opcion->id);
		
		$url = Gatuf_HTTP_URL_urlForView('Titulacion_Views_Acta::index');
		return new Gatuf_HTTP_Response_Redirect ($url);
	}
	
	public function porPlan ($request, $match){
		$plan = new Titulacion_PlanEstudio ();
		
		if (false === ($plan->get ($match[1]))) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$request->session->setData('filtro_acta_plan',$plan->id);
		
		$url = Gatuf_HTTP_URL_urlForView('Titulacion_Views_Acta::index');
		return new Gatuf_HTTP_Response_Redirect ($url);
	}
	
	public function porAnio ($request, $match) {
		$num = (int) $match[1];
		
		if ($num < 1968 || $num > date ('Y')) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$request->session->setData ('filtro_acta_anio', $num);
		
		$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index');
		return new Gatuf_HTTP_Response_Redirect ($url);
	}
	
	public function eliminarFiltro($request, $match){
		if($match[1] == 'o')
			$request->session->setData('filtro_acta_opcion',null);
		if($match[1] == 'p')
			$request->session->setData('filtro_acta_plan',null);
		if($match[1] == 'c')
			$request->session->setData('filtro_acta_carrera',null);
		if ($match[1] == 'a')
			$request->session->setData ('filtro_acta_anio', null);
		$url = Gatuf_HTTP_URL_urlForView('Titulacion_Views_Acta::index');
		return new Gatuf_HTTP_Response_Redirect ($url);
	}

	public $agregarActa_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.generar-actas'));
	public function agregarActa ($request, $match) {
		Gatuf::loadFunction ('Titulacion_Utils_formatearDomicilio');
		$alumno = new Calif_Alumno ();

		if (false === ($alumno->get ($match[1]))) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$domicilio = new Titulacion_Domicilio ();

		if (false === ($domicilio->get ($match[2]))) {
			throw new Gatuf_HTTP_Error404 ();
		}

		if ($alumno->codigo != $domicilio->alumno) {
			throw new Gatuf_HTTP_Error404 ();
		}

		$extra = array ('alumno' => $alumno, 'domicilio' => $domicilio);

		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Acta_Agregar ($request->POST, $extra);

			if ($form->isValid ()) {
				$acta = $form->save (false);

				$acta->creador = $request->user->id;
				$acta->modificador = $request->user->id;

				$acta->alumno = $alumno;
				$acta->domicilio = $domicilio;
				$acta->create_user = $request->user;
				$acta->modification_user = $request->user;
				$acta->create ();

				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index');
				return new Gatuf_HTTP_Response_Redirect($url);
			}
		} else {
			$form = new Titulacion_Form_Acta_Agregar (null, $extra);
		}
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/acta/agregar-acta.html',
		                                         array('page_title' => 'Nueva acta de titulacion',
		                                               'alumno' => $alumno,
		                                               'domicilio' => Titulacion_Utils_formatearDomicilio ($domicilio),
		                                               'form' => $form),
		                                         $request);
	}
	
	public $verActa_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.visualizar-actas'));
	public function verActa($request, $match, $params = array ()){
		$acta = new Titulacion_Acta ();

		if (false === $acta->get ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}
		
		$acta_eliminada = null;
		$eliminador = null;
		if ($acta->eliminada) {
			$sql = new Gatuf_SQL ('acta=%s', $acta->id);
			$acta_eliminada = Gatuf::factory ('Titulacion_ActaEliminada')->getOne (array ('filter' => $sql->gen ()));
			
			$usuario = $acta_eliminada->get_usuario ();
			$eliminador = new Calif_Maestro ($usuario->login);
		}
		
		$alumno = $acta->get_alumno ();
		$opcion = $acta->get_opcion ();
		$modalidad = $opcion->get_modalidad ();
		$carrera = $acta->get_carrera ();
		$plan = $acta->get_plan ();
		$director = $acta->get_director ();
		$secretario = $acta->get_secretario ();
		$jurado1 = $acta->get_jurado1 ();
		$jurado2 = $acta->get_jurado2 ();
		$jurado3 = $acta->get_jurado3 ();

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
		                                                'page_title' => 'Ver Acta',
		                                                'acta_eliminada' => $acta_eliminada,
		                                                'eliminador' => $eliminador,
		                                         ),
		                                         $request);
	}

	public $imprimirActa_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.imprimir-actas'));
	public function imprimirActa ($request, $match){
		$acta = new Titulacion_Acta ();

		if (false === $acta->get ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}

		if ($acta->eliminada) {
			$request->user->setMessage (3, 'No se puede imprimir el acta. El acta con folio '.$acta->carrera.' '.$acta->folio.'/'.date ("%Y", $acta->fechahora).' ha sido marcada como eliminada');
			$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::verActa', $acta->id);
			return new Gatuf_HTTP_Response_Redirect ($url);
		}

		$alumno = $acta->get_alumno ();
		$opcion = $acta->get_opcion ();
		$modalidad = $opcion->get_modalidad ();
		$carrera = $acta->get_carrera ();
		$plan = $acta->get_plan ();
		$director = $acta->get_director ();
		$secretario = $acta->get_secretario ();
		$jurado1 = $acta->get_jurado1 ();
		$jurado2 = $acta->get_jurado2 ();
		$jurado3 = $acta->get_jurado3 ();

		$pdf = new Titulacion_PDF_Acta ('P', 'mm','Legal');

		$pdf->acta = $acta;
		$pdf->jurado1 = $jurado1;
		$pdf->jurado2 = $jurado2;
		$pdf->jurado3 = $jurado3;
		$pdf->carrera = $carrera;
		$pdf->opcion = $opcion;
		$pdf->alumno = $alumno;
		$pdf->modalidad = $modalidad;
		$pdf->director = $director;
		$pdf->secretario = $secretario;
		$pdf->renderBase ();

		$pdf->Close ();
		$nombre_pdf = 'Acta_'.$acta->alumno.'.pdf';

		$pdf->Output ('/tmp/'.$nombre_pdf, 'F');

		return new Gatuf_HTTP_Response_File ('/tmp/'.$nombre_pdf, $nombre_pdf, 'application/pdf', true);
	}

	public $imprimirProtesta_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.imprimir-actas'));
	public function imprimirProtesta($request, $match) {
		$acta = new Titulacion_Acta();

		if (false === $acta->get ($match[1])){
			throw new Gatuf_HTTP_Error404 ();
		}

		if ($acta->eliminada) {
			$request->user->setMessage (3, 'No se puede imprimir la protesta. El acta con folio '.$acta->carrera.' '.$acta->folio.'/'.date ("%Y", $acta->fechahora).' ha sido marcada como eliminada');
			$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::verActa', $acta->id);
			return new Gatuf_HTTP_Response_Redirect ($url);
		}

		$alumno = $acta->get_alumno ();
		$carrera = $acta->get_carrera ();
		$director = $acta->get_director ();
		$secretario = $acta->get_secretario ();
		$jurado1 = $acta->get_jurado1 ();
		$jurado2 = $acta->get_jurado2 ();
		$jurado3 = $acta->get_jurado3 ();

		$protesta = new Titulacion_PDF_Protesta ('P', 'mm','Letter');

		$protesta->acta = $acta;
		$protesta->jurado1 = $jurado1;
		$protesta->jurado2 = $jurado2;
		$protesta->jurado3 = $jurado3;
		$protesta->carrera = $carrera;
		$protesta->alumno = $alumno;
		$protesta->director = $director;
		$protesta->secretario = $secretario;
		$protesta->renderBase ();

		$protesta->Close ();

		$nombre_pdf = 'Protesta_'.$acta->alumno.'.pdf';

		$protesta->Output ('/tmp/'.$nombre_pdf, 'F');

		return new Gatuf_HTTP_Response_File ('/tmp/'.$nombre_pdf, $nombre_pdf, 'application/pdf', true);
	}

	public $imprimirCitatorio_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.imprimir-actas'));
	public function imprimirCitatorio ($request, $match) {
		$acta = new Titulacion_Acta();

		if (false === $acta->get ($match[1])){
			throw new Gatuf_HTTP_Error404 ();
		}

		if ($acta->eliminada) {
			$request->user->setMessage (3, 'No se puede imprimir la protesta. El acta con folio '.$acta->carrera.' '.$acta->folio.'/'.date ("%Y", $acta->fechahora).' ha sido marcada como eliminada');
			$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::verActa', $acta->id);
			return new Gatuf_HTTP_Response_Redirect ($url);
		}

		$alumno = $acta->get_alumno ();
		$secretario = $acta->get_secretario ();
		$jurado1 = $acta->get_jurado1 ();
		$jurado2 = $acta->get_jurado2 ();
		$jurado3 = $acta->get_jurado3 ();
		$carrera = $acta->get_carrera ();

		$citatorio = new Titulacion_PDF_Citatorio ('P', 'mm','Letter');

		$citatorio->acta = $acta;
		$citatorio->jurado1 = $jurado1;
		$citatorio->jurado2 = $jurado2;
		$citatorio->jurado3 = $jurado3;
		$citatorio->carrera = $carrera;
		$citatorio->alumno = $alumno;
		$citatorio->secretario = $secretario;
		$citatorio->renderBase ();

		$citatorio->Close ();
		$nombre_al = str_replace (' ', '_', $alumno->apellido.'_'.$alumno->nombre);
		$nombre_pdf = 'Citatorio_'.$nombre_al.'.pdf';

		$citatorio->Output ('/tmp/'.$nombre_pdf, 'F');

		return new Gatuf_HTTP_Response_File ('/tmp/'.$nombre_pdf, $nombre_pdf, 'application/pdf', true);
	}

	public $actualizarActa_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.actualizar-actas'));
	public function actualizarActa ($request, $match) {
		Gatuf::loadFunction ('Titulacion_Utils_formatearDomicilio');
		$acta = new Titulacion_Acta ();

		if (false === $acta->get ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}

		if ($acta->eliminada) {
			$request->user->setMessage (3, 'No se puede actualizar el acta. La acta con folio '.$acta->carrera.' '.$acta->folio.'/'.date ("%Y", $acta->fechahora).' ha sido marcada como eliminada');
			$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::verActa', $acta->id);
			return new Gatuf_HTTP_Response_Redirect ($url);
		}

		$alumno = $acta->get_alumno ();
		$opcion = $acta->get_opcion ();
		$modalidad = $opcion->get_modalidad ();
		$carrera = $acta->get_carrera ();
		$plan = $acta->get_plan ();
		$domicilio = $acta->get_domicilio ();

		$extra = array ('acta' => $acta);
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Acta_Editar ($request->POST, $extra);

			if ($form->isValid ()){
				$acta = $form->save (false);
				$acta->modificador = $request->user;

				$acta->update ();

				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::verActa', $acta->id);
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Acta_Editar (null, $extra);
		}

		return Gatuf_Shortcuts_RenderToResponse ('titulacion/acta/edit-acta.html',
		                                         array ('page_title' => 'Actualizar acta',
		                                                'alumno' => $alumno,
		                                                'opcion' => $opcion,
		                                                'modalidad' => $modalidad,
		                                                'carrera' => $carrera,
		                                                'plan' => $plan,
		                                                'acta' => $acta,
		                                                'domicilio' => Titulacion_Utils_formatearDomicilio ($domicilio),
		                                                'form' => $form),
		                                         $request);
	}

	public $eliminarActa_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.eliminar-actas'));
	public function eliminarActa ($request, $match) {
		$acta = new Titulacion_Acta ();

		if (false == $acta->get ($match[1])) {
			throw new Gatuf_HTTP_Error404 ();
		}

		if ($acta->eliminada) {
			$request->user->setMessage (3, 'El acta con folio '.$acta->carrera.' '.$acta->folio.'/'.date ("%Y", $acta->fechahora).' ya ha sido eliminada');
			$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::index_eliminadas');
			return new Gatuf_HTTP_Response_Redirect ($url);
		}

		$alumno = $acta->get_alumno ();
		$opcion = $acta->get_opcion ();
		$modalidad = $opcion->get_modalidad ();
		$carrera = $acta->get_carrera ();
		$plan = $acta->get_plan ();

		$extra = array ('acta' => $acta);

		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Acta_Eliminar ($request->POST, $extra);

			if ($form->isValid ()) {
				$acta_eliminada = $form->save (false);

				$acta_eliminada->usuario = $request->user;

				$acta_eliminada->create ();

				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Acta::verActa', $acta_eliminada->acta);
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Acta_Eliminar (null, $extra);
		}

		return Gatuf_Shortcuts_RenderToResponse ('titulacion/acta/eliminar-acta.html',
		                                         array ('page_title' => 'Eliminar acta',
		                                                'alumno' => $alumno,
		                                                'opcion' => $opcion,
		                                                'modalidad' => $modalidad,
		                                                'carrera' => $carrera,
		                                                'acta' => $acta,
		                                                'plan' => $plan,
		                                                'form' => $form),
		                                         $request);
	}

	public $index_eliminadas_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.visualizar-actas'));
	public function index_eliminadas($request, $match) {
		$actas = new Titulacion_Acta ();

		$pag = new Gatuf_Paginator($actas);
		$pag->action = array ('Titulacion_Views_Acta::index');
		$pag->sumary = 'Lista de actas eliminadas';
		$pag->model_view = 'paginador';
		
		$list_display = array (
			array('folio', 'Gatuf_Paginator_FKExtra', 'Folio'),
			array('plan','Gatuf_Paginator_FKExtra','Plan de estudios'),
			array('opcion_descripcion','Gatuf_Paginator_DisplayVal', 'Opcion de titulacion'),
			array('carrera','Gatuf_Paginator_FKExtra','Carrera'),
			array('alumno','Gatuf_Paginator_DisplayVal', 'Codigo del alumno'),
			array('alumno_nombre','Gatuf_Paginator_DisplayVal', 'Nombre'),
			array('alumno_apellido','Gatuf_Paginator_DisplayVal', 'Apellidos'),
		);

		$pag->items_per_page = 25;
		$pag->no_results_text = 'No hay actas de titulacion disponibles';
		$pag->max_number_pages = 3;
		$pag->configure ($list_display,
			array ('alumno','folio','ingreso','egreso','carrera', 'alumno_nombre', 'alumno_apellido', 'opcion_descripcion'),
			array ('alumno','folio','ingreso','egreso','carrera')
		);
		$pag->setFromRequest($request);

		/* La magia de los filtros acumulativos */
		$filtro = new Gatuf_SQL ('eliminada=%s', 1);

		$pag->forced_where = $filtro;

		return Gatuf_Shortcuts_RenderToResponse ('titulacion/acta/eliminadas.html',
		                                         array('page_title' => 'Actas de titulacion eliminadas',
		                                               'paginador'  => $pag),
		                                         $request);
	}
}
