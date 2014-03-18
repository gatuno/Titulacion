<?php

class Titulacion_PDF_Citatorio extends External_FPDF {
	public $acta, $alumno, $carrera;
	public $secretario;
	public $jurado1, $jurado2, $jurado3;
	
	function renderBase () {
		Gatuf::loadFunction ('Titulacion_Utils_grado');
		setLocale(LC_ALL, 'es_MX.UTF-8');
		
		$grado = Titulacion_Utils_grado ($this->jurado1->sexo, $this->jurado1->grado);
		$nombreCompletoj1 = mb_convert_case ($grado.' '.$this->jurado1->nombre.' '.$this->jurado1->apellido, MB_CASE_TITLE);
		
		$grado = Titulacion_Utils_grado ($this->jurado2->sexo, $this->jurado2->grado);
		$nombreCompletoj2 = mb_convert_case ($grado.' '.$this->jurado2->nombre.' '.$this->jurado2->apellido, MB_CASE_TITLE);
		
		$grado = Titulacion_Utils_grado ($this->jurado3->sexo, $this->jurado3->grado);
		$nombreCompletoj3 = mb_convert_case ($grado.' '.$this->jurado3->nombre.' '.$this->jurado3->apellido, MB_CASE_TITLE);
		
		$this->AddFont ('Georgia');
		$this->AddFont ('Georgia', 'b');
		
		$this->SetFont ('Georgia', 'b', 10);
		$this->AddPage ('P', 'Letter');
		$this->SetMargins (0, 0, 0);
		
		$this->Image (dirname(__FILE__).'/data/udg/membrete_cabecera.jpg', 0, 0, 216, 0);
		
		$this->SetY (50);
		$this->SetX (41);
		
		$this->CellSmallCaps (156, 0, 'Citatorio', 0, 0, 'C');
		
		$this->SetFont ('Georgia', '', 8);
		
		$this->SetY (60); $this->SetX (140);
		$this->Cell (55, 0, 'Firma de enterado', 0, 0, 'C');
		
		$this->SetFont ('Georgia', '', 10);
		
		/* Jurado 1 */
		$this->SetY (72); $this->SetX (41);
		
		$this->CellSmallCaps (20, 0, $nombreCompletoj1, 0, 0, 'L');
		
		$this->SetX (140);
		$this->Cell (55, 0, '', 'B', 0);
		
		/* Jurado 2 */
		$this->SetY (80); $this->SetX (41);
		
		$this->CellSmallCaps (90, 0, $nombreCompletoj2, 0, 0, 'L');
		
		$this->SetX (140);
		$this->Cell (55, 0, '', 'B', 0);
		
		/* Jurado 3 */
		$this->SetY (88); $this->SetX (41);
		
		$this->CellSmallCaps (90, 0, $nombreCompletoj3, 0, 0, 'L');
		
		$this->SetX (140);
		$this->Cell (55, 0, '', 'B', 0);
		
		$this->SetY (98); $this->SetX (41);
		$this->CellSmallCaps (90, 0, 'Presente', 0, 0, 'L');
		
		$this->SetY (112); $this->SetX (41);
		
		$this->Cell (0, 0, 'Por este medio se le cita a la ceremonia de titulación de:', 0, 0, 'L');
		
		$this->SetFont ('Georgia', 'b', 12);
		/* El nombre del alumno */
		$this->SetY (119); $this->SetX (41);
		$cad = mb_convert_case ($this->alumno->nombre.' '.$this->alumno->apellido, MB_CASE_TITLE);
		$this->Cell (156, 0, $cad, 0, 0, 'C');
		
		$this->SetFont ('Georgia', '', 10);
		$this->SetY (128); $this->SetX (41);
		if ($this->alumno->sexo == 'F') {
			$cad = 'para obtener el título de: '.mb_strtoupper ($this->carrera->grado_f).'.';
		} else {
			$cad = 'para obtener el título de: '.mb_strtoupper ($this->carrera->grado_m).'.';
		}
		
		$this->Cell (156, 0, $cad, 0, 0, 'L');
		
		$this->SetY (136); $this->SetX (41);
		$cad = 'La ceremonia tendrá lugar el '.strftime ('%A %e de %B de %Y, a las %H:%M horas', strtotime ($this->acta->fechahora.' GMT')).', en la Sala de Recepción de la División.';
		$this->MultiCell (156, 6, $cad, 0, 'L');
		
		$this->SetY (154); $this->SetX (41);
		$this->Cell (0, 0, 'Agradeceremos su puntual asistencia.', 0, 0, 'L');
		
		$this->SetY (172); $this->SetX (41);
		$this->Cell (156, 0, 'Atentamente', 0, 0, 'C');
		
		$this->SetY (176); $this->SetX (41);
		$this->CellSmallCaps (156, 0, '"Piensa y trabaja"', 0, 0, 'C');
		
		$cad = 'Guadalajara, Jalisco a '.strftime ('%e de %B de %Y');
		
		$this->SetY (180); $this->SetX (41);
		$this->Cell (156, 0, $cad, 0, 0, 'C');
		
		$this->SetY (206); $this->SetX (41);
		$grado = Titulacion_Utils_grado ($this->secretario->sexo, $this->secretario->grado);
		$cad = mb_convert_case ($grado.' '.$this->secretario->nombre.' '.$this->secretario->apellido, MB_CASE_TITLE);
		$this->Cell (156, 0, $cad, 0, 0, 'C');
		
		$this->SetY (210); $this->SetX (41);
		$this->Cell (156, 0, 'Secretario', 0, 0, 'C');
		
		$this->Image (dirname(__FILE__).'/data/udg/membrete_pie.jpg', 0, 264, 216, 0);
	}
}
