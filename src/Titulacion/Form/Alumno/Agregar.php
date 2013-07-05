<?phph

class Titulacion_Form_Alumno_Agregar estends Gatuf_Form{
	public function initFields($extra=array()){
	
		$this->fields['nombre']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Nombre',
				'initial' =>'',
				'max_length' => 30,
				'min_length' => 3,
				'widget_attrs' => array(
					'maxlength'=> 30,
					'size' =>30,
				),
			)	
	
		);
		$this->fields['apellido']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Apellidos',
				'initial' => '',
				'max_length' => 70,
				'min_length' => 40,	
				'widget_attrs' => array(
					'maxlenght'=>70,
					'size'=>30,
				),

			)
		);
		$this->fields['codigo']= new Gatuf_Form_Field_Varchar(
			array(
				'required' => true,
				'label' => 'Codigo',
				'initial' => '',
				'max_lenght' => 9,
				'min_length' => 9,
				'widget_attrs' => array(
					'maxlenght' =>9,
				),
			)
		);
				

	}

	
	public function save ($commit=true){
		if(!$this->isValid()){
			throw new Exception ('El formulario no tiene datos validos');
		}
	$alumno->nombre= $this->cleaned_data['nombre'];
	$alumno->apellido= $this->cleaned_data['apellido'];
	$alumno->codigo= $this->cleaned_data['codigo'];
	
	$alumno->create();

	return $alumno;	
	}
		
}