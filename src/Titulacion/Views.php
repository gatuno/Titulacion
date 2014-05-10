<?php

Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');
Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');

class Titulacion_Views {
	function index ($request, $match) {
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/index.html',
		                                         array ('page_title' => 'Titulación'),
		                                         $request);
	}
		
	public $preferences_precond = array ('Gatuf_Precondition::loginRequired');
	function preferences ($request, $match) {
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Preferences ($request->POST, array ());
			
			if ($form->isValid ()) {
				$request->user->setMessage (1, 'Las preferencias han sido guardadas');
				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views::index');
				
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Preferences (null, array ());
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/preferences.html',
		                                         array ('page_title' => 'Preferencias del Sistema',
		                                         'form' => $form),
		                                         $request);
	}
}
