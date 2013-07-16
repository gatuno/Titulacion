<?php

class Titulacion_PDF_Acta extends External_FPDF{
	public $acta;
	public $fechaHora;
	public $numeroActa;
	
	
	

	
	function renderBase(){
	
		
		
		
		$nombre = $this->acta->alumno_nombre;
		$apellidos = $this->acta->alumno_apellido;
		$nombreCompleto = $nombre  .' '.  $apellidos;
		
		$this->AliasNbPages();
		$this->SetMargins(20, 5);
		
		$this->SetFont('Times', '', 12);
		$this->AddPage('P','Legal');
		
		$this->SetY(85);
		$this->SetX(35);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->numeroActa,0,0);
		
		$this->SetY(91);
		$this->SetX(35);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->alumno,0,0);
		
		/*throw new exception($this->acta->fechaHora);*/
		$dia = date_format(date_create ($this->acta->fechaHora),'d');
		$mes = date_format(date_create ($this->acta->fechaHora),'F');
		$anio = date_format(date_create ($this->acta->fechaHora),'Y');
		
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
		
		
		//throw new Exception($this->acta->alumno_apellido);
		$this->SetY(110);
		$this->SetX(70);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$nombreCompleto,0,0);
		
		$this->SetY(77);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->jurado1,0,0);
		
		$this->SetY(84);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->jurado2,0,0);
		
		$this->SetY(90);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->jurado3,0,0);
		
		$this->SetY(95);
		$this->SetX(122);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'MIEMBROS DEL'0,0);
		
		$this->SetY(110);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->carrera,0,0);
		
		
		$this->SetY(119);
		$this->SetX(190);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'artudg',0,0);
		
		$this->SetY(124);
		$this->SetX(85);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'frcudg',0,0);
	
	
		$this->SetY(124);
		$this->SetX(146);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'artcuc',0,0);
		
		$this->SetY(124);
		$this->SetX(182);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'frcuc',0,0);
		
		$this->SetY(134);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'Modalidad',0,0);
		
		$this->SetY(146);
		$this->SetX(71);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,'opcion',0,0);
		
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
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->jurado1,0,0);
		
		$this->SetY(281);
		$this->SetX(60);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->jurado2,0,0);
		
		$this->SetY(281);
		$this->SetX(137);
		$this->SetFont('Arial','',12);
		$this->Cell(0,0,$this->acta->jurado3,0,0);
		
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