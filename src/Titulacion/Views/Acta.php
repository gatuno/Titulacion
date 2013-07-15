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
			array('numeroActa','Gatuf_Paginator_DisplayVal', 'Numero de acta'),
			array('carrera','Gatuf_Paginator_DisplayVal','Carrera'),
			array('alumno','Gatuf_Paginator_DisplayVal', 'Codigo del alumno'),
			array('alumno_nombre','Gatuf_Paginator_DisplayVal', 'Nombre'),
			array('alumno_apellido','Gatuf_Paginator_DisplayVal', 'Apellidos'),
			array('planEstudios','Gatuf_Paginator_DisplayVal','Plan de estudios'),
			array('opcTitulacion_descripcion','Gatuf_Paginator_DisplayVal', 'Opcion de titulacion'),
			array('fechaHora','Gatuf_Paginator_DisplayVal','Fecha/Hora'),
			array('ingreso','Gatuf_Paginator_DisplayVal','Calendario de ingreso'),
			array('egreso','Gatuf_Paginator_DisplayVal','Calnedario de egreso')
		);
		
		$pag->items_per_page = 25;
		$pag->no_results_text = 'No hay actas de titulacion disponibles';
		$pag->max_number_pages = 3;
		$pag->configure ($list_display,
				array ('alumno','folio','numeroActa','ingreso','egreso','carrera'),
				array ('alumno','folio','numeroActa','ingreso','egreso','carrera')
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
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/acta/edit-opcion.html',
												array('page_title' => 'Nueva acta de titulacion',
													   'form' => $form),
												$request);
	
	
	}
	
	public $verActa_precond = array (array ('Gatuf_Precondition::hasPerm', 'Titulacion.visualizar-titulacion'));
	public function verActa($request, $match, $params = array ()){
		$acta = new Titulacion_Acta ();
		
		if(false == $acta->getActa ($match[1])) {
			throw new Gatuf_HTTP_Error404();
		}
		
		$sql = new Gatuf_SQL ('id=%s',$acta->id);
		
		$pdf = new  Titulacion_PDF_Acta('P','mm','Legal');
		$pdf->acta = $acta;
		$pdf->renderBase ();
		/*$pdf->fechaHora = $fechaHora;
		$pdf->id = $id;
		$pdf->planEstudios = $planEstudios;
		$pdf->folio = $folio;
		$pdf->numeroActa = $numeroActa;
		$pdf->opcTitulacion = $opcTitulacion;
		$pdf->opcTitulacion_descripcion = $opcTitulacion_descripcion;
		$pdf->alumno_nombre = $alumno_nombre;
		$pdf->alumno_apellidos = $alumno_apellidos;
		$pdf->alumno = $alumno; 
		
		$pdf->ingreso = $ingreso;
		$pdf->egreso = $egreso;
		$pdf->carrera = $carrera;*/
		
		$pdf->Close();
		
		$nombre_pdf = $acta->alumno;
		
		$nombre_pdf .= '.pdf';
		$pdf->Output('/tmp/'.$nombre_pdf,'F');
		
		return new Gatuf_HTTP_Response_File('/tmp/'.$nombre_pdf, $nombre_pdf, 'application/pdf',true);
		
		
		
	}
	
}
