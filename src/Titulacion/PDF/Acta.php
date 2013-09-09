<?php

class Titulacion_PDF_Acta extends External_FPDF{
	public $acta;
	public $fechaHora;
	public $numeroActa;
	
/*$descG->
		
		$grado*/
	
	
	
	function renderBase(){
		Gatuf::loadFunction ('Titulacion_Utils_grado');
		$nombre = $this->acta->alumno_nombre;
		$apellidos = $this->acta->alumno_apellido;
		$nombreCompleto = $nombre  .' '.  $apellidos;
	
		$jurado1 = $this->jurado1->nombre;
		$grado1 = Titulacion_Utils_grado ($this->jurado1->sexo, $this->jurado1->grado);
		$apej1 = $this->jurado1->apellido;
		$complete1= $jurado1 .' '.$apej1;
		$nombreCompletoj1 = $grado1 .' '.$complete1;
		
		$jurado2 = $this->jurado2->nombre;
		$grado2 = Titulacion_Utils_grado ($this->jurado2->sexo, $this->jurado2->grado);
		$apej2 = $this->jurado2->apellido;
		$complete2= $jurado2 .' '.$apej2;
		$nombreCompletoj2 =$grado2 .' '.$jurado2 .' '.$apej2;
		
		$jurado3 = $this->jurado3->nombre;
		$grado3 = Titulacion_Utils_grado ($this->jurado3->sexo, $this->jurado3->grado);
		$apej3 = $this->jurado3->apellido;
		$complete3= $jurado3 .' '.$apej3;
		$nombreCompletoj3 =$grado3 .' '.$jurado3 .' '.$apej3;
			
		$this->AliasNbPages();
		$this->SetMargins(20, 5);
		
		$this->SetFont('Times', '', 12);
		$this->AddPage('P','Legal');
		
		$this->SetY(85);
		$this->SetX(35);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->folio,0,0);
		
		$this->SetY(91);
		$this->SetX(35);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->alumno,0,0);
		
		/*throw new exception($this->acta->fechaHora);*/
		setLocale(LC_ALL, 'es_MX.UTF-8');
		$dia = strftime("%d",strtotime ($this->acta->fechaHora));
		$mes = strftime("%B",strtotime ($this->acta->fechaHora));
		$anio = strftime("%Y",strtotime ($this->acta->fechaHora));
		
		$this->SetY(54);
		$this->SetX(150);
		$this->SetFont('Arial','',12);
		$this->Cell (0,0 ,$dia,0,0,'C');
		
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
		$this->Cell(0, 0, 'MIEMBROS DEL', 0,0);

		
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
		$this->Cell(0,0,'por haber aprobado............',0,0);
		
		$this->SetY(203);
		$this->SetX(185);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'calificacion',0,0);
		
		$this->SetY(207);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'califiacion letra',0,0);
		
		
		
		
		$this->SetY(218);
		$this->SetX(159);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'"      SI PROTESTO      ".',0,0);
		
		
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
		
		$this->SetY(315);
		$this->SetX(77);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'DIRECTOR',0,0);
		
		$this->SetY(319);
		$this->SetX(47);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'DIVISION DE ELECTRONICA Y COMPUTACION',0,0);
		
		$this->SetY(315);
		$this->SetX(156);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'SECRETARIO',0,0);
		
		$this->SetY(319);
		$this->SetX(128);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'DIVISION DE ELECTRONICA Y COMPUTACION',0,0);
		
		
		
		
	}

}