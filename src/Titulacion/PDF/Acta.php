<?php

class Titulacion_PFF_Acta extends External_FPDF{
	public $acta;
	
	function Header () {
		$this->SetY(5);
		$this->setX(87);
		$this->SetFont('Times','',20);
		$this->Cell(0, 0, 'UNIVERSIDAD DE GUADALAJARA');
	
	}

	
	
	function renderBase(){
		$this->AliasNbPages();
		$this->SetMargins(20, 5);
		
		$this->SetFont('Times', '', 12);
		$this->AddPage('P','Legal');
		
		$this->Image(dirname(__FILE__).'/data/logo.gif',30,12,24,34);
		$this->SetY(0);
		$this->Ln(44);
		$this->SetFont('Arial','B',12);
		$this->Cell (0,0 ,'CENTRO UNIVERSITARION DE CIENCIAS EXACTAS E INGENIERIAS',0,0,'C');
	
	}

}