<?php

class Titulacion_PDF_Acta extends External_FPDF{
	public $acta;
	
	function Header () {
		$this->SetY(6);
		$this->setX(87);
		$this->SetFont('Times','B',20);
		$this->Cell(0, 0, 'UNIVERSIDAD DE GUADALAJARA');
	
	}

	
	
	function renderBase(){
		$this->AliasNbPages();
		$this->SetMargins(20, 5);
		
		$this->SetFont('Times', '', 12);
		$this->AddPage('P','Legal');
		
		$this->Image(dirname (__FILE__).'/data/logo.gif',11,10,25,0);
		
		
		$this->SetY(0);
		$this->Ln(30);
		$this->SetFont('Arial','B',12);
		$this->Cell (0,0 ,'CENTRO UNIVERSITARION DE CIENCIAS EXACTAS E INGENIERIAS',0,0,'C');
		
		$this->SetY (0);
		$this->Ln (98);
		$this->SetFont ('Times', 'BU', 18);
		$this->Cell (0, 0, 'Horario de clases', 0, 0, 'C');
		
		
	
	}

}