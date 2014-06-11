<?php

class Titulacion_PDF_Protesta extends External_FPDF{
	function renderBase(){
		Gatuf::loadFunction ('Titulacion_Utils_numeroLetra');
		setLocale(LC_ALL, 'es_MX.UTF-8');
		
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
		
		$dia = strftime("%e", strtotime ($this->acta->fechahora)); /* Extraer el día */
		$mes = (strftime("%B", strtotime ($this->acta->fechahora))); /* El nombre del mes */
		$anio = strftime("%Y", strtotime ($this->acta->fechahora)); /* El año */
		$diaSemana = (strftime("%A", strtotime ($this->acta->fechahora)));
		$diaLetra = Titulacion_Utils_numeroLetra((int) $dia);
		
		$fecha= $diaSemana.' '.$dia.' de '.$mes.' de '.$anio;
		
		$leyenda1 = 'En la División de Electrónica y Computación del Centro Universitario de Ciencias Exactas e Ingenierías de la Universidad de Guadalajara, hoy día ';
		$leyenda2 = 'ante el honorable Comité de Titulación que ha tenido a bien emitir el veredicto aprobatorio a mi examen profesional para obtener el título de';
		$leyenda3 = 'ante el público que me ha honrado con su presencia en este acto solemne:';
		$leyenda = $leyenda1.' '.$fecha.', '.$leyenda2.' '.$grado.', '.$leyenda3;
		$punto1 ='I.- Desempeñar con honradez, lealtad y esmero los trabajos que me comprometa a ejecutar.';
		$punto2 ='II.- Conceder el debido respeto a las opiniones de mis compañeros de profesión y coadyuvar con integridad en los trabajos que con ellos desempeñe.';
		$punto3 ='III.- Ser justo y ecuánime con todos los que laboren conmigo.';
		$punto4 ='IV.- Respetar mi Universidad y tratar de acrecentar su prestigio por todos los medios a mi alcance.';
		$punto5 ='V.- Ofrecer cooperación, cordialidad y fraternidad a mis compañeros de profesión.';
		$punto6 ='VI.- Actualizar mis conocimientos y superarme profesionalmente para cooperar en la tarea de formar una patria mejor con justa retribución a la sociedad que proporcionó los medios para mi preparación.';
		
		switch ($this->carrera->grado) {
			case 'I':
				$grado = 'Ing.';
				break;
			case 'L':
				$grado = 'Lic.';
				break;
			case 'D':
				if ($this->alumno->sexo == 'F') $grado = 'Dra.';
				else $grado = 'Dr.';
				break;
			case 'M':
				if ($this->alumno->sexo == 'F') $grado = 'Mtra.';
				else $grado = 'Mtro.';
				break;
			default:
				throw new Exception ('No implementado');
		}
		
		$sustentante = mb_strtoupper($grado.' '.$this->alumno->nombre.' '.$this->alumno->apellido);
		
		$this->SetFont('Arial','B', 12);
		$this->Addpage('P','Letter');
		
		$this->SetY(18);
		$this->SetX(18.1);
		$this->Multicell(181,4,$leyenda,0,'J');
		
		$this->SetFont('Arial','',14);
		$this->SetY(45);
		$this->SetX(94);
		$this->Cell(30.5,0,'PROTESTO',0,0,'J');
		
		$this->Image (dirname(__FILE__).'/data/udg/UdgLogo.png', 3, 26, 210, 168);
		
		$this->SetFont('Arial','B', 12);
		
		$this->SetY(60);
		$this->SetX(19);
		$this->Multicell(181,4,$punto1,0,'J');
		
		$this->SetY(70);
		$this->SetX(19);
		$this->Multicell(181,4,$punto2,0,'J');
		
		$this->SetY(86);
		$this->SetX(19);
		$this->Multicell(181,4,$punto3,0,'J');
		
		$this->SetY(96);
		$this->SetX(19);
		$this->Multicell(181,4,$punto4,0,'J');
		
		$this->SetY(112);
		$this->SetX(19);
		$this->Multicell(181,4,$punto5,0,'J');
		
		$this->SetY(123);
		$this->SetX(19);
		$this->Multicell(181,4,$punto6,0,'J');
		
		/*aqui van los nombres de el Titulado y las de los mienmbros del jurado*/
		
		$this->SetFont('Arial','', 10);
		
		$this->SetY(166);
		$this->SetX(19);
		$this->Cell(78.2,3,$sustentante ,'B',0,'C');
		
		$this->SetY(170);
		$this->SetX(19);
		$this->Cell(78.2,3,'Firma del sustentante',0,0,'C');
		
		$this->SetY(166);
		$this->SetX(128.3);
		$this->Cell(78.2,3,$nombreCompletoj1,'B',0,'C');
		
		$this->SetY(170);
		$this->SetX(128.3);
		$this->Cell(78.2,3,'Comité de titulación',0,0,'C');
		
		$this->SetY(200);
		$this->SetX(19);
		$this->Cell(78.2,3,$nombreCompletoj2,'B',0,'C');
		
		$this->SetY(204);
		$this->SetX(19);
		$this->Cell(78.2,3,'Comité de titulación',0,0,'C');
		
		$this->SetY(200);
		$this->SetX(128.3);
		$this->Cell(78.2,3,$nombreCompletoj2,'B',0,'C');
		
		$this->SetY(204);
		$this->SetX(128.3);
		$this->Cell(78.2,3,'Comité de titulación',0,0,'C');
		
		$this->SetY(226);
		$this->SetX(19);
		$this->Cell(78.2,3,'El Director',0,0,'C');
		
		$this->SetY(226);
		$this->SetX(128.3);
		$this->Cell(78.2,3,'La Secretario',0,0,'C');
		
		$this->SetY(253);
		$this->SetX(128.3);
		$this->Cell(78.2,5,$secretario,'T',0,'C');
		
		$this->SetY(253);
		$this->SetX(19);
		$this->Cell(78.2,5,$director,'T',0,'C');
	}
}
