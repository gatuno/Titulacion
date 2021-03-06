<?php

class Titulacion_PDF_Acta extends External_FPDF{
	public $acta, $carrera;
	public $jurado1, $jurado2, $jurado3;
	public $opcion, $modalidad;
	public $director, $secretario, $alumno;
	
	function renderBase(){
		Gatuf::loadFunction ('Titulacion_Utils_numeroLetra');
		setLocale(LC_ALL, 'es_MX.UTF-8');
		
		$nombreCompleto = mb_strtoupper($this->alumno->nombre.' '.$this->alumno->apellido);
		
		$grado = $this->jurado1->displaygrado ();
		$nombreCompletoj1 = mb_strtoupper ($grado.' '.$this->jurado1->nombre.' '.$this->jurado1->apellido);
		
		$grado = $this->jurado2->displaygrado ();
		$nombreCompletoj2 = mb_strtoupper ($grado.' '.$this->jurado2->nombre.' '.$this->jurado2->apellido);
		
		$grado = $this->jurado3->displaygrado ();
		$nombreCompletoj3 = mb_strtoupper ($grado.' '.$this->jurado3->nombre.' '.$this->jurado3->apellido);
		
		$grado = $this->secretario->displaygrado ();
		$secretario = mb_strtoupper ($grado.' '.$this->secretario->nombre.' '.$this->secretario->apellido);
		
		$grado = $this->director->displaygrado ();
		$director = mb_strtoupper ($grado.' '.$this->director->nombre.' '.$this->director->apellido);
		
		$leyenda = $this->opcion->leyenda;
		
		/* Aplicar los reemplazos correspondientes a la leyenda */
		$cad_bus = array ('/%%/', '/%c/', '/%C/', '/%d/', '/%L/', '/%t/', '/%m/', '/%M/', '/%U/');
		$reemplazos = array ('%', $this->acta->calificacion, Titulacion_Utils_numeroLetra ($this->acta->calificacion), $this->acta->desempeno, $this->carrera->descripcion, $this->acta->nombre_trabajo, $this->acta->materias_maestria, $this->acta->nombre_maestria, $this->acta->escuela_maestria);
		
		$leyenda = mb_strtoupper (preg_replace ($cad_bus, $reemplazos, $leyenda));
		
		$this->SetMargins(0,0);
		
		$this->SetFont('Arial','',10);
		$this->AddPage('P','Legal');
		
		$this->SetY(85.5);
		$this->SetX(35);
		$this->Cell(0,0,$this->acta->folio.'/'.date ("Y", strtotime ($this->acta->create_time)),0,0);
		
		$this->SetY(93);
		$this->SetX(35);
		$this->Cell(0,0,$this->acta->alumno,0,0);
		
		$dia = strftime("%e", strtotime ($this->acta->fechahora)); /* Extraer el día */
		$mes = mb_strtoupper (strftime("%B", strtotime ($this->acta->fechahora))); /* El nombre del mes */
		$anio = strftime("%Y", strtotime ($this->acta->fechahora)); /* El año */
		$diaLetra = Titulacion_Utils_numeroLetra((int) $dia);
		
		$diaCompleto = $dia.' '.'('.' '.$diaLetra.' '.')';
		
		$this->SetY(54);
		$this->SetX(150);
		$this->Cell (0,0 ,$diaCompleto,0,0,'C');
		
		$this->SetY(59.9);
		$this->SetX(90);
		$this->Cell (38,0 ,$mes,0,0,'C');

		$this->SetY (59.9);
		$this->SetX (135);
		$this->Cell(24, 0, $anio, 0, 0, 'C');

		$this->SetY(77);
		$this->SetX(74);
		$this->Cell(0,0,$nombreCompletoj1,0,0);
		
		$this->SetY(84);
		$this->SetX(74);
		$this->Cell(0,0,$nombreCompletoj2,0,0);
		
		$this->SetY(91);
		$this->SetX(74);
		$this->Cell(0,0,$nombreCompletoj3,0,0);
		
		$this->SetY(110.5);
		$this->SetX(70);
		$this->Cell(103,0,$nombreCompleto,0,0,'C');
		
		$this->SetY(96);
		$this->SetX(71);
		
		if ($this->opcion->tipo == 'C') {
			$this->Cell(89, 0, 'MIEMBROS DEL COMITÉ', 0,0,'C');
		} else if ($this->opcion->tipo == 'J') {
			$this->Cell(89, 0, 'MIEMBROS DEL JURADO', 0, 0,'C');
		}

		$this->SetY(101);
		$this->SetX(94);
		$this->Cell(0,0, mb_strtoupper($this->carrera->nombre_largo),0,0);
		
		$this->SetY(115);
		$this->SetX(94);
		if(($this->alumno->sexo) == 'F'){
			$this->Cell(95,0,mb_strtoupper($this->carrera->grado_f),0,0,'C');
		} else {
			$this->Cell(95,0,mb_strtoupper($this->carrera->grado_m),0,0,'C');
		}
		
		$this->SetY(120);
		$this->SetX(190);
		$this->Cell(15,0,$this->opcion->articulo,0,0,'C');
		
		$this->SetY(124);
		$this->SetX(85);
		$this->Cell(19,0,$this->opcion->fraccion,0,0,'C');
		
		$this->SetY(124);
		$this->SetX(146);
		$this->Cell(18,0,$this->opcion->articulo_cucei,0,0,'C');
		
		$this->SetY(124);
		$this->SetX(182);
		$this->Cell(15,0,$this->opcion->fraccion_cucei,0,0,'C');
		
		$this->SetY(135);
		$this->SetX(72);
		$this->Cell(0,0, mb_strtoupper($this->modalidad->descripcion),0,0);
		
		$this->SetY(147.5);
		$this->SetX(72);
		$this->Cell(0,0, mb_strtoupper($this->opcion->descripcion),0,0);
		
		$this->SetY(151.9);
		$this->SetX(71);
		$this->MultiCell(134,7.3,$leyenda,0,'L');
		
		if (($this->acta->calificacion)) {
			$this->SetY(203.5);
			$this->SetX(185);
			
			$explote = explode (".", $this->acta->calificacion);
			$parte_entera = (int) $explote[0];
			$parte_flotante = (int) $explote[1];
			if ((int) $parte_flotante == 0) {
				$calif = $parte_entera;
			} else {
				$calif = $this->acta->calificacion;
			}
			
			$this->Cell(19,0,$calif,0,0,'C');
			
			$calificacionLetra = Titulacion_Utils_numeroLetra($this->acta->calificacion);
			$this->SetY(209);
			$this->SetX(71);
			$this->Cell(0,0,'('.$calificacionLetra.')',0,0);
		}
		
		$this->SetFont('Arial','',11);
		$this->SetY(213.5);
		$this->SetX(100);
		$this->Cell(0,0,'COMITE DE TITULACIÓN',0,0);
		
		$this->SetY(219);
		$this->SetX(159);
		$this->Cell(44,0,'SI PROTESTO',0,0,'C');
		
		$this->SetY(254);
		$this->SetX(128);
		$this->Cell(76,0,$nombreCompletoj1,0,0, 'C');
		
		$this->SetY(285);
		$this->SetX(47);
		$this->Cell(76,0,$nombreCompletoj2,0,0,'C');
		
		$this->SetY(285);
		$this->SetX(128);
		$this->Cell(76,0,$nombreCompletoj3,0,0,'C');
		
		$this->SetY(315);
		$this->SetX(47);
		$this->Cell(76,0,$director,0,0,'C');
		
		$this->SetY(319);
		$this->SetX(47);
		$this->Cell(76,0,'DIRECTOR',0,0,'C');
		
		$this->SetY(323);
		$this->SetX(47);
		$this->Cell(76,0,'DIVISION DE ELECTRONICA Y COMPUTACION',0,0,'C');
		
		$this->SetY(315);
		$this->SetX(128);
		$this->Cell(76,0,$secretario,0,0,'C');
		
		$this->SetY(319);
		$this->SetX(128);
		$this->Cell(76,0,'SECRETARIO',0,0,'C');
		
		$this->SetY(323);
		$this->SetX(128);
		$this->Cell(76,0,'DIVISION DE ELECTRONICA Y COMPUTACION',0,0,'C');
	}
}
