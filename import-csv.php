<?php
	define('PREPEND_PATH', '');
	include_once(__DIR__ . '/lib.php');

	// accept a record as an assoc array, return transformed row ready to insert to table
	$transformFunctions = [
		'Estado_Conservacion' => function($data, $options = []) {

			return $data;
		},
		'Estado_Prestable' => function($data, $options = []) {

			return $data;
		},
		'Registros' => function($data, $options = []) {
			if(isset($data['id_Estado_Conservacion'])) $data['id_Estado_Conservacion'] = pkGivenLookupText($data['id_Estado_Conservacion'], 'Registros', 'id_Estado_Conservacion');
			if(isset($data['id_Estado_Prestable'])) $data['id_Estado_Prestable'] = pkGivenLookupText($data['id_Estado_Prestable'], 'Registros', 'id_Estado_Prestable');
			if(isset($data['Fecha_Regsitro'])) $data['Fecha_Regsitro'] = guessMySQLDateTime($data['Fecha_Regsitro']);

			return $data;
		},
		'Estado_Prestamo' => function($data, $options = []) {

			return $data;
		},
		'Estado_Catalogacion' => function($data, $options = []) {

			return $data;
		},
		'Editoriales' => function($data, $options = []) {

			return $data;
		},
		'Catalogo' => function($data, $options = []) {
			if(isset($data['Codigo_Registro'])) $data['Codigo_Registro'] = pkGivenLookupText($data['Codigo_Registro'], 'Catalogo', 'Codigo_Registro');
			if(isset($data['Tipo_Documento'])) $data['Tipo_Documento'] = pkGivenLookupText($data['Tipo_Documento'], 'Catalogo', 'Tipo_Documento');
			if(isset($data['id_Estado_Catalogacion'])) $data['id_Estado_Catalogacion'] = pkGivenLookupText($data['id_Estado_Catalogacion'], 'Catalogo', 'id_Estado_Catalogacion');
			if(isset($data['Id_Autoridad'])) $data['Id_Autoridad'] = pkGivenLookupText($data['Id_Autoridad'], 'Catalogo', 'Id_Autoridad');
			if(isset($data['Id_Lugar'])) $data['Id_Lugar'] = pkGivenLookupText($data['Id_Lugar'], 'Catalogo', 'Id_Lugar');
			if(isset($data['id_Editorial'])) $data['id_Editorial'] = pkGivenLookupText($data['id_Editorial'], 'Catalogo', 'id_Editorial');
			if(isset($data['Materia_1'])) $data['Materia_1'] = pkGivenLookupText($data['Materia_1'], 'Catalogo', 'Materia_1');
			if(isset($data['Materia_2'])) $data['Materia_2'] = pkGivenLookupText($data['Materia_2'], 'Catalogo', 'Materia_2');
			if(isset($data['Materia_3'])) $data['Materia_3'] = pkGivenLookupText($data['Materia_3'], 'Catalogo', 'Materia_3');
			if(isset($data['Fecha_Catalogacion'])) $data['Fecha_Catalogacion'] = guessMySQLDateTime($data['Fecha_Catalogacion']);
			if(isset($data['Cod_Barras'])) $data['Cod_Barras'] = thisOr($data['Codigo_Registro'], pkGivenLookupText($data['Cod_Barras'], 'Catalogo', 'Cod_Barras'));

			return $data;
		},
		'Circulacion' => function($data, $options = []) {
			if(isset($data['id_Usuario'])) $data['id_Usuario'] = pkGivenLookupText($data['id_Usuario'], 'Circulacion', 'id_Usuario');
			if(isset($data['id_Tipo_usuario'])) $data['id_Tipo_usuario'] = pkGivenLookupText($data['id_Tipo_usuario'], 'Circulacion', 'id_Tipo_usuario');
			if(isset($data['id_Politica_pretamo'])) $data['id_Politica_pretamo'] = pkGivenLookupText($data['id_Politica_pretamo'], 'Circulacion', 'id_Politica_pretamo');
			if(isset($data['id_Tipo_documento'])) $data['id_Tipo_documento'] = pkGivenLookupText($data['id_Tipo_documento'], 'Circulacion', 'id_Tipo_documento');
			if(isset($data['Libro_Prestado'])) $data['Libro_Prestado'] = pkGivenLookupText($data['Libro_Prestado'], 'Circulacion', 'Libro_Prestado');
			if(isset($data['Fecha_Prestamo'])) $data['Fecha_Prestamo'] = guessMySQLDateTime($data['Fecha_Prestamo']);
			if(isset($data['Fecha_Devolucion'])) $data['Fecha_Devolucion'] = guessMySQLDateTime($data['Fecha_Devolucion']);
			if(isset($data['id_Estado_prestamo'])) $data['id_Estado_prestamo'] = pkGivenLookupText($data['id_Estado_prestamo'], 'Circulacion', 'id_Estado_prestamo');
			if(isset($data['Cod_Ejemplar'])) $data['Cod_Ejemplar'] = pkGivenLookupText($data['Cod_Ejemplar'], 'Circulacion', 'Cod_Ejemplar');
			if(isset($data['Foto_Usuario'])) $data['Foto_Usuario'] = thisOr($data['id_Usuario'], pkGivenLookupText($data['Foto_Usuario'], 'Circulacion', 'Foto_Usuario'));
			if(isset($data['id_Registro'])) $data['id_Registro'] = thisOr($data['Libro_Prestado'], pkGivenLookupText($data['id_Registro'], 'Circulacion', 'id_Registro'));
			if(isset($data['Portada_libro'])) $data['Portada_libro'] = thisOr($data['Libro_Prestado'], pkGivenLookupText($data['Portada_libro'], 'Circulacion', 'Portada_libro'));
			if(isset($data['Ejemp_Disponibles'])) $data['Ejemp_Disponibles'] = thisOr($data['Libro_Prestado'], pkGivenLookupText($data['Ejemp_Disponibles'], 'Circulacion', 'Ejemp_Disponibles'));
			if(isset($data['Item'])) $data['Item'] = thisOr($data['Libro_Prestado'], pkGivenLookupText($data['Item'], 'Circulacion', 'Item'));

			return $data;
		},
		'Tipo_Documento' => function($data, $options = []) {

			return $data;
		},
		'Autoridades' => function($data, $options = []) {
			if(isset($data['id_Tipo_autoridad'])) $data['id_Tipo_autoridad'] = pkGivenLookupText($data['id_Tipo_autoridad'], 'Autoridades', 'id_Tipo_autoridad');

			return $data;
		},
		'Estado_Suscripcion' => function($data, $options = []) {

			return $data;
		},
		'Usuarios' => function($data, $options = []) {
			if(isset($data['id_Tipo_usuario'])) $data['id_Tipo_usuario'] = pkGivenLookupText($data['id_Tipo_usuario'], 'Usuarios', 'id_Tipo_usuario');
			if(isset($data['id_Estado_suscripcion'])) $data['id_Estado_suscripcion'] = pkGivenLookupText($data['id_Estado_suscripcion'], 'Usuarios', 'id_Estado_suscripcion');
			if(isset($data['Fecha_Registro'])) $data['Fecha_Registro'] = guessMySQLDateTime($data['Fecha_Registro']);

			return $data;
		},
		'Politica_de_Prestamos' => function($data, $options = []) {
			if(isset($data['id_Tipo_usuario'])) $data['id_Tipo_usuario'] = pkGivenLookupText($data['id_Tipo_usuario'], 'Politica_de_Prestamos', 'id_Tipo_usuario');
			if(isset($data['id_Tipo_documento'])) $data['id_Tipo_documento'] = pkGivenLookupText($data['id_Tipo_documento'], 'Politica_de_Prestamos', 'id_Tipo_documento');

			return $data;
		},
		'Lugares' => function($data, $options = []) {

			return $data;
		},
		'Tipo_Autoridad' => function($data, $options = []) {

			return $data;
		},
		'Tipo_Usuario' => function($data, $options = []) {

			return $data;
		},
		'Materias' => function($data, $options = []) {

			return $data;
		},
		'Itemes' => function($data, $options = []) {
			if(isset($data['Cod_item'])) $data['Cod_item'] = pkGivenLookupText($data['Cod_item'], 'Itemes', 'Cod_item');
			if(isset($data['Estado_Conservacion'])) $data['Estado_Conservacion'] = pkGivenLookupText($data['Estado_Conservacion'], 'Itemes', 'Estado_Conservacion');

			return $data;
		},
	];

	// accept a record as an assoc array, return a boolean indicating whether to import or skip record
	$filterFunctions = [
		'Estado_Conservacion' => function($data, $options = []) { return true; },
		'Estado_Prestable' => function($data, $options = []) { return true; },
		'Registros' => function($data, $options = []) { return true; },
		'Estado_Prestamo' => function($data, $options = []) { return true; },
		'Estado_Catalogacion' => function($data, $options = []) { return true; },
		'Editoriales' => function($data, $options = []) { return true; },
		'Catalogo' => function($data, $options = []) { return true; },
		'Circulacion' => function($data, $options = []) { return true; },
		'Tipo_Documento' => function($data, $options = []) { return true; },
		'Autoridades' => function($data, $options = []) { return true; },
		'Estado_Suscripcion' => function($data, $options = []) { return true; },
		'Usuarios' => function($data, $options = []) { return true; },
		'Politica_de_Prestamos' => function($data, $options = []) { return true; },
		'Lugares' => function($data, $options = []) { return true; },
		'Tipo_Autoridad' => function($data, $options = []) { return true; },
		'Tipo_Usuario' => function($data, $options = []) { return true; },
		'Materias' => function($data, $options = []) { return true; },
		'Itemes' => function($data, $options = []) { return true; },
	];

	/*
	Hook file for overwriting/amending $transformFunctions and $filterFunctions:
	hooks/import-csv.php
	If found, it's included below

	The way this works is by either completely overwriting any of the above 2 arrays,
	or, more commonly, overwriting a single function, for example:
		$transformFunctions['tablename'] = function($data, $options = []) {
			// new definition here
			// then you must return transformed data
			return $data;
		};

	Another scenario is transforming a specific field and leaving other fields to the default
	transformation. One possible way of doing this is to store the original transformation function
	in GLOBALS array, calling it inside the custom transformation function, then modifying the
	specific field:
		$GLOBALS['originalTransformationFunction'] = $transformFunctions['tablename'];
		$transformFunctions['tablename'] = function($data, $options = []) {
			$data = call_user_func_array($GLOBALS['originalTransformationFunction'], [$data, $options]);
			$data['fieldname'] = 'transformed value';
			return $data;
		};
	*/

	@include(__DIR__ . '/hooks/import-csv.php');

	$ui = new CSVImportUI($transformFunctions, $filterFunctions);
