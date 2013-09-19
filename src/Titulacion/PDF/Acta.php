<?php

class Titulacion_PDF_Acta extends External_FPDF{
	public $acta, $carrera;
	public $jurado1, $jurado2, $jurado3;
	public $opcion, $modalidad;
	public $director, $secretario;
	
	function renderBase(){
		Gatuf::loadFunction ('Titulacion_Utils_grado');
		
		
		$nombreCompleto = $this->acta->alumno_nombre.' '.$this->acta->alumno_apellido;
		
		$grado = Titulacion_Utils_grado ($this->jurado1->sexo, $this->jurado1->grado);
		$nombreCompletoj1 = $grado.' '.$this->jurado1->apellido.' '.$this->jurado1->nombre;
		
		$grado = Titulacion_Utils_grado ($this->jurado2->sexo, $this->jurado2->grado);
		$nombreCompletoj2 = $grado.' '.$this->jurado2->apellido.' '.$this->jurado2->nombre;
		
		$grado = Titulacion_Utils_grado ($this->jurado3->sexo, $this->jurado3->grado);
		$nombreCompletoj3 = $grado.' '.$this->jurado3->apellido.' '.$this->jurado3->nombre;
		
		$grado = Titulacion_Utils_grado ($this->secretario->sexo, $this->secretario->grado);
		$secretario = $grado.' '.$this->secretario->apellido.' '.$this->secretario->nombre;
		
		$grado = Titulacion_Utils_grado ($this->director->sexo, $this->director->grado);
		$director = $grado.' '.$this->director->apellido.' '.$this->director->nombre;
		
		$evalua = $this->opcion->articulo;
		
		$leyenda = $this->opcion->leyenda;
		
		if ($this->opcion->desempeno) {
			$leyenda = sprintf ($this->opcion->leyenda,$this->acta->desempeno,$this->acta->carrera_descripcion);
		}
		
		if ($this->opcion->trabajo) {
		$leyenda = sprintf ($this->opcion->leyenda,$this->acta->nombre_trabajo);
			
		}
		
		if ($this->opcion->maestria) {
			$leyenda = sprintf ($this->opcion->leyenda,$this->acta->materias_maestria,$this->acta->nombre_maestria,$this->acta->escuela_maestria);
		}
		
		
		$this->AliasNbPages();
		$this->SetMargins(20, 5);
		
		$this->SetFont('Times', '', 12);
		$this->AddPage('P','Legal');
		
		$this->SetY(85);
		$this->SetX(35);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->folio.'/'.$this->acta->anio,0,0);
		
		$this->SetY(91);
		$this->SetX(35);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->alumno,0,0);
		
		setLocale(LC_ALL, 'es_MX.UTF-8');
		$dia = strftime("%e", strtotime ($this->acta->fechaHora)); /* Extraer el día */
		$mes = strftime("%B", strtotime ($this->acta->fechaHora)); /* El nombre del mes */
		$anio = strftime("%Y", strtotime ($this->acta->fechaHora)); /* El año */
		$v = (int)$dia;
		$diaLetra = Titulacion_Utils_numeroLetra($v);
		
		$diaCompleto = $dia.' '.'('.' '.$diaLetra.' '.')';
		
		$this->SetY(54);
		$this->SetX(150);
		$this->SetFont('Arial','',12);
		$this->Cell (0,0 ,$diaCompleto,0,0,'C');
		
		$this->SetY(60);
		$this->SetX(90);
		$this->SetFont('Arial','',12);
		$this->Cell (0,0 ,$mes,0,0,'C');
		
		$this->SetY (60);
		$this->SetX (135);
		$this->SetFont ('Times', '', 12);
		$this->Cell(0, 0, $anio, 0, 0, 'C');
		
		$this->SetY(101);
		$this->SetX(70);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,4,$this->acta->carrera,0,0);
		
		$this->SetY(110);
		$this->SetX(70);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$nombreCompleto,0,0);
		
		$this->SetY(77);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$nombreCompletoj1,0,0);
		
		
		$this->SetY(84);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$nombreCompletoj2,0,0);
		
		$this->SetY(90);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$nombreCompletoj3,0,0);
		
		$this->SetY(95);
		$this->SetX(122);
		$this->SetFont('Arial','',12);
		if ($this->opcion->tipo == 'C') {
			$this->Cell(0, 0, 'MIEMBROS DEL COMITÉ', 0,0);
		} else if ($this->opcion->tipo == 'J') {
			$this->Cell(0, 0, 'MIEMBROS DEL JURADO', 0, 0);
		}

		$this->SetY(100);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->carrera->nombre_largo,0,0);
		
		$this->SetY(119);
		$this->SetX(190);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->opcion->articulo,0,0);
		
		$this->SetY(124);
		$this->SetX(85);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->opcion->fraccion,0,0);
		
		$this->SetY(124);
		$this->SetX(146);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->opcion->articulo_cucei,0,0);
		
		$this->SetY(124);
		$this->SetX(182);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->opcion->fraccion_cucei,0,0);
		
		$this->SetY(134);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->modalidad->descripcion,0,0);
		
		$this->SetY(146);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->opcion->descripcion,0,0);
		
		
	
		$this->SetY(169);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->MultiCell(0,5,$leyenda,0,'L');
			
		
		
		


		if (($this->acta->calificacion)) {
			$this->SetY(203);
			$this->SetX(185);
			$this->SetFont('Arial','',12);
			$this->Cell(0,0,$this->acta->calificacion,0,0);
			
			$calificacionLetra = Titulacion_Utils_numeroLetra($this->acta->calificacion);
			$this->SetY(207);
			$this->SetX(71);
			$this->SetFont('Arial','',12);
			$this->Cell(0,0,'('.$calificacionLetra.')',0,0);
		}
		
		$this->SetY(218);
		$this->SetX(159);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'"     SI PROTESTO     ".',0,0);
		
		$this->SetY(250);
		$this->SetX(139);
		$this->Cell(0,0,$nombreCompletoj1,0,0);
		$this->SetFont('Arial','',12);
		
		$this->SetY(281);
		$this->SetX(60);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$nombreCompletoj2,0,0);
		
		$this->SetY(281);
		$this->SetX(137);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$nombreCompletoj3,0,0);
		
		$this->SetY(311);
		$this->SetX(58);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$director,0,0);
		
		$this->SetY(311);
		$this->SetX(129);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$secretario,0,0,'C');
		
		$this->SetY(315);
		$this->SetX(77);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'DIRECTOR',0,0);
		
		$this->SetY(319);
		$this->SetX(47);
		$this->SetFont('Arial','',12);
		$this->Cell(76,0,'DIVISION DE ELECTRONICA Y COMPUTACION',0,0,'C');
		
		$this->SetY(315);
		$this->SetX(150);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'SECRETARIO',0,0);
		
		$this->SetY(319);
		$this->SetX(128);
		$this->SetFont('Arial','',12);
		$this->Cell(76,0,'DIVISION DE ELECTRONICA Y COMPUTACION',0,0);
	}
}
