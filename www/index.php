<?php

require dirname(__FILE__).'/../src/Titulacion/conf/path.php';

# Cargar Gatuf
require 'Gatuf.php';

# Inicializar las configuraciones
Gatuf::start(dirname(__FILE__).'/../src/Titulacion/conf/titulacion.php');

Gatuf_Despachador::loadControllers(Gatuf::config('titulacion_views'));

Gatuf_Despachador::despachar(Gatuf_HTTP_URL::getAction());
