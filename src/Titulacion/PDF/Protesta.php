<?php

class Titulacion_PDF_Protesta extends External_FPDF{

	
	function renderBase(){
		Gatuf::loadFunction ('Titulacion_Utils_grado');
		Gatuf::loadFunction ('Titulacion_Utils_numeroLetra');
		setLocale(LC_ALL, 'es_MX.UTF-8');
		
		$nombreCompleto = mb_strtoupper($this->acta->alumno_nombre.' '.$this->acta->alumno_apellido);
		
		$grado = Titulacion_Utils_grado ($this->jurado1->sexo, $this->jurado1->grado);
		$nombreCompletoj1 = mb_strtoupper ($grado.' '.$this->jurado1->apellido.' '.$this->jurado1->nombre);
		
		$grado = Titulacion_Utils_grado ($this->jurado2->sexo, $this->jurado2->grado);
		$nombreCompletoj2 = mb_strtoupper ($grado.' '.$this->jurado2->apellido.' '.$this->jurado2->nombre);
		
		$grado = Titulacion_Utils_grado ($this->jurado3->sexo, $this->jurado3->grado);
		$nombreCompletoj3 = mb_strtoupper ($grado.' '.$this->jurado3->apellido.' '.$this->jurado3->nombre);
		
		$grado = Titulacion_Utils_grado ($this->secretario->sexo, $this->secretario->grado);
		$secretario = mb_strtoupper ($grado.' '.$this->secretario->apellido.' '.$this->secretario->nombre);
		
		$grado = Titulacion_Utils_grado ($this->director->sexo, $this->director->grado);
		$director = mb_strtoupper ($grado.' '.$this->director->apellido.' '.$this->director->nombre);
		
		$this->SetFont('Arial','', 12);
		$this->Addpage('P','Letter');
		
		$this->SetY(18);
		$this->SetX(18.1);
		$this->multicell(181,4,'En la división de Electrónica y Computación del Centro Universitario de Ciencias Exactas e Ingenierías de la Universidad de Guadalajara, hoy día','L');
		
		$this->SetFont('Arial','B',14);
		$this->SetY(45);
		$this->SetX(94);
		$this->Cell(30.5,0,'PROTESTO',0,0,'J');
		
		$this->SetY(19);
		$this->SetX();
	
	}

}