<?php

Gatuf::loadFunction('Gatuf_HTTP_URL_urlForView');
Gatuf::loadFunction('Gatuf_Shortcuts_RenderToResponse');

class Titulacion_Views {
	function index ($request, $match) {
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/index.html',
		                                         array ('title' => 'Titulación'),
		                                         $request);
	}
	
	function login ($request, $match, $success_url = '', $extra_context=array()) {
		if (!empty($request->REQUEST['_redirect_after'])) {
			$success_url = $request->REQUEST['_redirect_after'];
		} else {
			$success_url = Gatuf::config('titulacion_base').Gatuf::config ('login_success_url', '/');
		}
		
		$error = '';
		if ($request->method == 'POST') {
			foreach (Gatuf::config ('auth_backends', array ('Gatuf_Auth_ModelBackend')) as $backend) {
				$user = call_user_func (array ($backend, 'authenticate'), $request->POST);
				if ($user !== false) {
					break;
				}
			}
			
			if (false === $user) {
				$error = 'El usuario o contraseña no son válidos. El usuario y la contraseña son sensibles a las mayúsculas';
			} else {
				if (!$request->session->getTestCookie ()) {
					$error = 'Necesitas habilitar las cookies para acceder a este sitio';
				} else {
					$request->user = $user;
					$request->session->clear ();
					$request->session->setData('login_time', gmdate('Y-m-d H:i:s'));
					$user->last_login = gmdate('Y-m-d H:i:s');
					$user->updateSession ();
					$request->session->deleteTestCookie ();
					return new Gatuf_HTTP_Response_Redirect ($success_url);
				}
				
			}
		}
		/* Mostrar el formulario de login */
		$request->session->createTestCookie ();
		$context = new Gatuf_Template_Context_Request ($request, array ('page_title' => 'Ingresar',
		'_redirect_after' => $success_url,
		'error' => $error));
		$tmpl = new Gatuf_Template ('titulacion/login_form.html');
		return new Gatuf_HTTP_Response ($tmpl->render ($context));
	}
	
	function logout ($request, $match) {
		$success_url = Gatuf::config ('after_logout_page', '/');
		$user_model = Gatuf::config('gatuf_custom_user','Gatuf_User');
		
		$request->user = new $user_model ();
		$request->session->clear ();
		$request->session->setData ('logout_time', gmdate('Y-m-d H:i:s'));
		if (0 !== strpos ($success_url, 'http')) {
			$murl = new Gatuf_HTTP_URL ();
			$success_url = Gatuf::config('titulacion_base').$murl->generate($success_url);
		}
		
		return new Gatuf_HTTP_Response_Redirect ($success_url);
	}
	
	function passwordRecoveryAsk ($request, $match) {
		$title = 'Recuperar contraseña';
		
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_Password ($request->POST);
			if ($form->isValid ()) {
				$url = $form->save ();
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_Password ();
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/user/recuperarcontra-ask.html',
		                                         array ('page_title' => $title,
		                                         'form' => $form),
		                                         $request);
	}
	
	function passwordRecoveryInputCode ($request, $match) {
		$title = 'Recuperar contraseña';
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_PasswordInputKey($request->POST);
			if ($form->isValid ()) {
				$url = $form->save ();
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
		 	$form = new Titulacion_Form_PasswordInputKey ();
		}
		
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/user/recuperarcontra-codigo.html',
		                                         array ('page_title' => $title,
		                                         'form' => $form),
		                                         $request);
	}
	
	function passwordRecovery ($request, $match) {
		$title = 'Recuperar contraseña';
		$key = $match[1];
		
		$email_id = Titulacion_Form_PasswordInputKey::checkKeyHash($key);
		if (false == $email_id) {
			$url = Gatuf_HTTP_URL_urlForView ('Gatuf_Views::passwordRecoveryInputKey');
			return new Gatuf_HTTP_Response_Redirect ($url);
		}
		$user = Gatuf::factory('Titulacion_User')->getUser ($email_id[1]);
		$extra = array ('key' => $key,
		                'user' => $user);
		if ($request->method == 'POST') {
			$form = new Titulacion_Form_PasswordReset($request->POST, $extra);
			if ($form->isValid()) {
				$user = $form->save();
				$request->user = $user;
				$request->session->clear();
				$request->session->setData('login_time', gmdate('Y-m-d H:i:s'));
				$user->last_login = gmdate('Y-m-d H:i:s');
				$user->updateSession ();
				/* FIXME: Establecer un mensaje
				$request->user->setMessage(); */
				$url = Gatuf_HTTP_URL_urlForView ('Titulacion_Views_Carrera::index'); /* FIXME: URL principal */
				return new Gatuf_HTTP_Response_Redirect ($url);
			}
		} else {
			$form = new Titulacion_Form_PasswordReset (null, $extra);
		}
		return Gatuf_Shortcuts_RenderToResponse ('titulacion/user/recuperarcontra.html',
		                                         array ('page_title' => $title,
		                                         'new_user' => $user,
		                                         'form' => $form),
		                                         $request);
	}
}
