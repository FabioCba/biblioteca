<?php

	#########################################################
	/*
	~~~~~~ LIST OF FUNCTIONS ~~~~~~
		get_table_groups() -- returns an associative array (table_group => tables_array)
		getTablePermissions($tn) -- returns an array of permissions allowed for logged member to given table (allowAccess, allowInsert, allowView, allowEdit, allowDelete) -- allowAccess is set to true if any access level is allowed
		get_sql_fields($tn) -- returns the SELECT part of the table view query
		get_sql_from($tn[, true, [, false]]) -- returns the FROM part of the table view query, with full joins (unless third paramaeter is set to true), optionally skipping permissions if true passed as 2nd param.
		get_joined_record($table, $id[, true]) -- returns assoc array of record values for given PK value of given table, with full joins, optionally skipping permissions if true passed as 3rd param.
		get_defaults($table) -- returns assoc array of table fields as array keys and default values (or empty), excluding automatic values as array values
		htmlUserBar() -- returns html code for displaying user login status to be used on top of pages.
		showNotifications($msg, $class) -- returns html code for displaying a notification. If no parameters provided, processes the GET request for possible notifications.
		parseMySQLDate(a, b) -- returns a if valid mysql date, or b if valid mysql date, or today if b is true, or empty if b is false.
		parseCode(code) -- calculates and returns special values to be inserted in automatic fields.
		addFilter(i, filterAnd, filterField, filterOperator, filterValue) -- enforce a filter over data
		clearFilters() -- clear all filters
		loadView($view, $data) -- passes $data to templates/{$view}.php and returns the output
		loadTable($table, $data) -- loads table template, passing $data to it
		br2nl($text) -- replaces all variations of HTML <br> tags with a new line character
		entitiesToUTF8($text) -- convert unicode entities (e.g. &#1234;) to actual UTF8 characters, requires multibyte string PHP extension
		func_get_args_byref() -- returns an array of arguments passed to a function, by reference
		permissions_sql($table, $level) -- returns an array containing the FROM and WHERE additions for applying permissions to an SQL query
		error_message($msg[, $back_url]) -- returns html code for a styled error message .. pass explicit false in second param to suppress back button
		toMySQLDate($formattedDate, $sep = datalist_date_separator, $ord = datalist_date_format)
		reIndex(&$arr) -- returns a copy of the given array, with keys replaced by 1-based numeric indices, and values replaced by original keys
		get_embed($provider, $url[, $width, $height, $retrieve]) -- returns embed code for a given url (supported providers: youtube, googlemap)
		check_record_permission($table, $id, $perm = 'view') -- returns true if current user has the specified permission $perm ('view', 'edit' or 'delete') for the given recors, false otherwise
		NavMenus($options) -- returns the HTML code for the top navigation menus. $options is not implemented currently.
		StyleSheet() -- returns the HTML code for included style sheet files to be placed in the <head> section.
		getUploadDir($dir) -- if dir is empty, returns upload dir configured in defaultLang.php, else returns $dir.
		PrepareUploadedFile($FieldName, $MaxSize, $FileTypes={image file types}, $NoRename=false, $dir="") -- validates and moves uploaded file for given $FieldName into the given $dir (or the default one if empty)
		get_home_links($homeLinks, $default_classes, $tgroup) -- process $homeLinks array and return custom links for homepage. Applies $default_classes to links if links have classes defined, and filters links by $tgroup (using '*' matches all table_group values)
		quick_search_html($search_term, $label, $separate_dv = true) -- returns HTML code for the quick search box.
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	*/

	#########################################################

	function get_table_groups($skip_authentication = false) {
		$tables = getTableList($skip_authentication);
		$all_groups = ['Catalogaci&#243;n', 'Gesti&#243;n de Pr&#233;stamos', 'Autoridades', 'Tablas Auxiliares'];

		$groups = [];
		foreach($all_groups as $grp) {
			foreach($tables as $tn => $td) {
				if($td[3] && $td[3] == $grp) $groups[$grp][] = $tn;
				if(!$td[3]) $groups[0][] = $tn;
			}
		}

		return $groups;
	}

	#########################################################

	function getTablePermissions($tn) {
		static $table_permissions = [];
		if(isset($table_permissions[$tn])) return $table_permissions[$tn];

		$groupID = getLoggedGroupID();
		$memberID = makeSafe(getLoggedMemberID());
		$res_group = sql("SELECT `tableName`, `allowInsert`, `allowView`, `allowEdit`, `allowDelete` FROM `membership_grouppermissions` WHERE `groupID`='{$groupID}'", $eo);
		$res_user  = sql("SELECT `tableName`, `allowInsert`, `allowView`, `allowEdit`, `allowDelete` FROM `membership_userpermissions`  WHERE LCASE(`memberID`)='{$memberID}'", $eo);

		while($row = db_fetch_assoc($res_group)) {
			$table_permissions[$row['tableName']] = [
				1 => intval($row['allowInsert']),
				2 => intval($row['allowView']),
				3 => intval($row['allowEdit']),
				4 => intval($row['allowDelete']),
				'insert' => intval($row['allowInsert']),
				'view' => intval($row['allowView']),
				'edit' => intval($row['allowEdit']),
				'delete' => intval($row['allowDelete'])
			];
		}

		// user-specific permissions, if specified, overwrite his group permissions
		while($row = db_fetch_assoc($res_user)) {
			$table_permissions[$row['tableName']] = [
				1 => intval($row['allowInsert']),
				2 => intval($row['allowView']),
				3 => intval($row['allowEdit']),
				4 => intval($row['allowDelete']),
				'insert' => intval($row['allowInsert']),
				'view' => intval($row['allowView']),
				'edit' => intval($row['allowEdit']),
				'delete' => intval($row['allowDelete'])
			];
		}

		// if user has any type of access, set 'access' flag
		foreach($table_permissions as $t => $p) {
			$table_permissions[$t]['access'] = $table_permissions[$t][0] = false;

			if($p['insert'] || $p['view'] || $p['edit'] || $p['delete']) {
				$table_permissions[$t]['access'] = $table_permissions[$t][0] = true;
			}
		}

		return $table_permissions[$tn];
	}

	#########################################################

	function get_sql_fields($table_name) {
		$sql_fields = [
			'Estado_Conservacion' => "`Estado_Conservacion`.`id` as 'id', `Estado_Conservacion`.`Descripcion` as 'Descripcion'",
			'Estado_Prestable' => "`Estado_Prestable`.`id` as 'id', `Estado_Prestable`.`Descripcion` as 'Descripcion'",
			'Registros' => "`Registros`.`id` as 'id', `Registros`.`Codigo_de_Registro` as 'Codigo_de_Registro', `Registros`.`Codigo_Barras` as 'Codigo_Barras', IF(    CHAR_LENGTH(`Estado_Conservacion1`.`Descripcion`), CONCAT_WS('',   `Estado_Conservacion1`.`Descripcion`), '') as 'id_Estado_Conservacion', IF(    CHAR_LENGTH(`Estado_Prestable1`.`Descripcion`), CONCAT_WS('',   `Estado_Prestable1`.`Descripcion`), '') as 'id_Estado_Prestable', if(`Registros`.`Fecha_Regsitro`,date_format(`Registros`.`Fecha_Regsitro`,'%m/%d/%Y'),'') as 'Fecha_Regsitro'",
			'Estado_Prestamo' => "`Estado_Prestamo`.`id` as 'id', `Estado_Prestamo`.`Descripcion` as 'Descripcion'",
			'Estado_Catalogacion' => "`Estado_Catalogacion`.`id` as 'id', `Estado_Catalogacion`.`Descripcion` as 'Descripcion'",
			'Editoriales' => "`Editoriales`.`id` as 'id', `Editoriales`.`Nombre` as 'Nombre', `Editoriales`.`Direccion` as 'Direccion', `Editoriales`.`Telefono` as 'Telefono', `Editoriales`.`Correo` as 'Correo', `Editoriales`.`Contacto` as 'Contacto'",
			'Catalogo' => "`Catalogo`.`id` as 'id', `Catalogo`.`Portada` as 'Portada', IF(    CHAR_LENGTH(`Registros1`.`Codigo_de_Registro`), CONCAT_WS('',   `Registros1`.`Codigo_de_Registro`), '') as 'Codigo_Registro', IF(    CHAR_LENGTH(`Registros1`.`Codigo_Barras`), CONCAT_WS('',   `Registros1`.`Codigo_Barras`), '') as 'Cod_Barras', `Catalogo`.`Item` as 'Item', `Catalogo`.`Cod_Ejemplar` as 'Cod_Ejemplar', `Catalogo`.`Tipo_Literatura` as 'Tipo_Literatura', IF(    CHAR_LENGTH(`Tipo_Documento1`.`Descripcion`), CONCAT_WS('',   `Tipo_Documento1`.`Descripcion`), '') as 'Tipo_Documento', IF(    CHAR_LENGTH(`Estado_Catalogacion1`.`Descripcion`), CONCAT_WS('',   `Estado_Catalogacion1`.`Descripcion`), '') as 'id_Estado_Catalogacion', `Catalogo`.`Signatura_Topografica` as 'Signatura_Topografica', IF(    CHAR_LENGTH(`Autoridades1`.`Nombre`), CONCAT_WS('',   `Autoridades1`.`Nombre`), '') as 'Id_Autoridad', `Catalogo`.`Titulo` as 'Titulo', `Catalogo`.`Responsabilidades` as 'Responsabilidades', `Catalogo`.`Edicion` as 'Edicion', IF(    CHAR_LENGTH(`Lugares1`.`Descripcion`), CONCAT_WS('',   `Lugares1`.`Descripcion`), '') as 'Id_Lugar', IF(    CHAR_LENGTH(`Editoriales1`.`Nombre`), CONCAT_WS('',   `Editoriales1`.`Nombre`), '') as 'id_Editorial', `Catalogo`.`Fecha_Publicacion` as 'Fecha_Publicacion', `Catalogo`.`Desc_Fisica` as 'Desc_Fisica', `Catalogo`.`Notas` as 'Notas', IF(    CHAR_LENGTH(`Materias1`.`Descriptor`), CONCAT_WS('',   `Materias1`.`Descriptor`), '') as 'Materia_1', IF(    CHAR_LENGTH(`Materias2`.`Descriptor`), CONCAT_WS('',   `Materias2`.`Descriptor`), '') as 'Materia_2', IF(    CHAR_LENGTH(`Materias3`.`Descriptor`), CONCAT_WS('',   `Materias3`.`Descriptor`), '') as 'Materia_3', `Catalogo`.`Ejemplares` as 'Ejemplares', if(`Catalogo`.`Fecha_Catalogacion`,date_format(`Catalogo`.`Fecha_Catalogacion`,'%m/%d/%Y'),'') as 'Fecha_Catalogacion'",
			'Circulacion' => "`Circulacion`.`id` as 'id', IF(    CHAR_LENGTH(`Usuarios1`.`Apellidos`) || CHAR_LENGTH(`Usuarios1`.`Nombres`), CONCAT_WS('',   `Usuarios1`.`Apellidos`, ', ', `Usuarios1`.`Nombres`), '') as 'id_Usuario', IF(    CHAR_LENGTH(`Usuarios1`.`Foto`), CONCAT_WS('',   `Usuarios1`.`Foto`), '') as 'Foto_Usuario', IF(    CHAR_LENGTH(`Tipo_Usuario1`.`Descripcion`), CONCAT_WS('',   `Tipo_Usuario1`.`Descripcion`), '') as 'id_Tipo_usuario', IF(    CHAR_LENGTH(`Politica_de_Prestamos1`.`Duracion_Prestamo`) || CHAR_LENGTH(`Politica_de_Prestamos1`.`Lim_Doc_Presado`), CONCAT_WS('',   `Politica_de_Prestamos1`.`Duracion_Prestamo`, ' dias. L&#237;mite: ', `Politica_de_Prestamos1`.`Lim_Doc_Presado`), '') as 'id_Politica_pretamo', IF(    CHAR_LENGTH(`Tipo_Documento1`.`Descripcion`), CONCAT_WS('',   `Tipo_Documento1`.`Descripcion`), '') as 'id_Tipo_documento', IF(    CHAR_LENGTH(`Registros1`.`Codigo_de_Registro`), CONCAT_WS('',   `Registros1`.`Codigo_de_Registro`), '') as 'id_Registro', IF(    CHAR_LENGTH(`Catalogo1`.`Titulo`), CONCAT_WS('',   `Catalogo1`.`Titulo`), '') as 'Libro_Prestado', IF(    CHAR_LENGTH(`Catalogo1`.`Portada`), CONCAT_WS('',   `Catalogo1`.`Portada`), '') as 'Portada_libro', if(`Circulacion`.`Fecha_Prestamo`,date_format(`Circulacion`.`Fecha_Prestamo`,'%m/%d/%Y'),'') as 'Fecha_Prestamo', if(`Circulacion`.`Fecha_Devolucion`,date_format(`Circulacion`.`Fecha_Devolucion`,'%m/%d/%Y'),'') as 'Fecha_Devolucion', IF(    CHAR_LENGTH(`Estado_Prestamo1`.`Descripcion`), CONCAT_WS('',   `Estado_Prestamo1`.`Descripcion`), '') as 'id_Estado_prestamo', `Circulacion`.`Cantidad` as 'Cantidad', IF(    CHAR_LENGTH(`Catalogo1`.`Ejemplares`), CONCAT_WS('',   `Catalogo1`.`Ejemplares`), '') as 'Ejemp_Disponibles', IF(    CHAR_LENGTH(`Catalogo1`.`Item`), CONCAT_WS('',   `Catalogo1`.`Item`), '') as 'Item', IF(    CHAR_LENGTH(`Itemes1`.`Cod_Ejemplar`), CONCAT_WS('',   `Itemes1`.`Cod_Ejemplar`), '') as 'Cod_Ejemplar'",
			'Tipo_Documento' => "`Tipo_Documento`.`id` as 'id', `Tipo_Documento`.`Descripcion` as 'Descripcion'",
			'Autoridades' => "`Autoridades`.`id` as 'id', `Autoridades`.`Foto` as 'Foto', IF(    CHAR_LENGTH(`Tipo_Autoridad1`.`Descripcion`), CONCAT_WS('',   `Tipo_Autoridad1`.`Descripcion`), '') as 'id_Tipo_autoridad', `Autoridades`.`Nombre` as 'Nombre', `Autoridades`.`Fecha_Extrema` as 'Fecha_Extrema', `Autoridades`.`Vease_Ademas` as 'Vease_Ademas'",
			'Estado_Suscripcion' => "`Estado_Suscripcion`.`id` as 'id', `Estado_Suscripcion`.`Descripcion` as 'Descripcion'",
			'Usuarios' => "`Usuarios`.`id` as 'id', `Usuarios`.`Foto` as 'Foto', IF(    CHAR_LENGTH(`Tipo_Usuario1`.`Descripcion`), CONCAT_WS('',   `Tipo_Usuario1`.`Descripcion`), '') as 'id_Tipo_usuario', `Usuarios`.`Apellidos` as 'Apellidos', `Usuarios`.`Nombres` as 'Nombres', `Usuarios`.`Correo` as 'Correo', `Usuarios`.`Telefono` as 'Telefono', IF(    CHAR_LENGTH(`Estado_Suscripcion1`.`Descripcion`), CONCAT_WS('',   `Estado_Suscripcion1`.`Descripcion`), '') as 'id_Estado_suscripcion', if(`Usuarios`.`Fecha_Registro`,date_format(`Usuarios`.`Fecha_Registro`,'%m/%d/%Y'),'') as 'Fecha_Registro'",
			'Politica_de_Prestamos' => "`Politica_de_Prestamos`.`id` as 'id', IF(    CHAR_LENGTH(`Tipo_Usuario1`.`Descripcion`), CONCAT_WS('',   `Tipo_Usuario1`.`Descripcion`), '') as 'id_Tipo_usuario', IF(    CHAR_LENGTH(`Tipo_Documento1`.`Descripcion`), CONCAT_WS('',   `Tipo_Documento1`.`Descripcion`), '') as 'id_Tipo_documento', `Politica_de_Prestamos`.`Duracion_Prestamo` as 'Duracion_Prestamo', `Politica_de_Prestamos`.`Lim_Doc_Presado` as 'Lim_Doc_Presado'",
			'Lugares' => "`Lugares`.`id` as 'id', `Lugares`.`Descripcion` as 'Descripcion'",
			'Tipo_Autoridad' => "`Tipo_Autoridad`.`id` as 'id', `Tipo_Autoridad`.`Descripcion` as 'Descripcion'",
			'Tipo_Usuario' => "`Tipo_Usuario`.`id` as 'id', `Tipo_Usuario`.`Descripcion` as 'Descripcion', `Tipo_Usuario`.`Lim_Doc_Prestado` as 'Lim_Doc_Prestado', `Tipo_Usuario`.`Lim_Doc_Reserva` as 'Lim_Doc_Reserva'",
			'Materias' => "`Materias`.`id` as 'id', `Materias`.`Descriptor` as 'Descriptor'",
			'Itemes' => "`Itemes`.`id` as 'id', IF(    CHAR_LENGTH(`Catalogo1`.`Item`), CONCAT_WS('',   `Catalogo1`.`Item`), '') as 'Cod_item', IF(    CHAR_LENGTH(`Estado_Conservacion1`.`Descripcion`), CONCAT_WS('',   `Estado_Conservacion1`.`Descripcion`), '') as 'Estado_Conservacion', `Itemes`.`Num_Copia` as 'Num_Copia', `Itemes`.`Cod_Ejemplar` as 'Cod_Ejemplar', `Itemes`.`Estado_de_Baja` as 'Estado_de_Baja'",
		];

		if(isset($sql_fields[$table_name])) return $sql_fields[$table_name];

		return false;
	}

	#########################################################

	function get_sql_from($table_name, $skip_permissions = false, $skip_joins = false, $lower_permissions = false) {
		$sql_from = [
			'Estado_Conservacion' => "`Estado_Conservacion` ",
			'Estado_Prestable' => "`Estado_Prestable` ",
			'Registros' => "`Registros` LEFT JOIN `Estado_Conservacion` as Estado_Conservacion1 ON `Estado_Conservacion1`.`id`=`Registros`.`id_Estado_Conservacion` LEFT JOIN `Estado_Prestable` as Estado_Prestable1 ON `Estado_Prestable1`.`id`=`Registros`.`id_Estado_Prestable` ",
			'Estado_Prestamo' => "`Estado_Prestamo` ",
			'Estado_Catalogacion' => "`Estado_Catalogacion` ",
			'Editoriales' => "`Editoriales` ",
			'Catalogo' => "`Catalogo` LEFT JOIN `Registros` as Registros1 ON `Registros1`.`id`=`Catalogo`.`Codigo_Registro` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Catalogo`.`Tipo_Documento` LEFT JOIN `Estado_Catalogacion` as Estado_Catalogacion1 ON `Estado_Catalogacion1`.`id`=`Catalogo`.`id_Estado_Catalogacion` LEFT JOIN `Autoridades` as Autoridades1 ON `Autoridades1`.`id`=`Catalogo`.`Id_Autoridad` LEFT JOIN `Lugares` as Lugares1 ON `Lugares1`.`id`=`Catalogo`.`Id_Lugar` LEFT JOIN `Editoriales` as Editoriales1 ON `Editoriales1`.`id`=`Catalogo`.`id_Editorial` LEFT JOIN `Materias` as Materias1 ON `Materias1`.`id`=`Catalogo`.`Materia_1` LEFT JOIN `Materias` as Materias2 ON `Materias2`.`id`=`Catalogo`.`Materia_2` LEFT JOIN `Materias` as Materias3 ON `Materias3`.`id`=`Catalogo`.`Materia_3` ",
			'Circulacion' => "`Circulacion` LEFT JOIN `Usuarios` as Usuarios1 ON `Usuarios1`.`id`=`Circulacion`.`id_Usuario` LEFT JOIN `Tipo_Usuario` as Tipo_Usuario1 ON `Tipo_Usuario1`.`id`=`Circulacion`.`id_Tipo_usuario` LEFT JOIN `Politica_de_Prestamos` as Politica_de_Prestamos1 ON `Politica_de_Prestamos1`.`id`=`Circulacion`.`id_Politica_pretamo` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Circulacion`.`id_Tipo_documento` LEFT JOIN `Catalogo` as Catalogo1 ON `Catalogo1`.`id`=`Circulacion`.`Libro_Prestado` LEFT JOIN `Estado_Prestamo` as Estado_Prestamo1 ON `Estado_Prestamo1`.`id`=`Circulacion`.`id_Estado_prestamo` LEFT JOIN `Itemes` as Itemes1 ON `Itemes1`.`id`=`Circulacion`.`Cod_Ejemplar` LEFT JOIN `Registros` as Registros1 ON `Registros1`.`id`=`Catalogo1`.`Codigo_Registro` ",
			'Tipo_Documento' => "`Tipo_Documento` ",
			'Autoridades' => "`Autoridades` LEFT JOIN `Tipo_Autoridad` as Tipo_Autoridad1 ON `Tipo_Autoridad1`.`id`=`Autoridades`.`id_Tipo_autoridad` ",
			'Estado_Suscripcion' => "`Estado_Suscripcion` ",
			'Usuarios' => "`Usuarios` LEFT JOIN `Tipo_Usuario` as Tipo_Usuario1 ON `Tipo_Usuario1`.`id`=`Usuarios`.`id_Tipo_usuario` LEFT JOIN `Estado_Suscripcion` as Estado_Suscripcion1 ON `Estado_Suscripcion1`.`id`=`Usuarios`.`id_Estado_suscripcion` ",
			'Politica_de_Prestamos' => "`Politica_de_Prestamos` LEFT JOIN `Tipo_Usuario` as Tipo_Usuario1 ON `Tipo_Usuario1`.`id`=`Politica_de_Prestamos`.`id_Tipo_usuario` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Politica_de_Prestamos`.`id_Tipo_documento` ",
			'Lugares' => "`Lugares` ",
			'Tipo_Autoridad' => "`Tipo_Autoridad` ",
			'Tipo_Usuario' => "`Tipo_Usuario` ",
			'Materias' => "`Materias` ",
			'Itemes' => "`Itemes` LEFT JOIN `Catalogo` as Catalogo1 ON `Catalogo1`.`id`=`Itemes`.`Cod_item` LEFT JOIN `Estado_Conservacion` as Estado_Conservacion1 ON `Estado_Conservacion1`.`id`=`Itemes`.`Estado_Conservacion` ",
		];

		$pkey = [
			'Estado_Conservacion' => 'id',
			'Estado_Prestable' => 'id',
			'Registros' => 'id',
			'Estado_Prestamo' => 'id',
			'Estado_Catalogacion' => 'id',
			'Editoriales' => 'id',
			'Catalogo' => 'id',
			'Circulacion' => 'id',
			'Tipo_Documento' => 'id',
			'Autoridades' => 'id',
			'Estado_Suscripcion' => 'id',
			'Usuarios' => 'id',
			'Politica_de_Prestamos' => 'id',
			'Lugares' => 'id',
			'Tipo_Autoridad' => 'id',
			'Tipo_Usuario' => 'id',
			'Materias' => 'id',
			'Itemes' => 'id',
		];

		if(!isset($sql_from[$table_name])) return false;

		$from = ($skip_joins ? "`{$table_name}`" : $sql_from[$table_name]);

		if($skip_permissions) return $from . ' WHERE 1=1';

		// mm: build the query based on current member's permissions
		// allowing lower permissions if $lower_permissions set to 'user' or 'group'
		$perm = getTablePermissions($table_name);
		if($perm['view'] == 1 || ($perm['view'] > 1 && $lower_permissions == 'user')) { // view owner only
			$from .= ", `membership_userrecords` WHERE `{$table_name}`.`{$pkey[$table_name]}`=`membership_userrecords`.`pkValue` AND `membership_userrecords`.`tableName`='{$table_name}' AND LCASE(`membership_userrecords`.`memberID`)='" . getLoggedMemberID() . "'";
		} elseif($perm['view'] == 2 || ($perm['view'] > 2 && $lower_permissions == 'group')) { // view group only
			$from .= ", `membership_userrecords` WHERE `{$table_name}`.`{$pkey[$table_name]}`=`membership_userrecords`.`pkValue` AND `membership_userrecords`.`tableName`='{$table_name}' AND `membership_userrecords`.`groupID`='" . getLoggedGroupID() . "'";
		} elseif($perm['view'] == 3) { // view all
			$from .= ' WHERE 1=1';
		} else { // view none
			return false;
		}

		return $from;
	}

	#########################################################

	function get_joined_record($table, $id, $skip_permissions = false) {
		$sql_fields = get_sql_fields($table);
		$sql_from = get_sql_from($table, $skip_permissions);

		if(!$sql_fields || !$sql_from) return false;

		$pk = getPKFieldName($table);
		if(!$pk) return false;

		$safe_id = makeSafe($id, false);
		$sql = "SELECT {$sql_fields} FROM {$sql_from} AND `{$table}`.`{$pk}`='{$safe_id}'";
		$eo = ['silentErrors' => true];
		$res = sql($sql, $eo);
		if($row = db_fetch_assoc($res)) return $row;

		return false;
	}

	#########################################################

	function get_defaults($table) {
		/* array of tables and their fields, with default values (or empty), excluding automatic values */
		$defaults = [
			'Estado_Conservacion' => [
				'id' => '',
				'Descripcion' => '',
			],
			'Estado_Prestable' => [
				'id' => '',
				'Descripcion' => '',
			],
			'Registros' => [
				'id' => '',
				'Codigo_de_Registro' => '',
				'Codigo_Barras' => '',
				'id_Estado_Conservacion' => '',
				'id_Estado_Prestable' => '',
				'Fecha_Regsitro' => '',
			],
			'Estado_Prestamo' => [
				'id' => '',
				'Descripcion' => '',
			],
			'Estado_Catalogacion' => [
				'id' => '',
				'Descripcion' => '',
			],
			'Editoriales' => [
				'id' => '',
				'Nombre' => '',
				'Direccion' => '',
				'Telefono' => '',
				'Correo' => '',
				'Contacto' => '',
			],
			'Catalogo' => [
				'id' => '',
				'Portada' => '',
				'Codigo_Registro' => '',
				'Cod_Barras' => '',
				'Item' => '',
				'Cod_Ejemplar' => '',
				'Tipo_Literatura' => '',
				'Tipo_Documento' => '',
				'id_Estado_Catalogacion' => '',
				'Signatura_Topografica' => '',
				'Id_Autoridad' => '',
				'Titulo' => '',
				'Responsabilidades' => '',
				'Edicion' => '',
				'Id_Lugar' => '',
				'id_Editorial' => '',
				'Fecha_Publicacion' => '',
				'Desc_Fisica' => '',
				'Notas' => '',
				'Materia_1' => '',
				'Materia_2' => '',
				'Materia_3' => '',
				'Ejemplares' => '',
				'Fecha_Catalogacion' => '',
			],
			'Circulacion' => [
				'id' => '',
				'id_Usuario' => '',
				'Foto_Usuario' => '',
				'id_Tipo_usuario' => '',
				'id_Politica_pretamo' => '',
				'id_Tipo_documento' => '',
				'id_Registro' => '',
				'Libro_Prestado' => '',
				'Portada_libro' => '',
				'Fecha_Prestamo' => '',
				'Fecha_Devolucion' => '',
				'id_Estado_prestamo' => '',
				'Cantidad' => '',
				'Ejemp_Disponibles' => '',
				'Item' => '',
				'Cod_Ejemplar' => '',
			],
			'Tipo_Documento' => [
				'id' => '',
				'Descripcion' => '',
			],
			'Autoridades' => [
				'id' => '',
				'Foto' => '',
				'id_Tipo_autoridad' => '',
				'Nombre' => '',
				'Fecha_Extrema' => '',
				'Vease_Ademas' => '',
			],
			'Estado_Suscripcion' => [
				'id' => '',
				'Descripcion' => '',
			],
			'Usuarios' => [
				'id' => '',
				'Foto' => '',
				'id_Tipo_usuario' => '',
				'Apellidos' => '',
				'Nombres' => '',
				'Correo' => '',
				'Telefono' => '',
				'id_Estado_suscripcion' => '',
				'Fecha_Registro' => '',
			],
			'Politica_de_Prestamos' => [
				'id' => '',
				'id_Tipo_usuario' => '',
				'id_Tipo_documento' => '',
				'Duracion_Prestamo' => '',
				'Lim_Doc_Presado' => '',
			],
			'Lugares' => [
				'id' => '',
				'Descripcion' => '',
			],
			'Tipo_Autoridad' => [
				'id' => '',
				'Descripcion' => '',
			],
			'Tipo_Usuario' => [
				'id' => '',
				'Descripcion' => '',
				'Lim_Doc_Prestado' => '',
				'Lim_Doc_Reserva' => '',
			],
			'Materias' => [
				'id' => '',
				'Descriptor' => '',
			],
			'Itemes' => [
				'id' => '',
				'Cod_item' => '',
				'Estado_Conservacion' => '',
				'Num_Copia' => '',
				'Cod_Ejemplar' => '',
				'Estado_de_Baja' => '',
			],
		];

		return isset($defaults[$table]) ? $defaults[$table] : [];
	}

	#########################################################

	function htmlUserBar() {
		global $Translation;
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');

		$mi = getMemberInfo();
		$adminConfig = config('adminConfig');
		$home_page = (basename($_SERVER['PHP_SELF']) == 'index.php');
		ob_start();

		?>
		<nav class="navbar navbar-default navbar-fixed-top hidden-print" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<!-- application title is obtained from the name besides the yellow database icon in AppGini, use underscores for spaces -->
				<a class="navbar-brand" href="<?php echo PREPEND_PATH; ?>index.php"><i class="glyphicon glyphicon-home"></i> <?php echo APP_TITLE; ?></a>
			</div>
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav"><?php echo ($home_page ? '' : NavMenus()); ?></ul>

				<?php if(userCanImport()){ ?>
					<ul class="nav navbar-nav">
						<a href="<?php echo PREPEND_PATH; ?>import-csv.php" class="btn btn-default navbar-btn hidden-xs btn-import-csv" title="<?php echo html_attr($Translation['import csv file']); ?>"><i class="glyphicon glyphicon-th"></i> <?php echo $Translation['import CSV']; ?></a>
						<a href="<?php echo PREPEND_PATH; ?>import-csv.php" class="btn btn-default navbar-btn visible-xs btn-lg btn-import-csv" title="<?php echo html_attr($Translation['import csv file']); ?>"><i class="glyphicon glyphicon-th"></i> <?php echo $Translation['import CSV']; ?></a>
					</ul>
				<?php } ?>

				<?php if(getLoggedAdmin() !== false) { ?>
					<ul class="nav navbar-nav">
						<a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-danger navbar-btn hidden-xs" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['admin area']; ?></a>
						<a href="<?php echo PREPEND_PATH; ?>admin/pageHome.php" class="btn btn-danger navbar-btn visible-xs btn-lg" title="<?php echo html_attr($Translation['admin area']); ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $Translation['admin area']; ?></a>
					</ul>
				<?php } ?>

				<?php if(!Request::val('signIn') && !Request::val('loginFailed')) { ?>
					<?php if(!$mi['username'] || $mi['username'] == $adminConfig['anonymousMember']) { ?>
						<p class="navbar-text navbar-right hidden-xs">&nbsp;</p>
						<a href="<?php echo PREPEND_PATH; ?>index.php?signIn=1" class="btn btn-success navbar-btn navbar-right hidden-xs"><?php echo $Translation['sign in']; ?></a>
						<p class="navbar-text navbar-right hidden-xs">
							<?php echo $Translation['not signed in']; ?>
						</p>
						<a href="<?php echo PREPEND_PATH; ?>index.php?signIn=1" class="btn btn-success btn-block btn-lg navbar-btn visible-xs">
							<?php echo $Translation['not signed in']; ?>
							<i class="glyphicon glyphicon-chevron-right"></i> 
							<?php echo $Translation['sign in']; ?>
						</a>
					<?php } else { ?>
						<ul class="nav navbar-nav navbar-right hidden-xs">
							<!-- logged user profile menu -->
							<li class="dropdown" title="<?php echo html_attr("{$Translation['signed as']} {$mi['username']}"); ?>">
								<a href="#" class="dropdown-toggle profile-menu-icon" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i></a>
								<ul class="dropdown-menu profile-menu">
									<li class="user-profile-menu-item" title="<?php echo html_attr("{$Translation['Your info']}"); ?>">
										<a href="<?php echo PREPEND_PATH; ?>membership_profile.php"><i class="glyphicon glyphicon-user"></i> <span class="username"><?php echo $mi['username']; ?></span></a>
									</li>
									<li class="keyboard-shortcuts-menu-item" title="<?php echo html_attr("{$Translation['keyboard shortcuts']}"); ?>" class="hidden-xs">
										<a href="#" class="help-shortcuts-launcher">
											<img src="<?php echo PREPEND_PATH; ?>resources/images/keyboard.png">
											<?php echo html_attr($Translation['keyboard shortcuts']); ?>
										</a>
									</li>
									<li class="sign-out-menu-item" title="<?php echo html_attr("{$Translation['sign out']}"); ?>">
										<a href="<?php echo PREPEND_PATH; ?>index.php?signOut=1"><i class="glyphicon glyphicon-log-out"></i> <?php echo $Translation['sign out']; ?></a>
									</li>
								</ul>
							</li>
						</ul>
						<ul class="nav navbar-nav visible-xs">
							<a class="btn navbar-btn btn-default btn-lg visible-xs" href="<?php echo PREPEND_PATH; ?>index.php?signOut=1"><i class="glyphicon glyphicon-log-out"></i> <?php echo $Translation['sign out']; ?></a>
							<p class="navbar-text text-center signed-in-as">
								<?php echo $Translation['signed as']; ?> <strong><a href="<?php echo PREPEND_PATH; ?>membership_profile.php" class="navbar-link username"><?php echo $mi['username']; ?></a></strong>
							</p>
						</ul>
						<script>
							/* periodically check if user is still signed in */
							setInterval(function() {
								$j.ajax({
									url: '<?php echo PREPEND_PATH; ?>ajax_check_login.php',
									success: function(username) {
										if(!username.length) window.location = '<?php echo PREPEND_PATH; ?>index.php?signIn=1';
									}
								});
							}, 60000);
						</script>
					<?php } ?>
				<?php } ?>
			</div>
		</nav>
		<?php

		return ob_get_clean();
	}

	#########################################################

	function showNotifications($msg = '', $class = '', $fadeout = true) {
		global $Translation;
		if($error_message = strip_tags(Request::val('error_message')))
			$error_message = '<div class="text-bold">' . $error_message . '</div>';

		if(!$msg) { // if no msg, use url to detect message to display
			if(Request::val('record-added-ok')) {
				$msg = $Translation['new record saved'];
				$class = 'alert-success';
			} elseif(Request::val('record-added-error')) {
				$msg = $Translation['Couldn\'t save the new record'] . $error_message;
				$class = 'alert-danger';
				$fadeout = false;
			} elseif(Request::val('record-updated-ok')) {
				$msg = $Translation['record updated'];
				$class = 'alert-success';
			} elseif(Request::val('record-updated-error')) {
				$msg = $Translation['Couldn\'t save changes to the record'] . $error_message;
				$class = 'alert-danger';
				$fadeout = false;
			} elseif(Request::val('record-deleted-ok')) {
				$msg = $Translation['The record has been deleted successfully'];
				$class = 'alert-success';
			} elseif(Request::val('record-deleted-error')) {
				$msg = $Translation['Couldn\'t delete this record'] . $error_message;
				$class = 'alert-danger';
				$fadeout = false;
			} else {
				return '';
			}
		}
		$id = 'notification-' . rand();

		ob_start();
		// notification template
		?>
		<div id="%%ID%%" class="alert alert-dismissable %%CLASS%%" style="opacity: 1; padding-top: 6px; padding-bottom: 6px; animation: fadeIn 1.5s ease-out; z-index: 100; position: relative;">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			%%MSG%%
		</div>
		<script>
			$j(function() {
				var autoDismiss = <?php echo $fadeout ? 'true' : 'false'; ?>,
					embedded = !$j('nav').length,
					messageDelay = 10, fadeDelay = 1.5;

				if(!autoDismiss) {
					if(embedded)
						$j('#%%ID%%').before('<div style="height: 2rem;"></div>');
					else
						$j('#%%ID%%').css({ margin: '0 0 1rem' });

					return;
				}

				// below code runs only in case of autoDismiss

				if(embedded)
					$j('#%%ID%%').css({ margin: '1rem 0 -1rem' });
				else
					$j('#%%ID%%').css({ margin: '-15px 0 -20px' });

				setTimeout(function() {
					$j('#%%ID%%').css({    animation: 'fadeOut ' + fadeDelay + 's ease-out' });
				}, messageDelay * 1000);

				setTimeout(function() {
					$j('#%%ID%%').css({    visibility: 'hidden' });
				}, (messageDelay + fadeDelay) * 1000);
			})
		</script>
		<style>
			@keyframes fadeIn {
				0%   { opacity: 0; }
				100% { opacity: 1; }
			}
			@keyframes fadeOut {
				0%   { opacity: 1; }
				100% { opacity: 0; }
			}
		</style>

		<?php
		$out = ob_get_clean();

		$out = str_replace('%%ID%%', $id, $out);
		$out = str_replace('%%MSG%%', $msg, $out);
		$out = str_replace('%%CLASS%%', $class, $out);

		return $out;
	}

	#########################################################

	function validMySQLDate($date) {
		$date = trim($date);

		try {
			$dtObj = new DateTime($date);
		} catch(Exception $e) {
			return false;
		}

		$parts = explode('-', $date);
		return (
			count($parts) == 3
			// see https://dev.mysql.com/doc/refman/8.0/en/datetime.html
			&& intval($parts[0]) >= 1000
			&& intval($parts[0]) <= 9999
			&& intval($parts[1]) >= 1
			&& intval($parts[1]) <= 12
			&& intval($parts[2]) >= 1
			&& intval($parts[2]) <= 31
		);
	}

	#########################################################

	function parseMySQLDate($date, $altDate) {
		// is $date valid?
		if(validMySQLDate($date)) return trim($date);

		if($date != '--' && validMySQLDate($altDate)) return trim($altDate);

		if($date != '--' && $altDate && is_numeric($altDate))
			return @date('Y-m-d', @time() + ($altDate >= 1 ? $altDate - 1 : $altDate) * 86400);

		return '';
	}

	#########################################################

	function parseCode($code, $isInsert = true, $rawData = false) {
		$mi = Authentication::getUser();

		if($isInsert) {
			$arrCodes = [
				'<%%creatorusername%%>' => $mi['username'],
				'<%%creatorgroupid%%>' => $mi['groupId'],
				'<%%creatorip%%>' => $_SERVER['REMOTE_ADDR'],
				'<%%creatorgroup%%>' => $mi['group'],

				'<%%creationdate%%>' => ($rawData ? date('Y-m-d') : date(app_datetime_format('phps'))),
				'<%%creationtime%%>' => ($rawData ? date('H:i:s') : date(app_datetime_format('phps', 't'))),
				'<%%creationdatetime%%>' => ($rawData ? date('Y-m-d H:i:s') : date(app_datetime_format('phps', 'dt'))),
				'<%%creationtimestamp%%>' => ($rawData ? date('Y-m-d H:i:s') : time()),
			];
		} else {
			$arrCodes = [
				'<%%editorusername%%>' => $mi['username'],
				'<%%editorgroupid%%>' => $mi['groupId'],
				'<%%editorip%%>' => $_SERVER['REMOTE_ADDR'],
				'<%%editorgroup%%>' => $mi['group'],

				'<%%editingdate%%>' => ($rawData ? date('Y-m-d') : date(app_datetime_format('phps'))),
				'<%%editingtime%%>' => ($rawData ? date('H:i:s') : date(app_datetime_format('phps', 't'))),
				'<%%editingdatetime%%>' => ($rawData ? date('Y-m-d H:i:s') : date(app_datetime_format('phps', 'dt'))),
				'<%%editingtimestamp%%>' => ($rawData ? date('Y-m-d H:i:s') : time()),
			];
		}

		$pc = str_ireplace(array_keys($arrCodes), array_values($arrCodes), $code);

		return $pc;
	}

	#########################################################

	function addFilter($index, $filterAnd, $filterField, $filterOperator, $filterValue) {
		// validate input
		if($index < 1 || $index > 80 || !is_int($index)) return false;
		if($filterAnd != 'or')   $filterAnd = 'and';
		$filterField = intval($filterField);

		/* backward compatibility */
		if(in_array($filterOperator, FILTER_OPERATORS)) {
			$filterOperator = array_search($filterOperator, FILTER_OPERATORS);
		}

		if(!in_array($filterOperator, array_keys(FILTER_OPERATORS))) {
			$filterOperator = 'like';
		}

		if(!$filterField) {
			$filterOperator = '';
			$filterValue = '';
		}

		$_REQUEST['FilterAnd'][$index] = $filterAnd;
		$_REQUEST['FilterField'][$index] = $filterField;
		$_REQUEST['FilterOperator'][$index] = $filterOperator;
		$_REQUEST['FilterValue'][$index] = $filterValue;

		return true;
	}

	#########################################################

	function clearFilters() {
		for($i=1; $i<=80; $i++) {
			addFilter($i, '', 0, '', '');
		}
	}

	#########################################################

	/**
	* Loads a given view from the templates folder, passing the given data to it
	* @param $view the name of a php file (without extension) to be loaded from the 'templates' folder
	* @param $the_data_to_pass_to_the_view (optional) associative array containing the data to pass to the view
	* @return the output of the parsed view as a string
	*/
	function loadView($view, $the_data_to_pass_to_the_view = false) {
		global $Translation;

		$view = __DIR__ . "/templates/$view.php";
		if(!is_file($view)) return false;

		if(is_array($the_data_to_pass_to_the_view)) {
			foreach($the_data_to_pass_to_the_view as $data_k => $data_v)
				$$data_k = $data_v;
		}
		unset($the_data_to_pass_to_the_view, $data_k, $data_v);

		ob_start();
		@include($view);
		return ob_get_clean();
	}

	#########################################################

	/**
	* Loads a table template from the templates folder, passing the given data to it
	* @param $table_name the name of the table whose template is to be loaded from the 'templates' folder
	* @param $the_data_to_pass_to_the_table associative array containing the data to pass to the table template
	* @return the output of the parsed table template as a string
	*/
	function loadTable($table_name, $the_data_to_pass_to_the_table = []) {
		$dont_load_header = $the_data_to_pass_to_the_table['dont_load_header'];
		$dont_load_footer = $the_data_to_pass_to_the_table['dont_load_footer'];

		$header = $table = $footer = '';

		if(!$dont_load_header) {
			// try to load tablename-header
			if(!($header = loadView("{$table_name}-header", $the_data_to_pass_to_the_table))) {
				$header = loadView('table-common-header', $the_data_to_pass_to_the_table);
			}
		}

		$table = loadView($table_name, $the_data_to_pass_to_the_table);

		if(!$dont_load_footer) {
			// try to load tablename-footer
			if(!($footer = loadView("{$table_name}-footer", $the_data_to_pass_to_the_table))) {
				$footer = loadView('table-common-footer', $the_data_to_pass_to_the_table);
			}
		}

		return "{$header}{$table}{$footer}";
	}

	#########################################################

	function br2nl($text) {
		return  preg_replace('/\<br(\s*)?\/?\>/i', "\n", $text);
	}

	#########################################################

	function entitiesToUTF8($input) {
		return preg_replace_callback('/(&#[0-9]+;)/', '_toUTF8', $input);
	}

	function _toUTF8($m) {
		if(function_exists('mb_convert_encoding')) {
			return mb_convert_encoding($m[1], "UTF-8", "HTML-ENTITIES");
		} else {
			return $m[1];
		}
	}

	#########################################################

	function func_get_args_byref() {
		if(!function_exists('debug_backtrace')) return false;

		$trace = debug_backtrace();
		return $trace[1]['args'];
	}

	#########################################################

	function permissions_sql($table, $level = 'all') {
		if(!in_array($level, ['user', 'group'])) { $level = 'all'; }
		$perm = getTablePermissions($table);
		$from = '';
		$where = '';
		$pk = getPKFieldName($table);

		if($perm['view'] == 1 || ($perm['view'] > 1 && $level == 'user')) { // view owner only
			$from = 'membership_userrecords';
			$where = "(`$table`.`$pk`=membership_userrecords.pkValue and membership_userrecords.tableName='$table' and lcase(membership_userrecords.memberID)='" . getLoggedMemberID() . "')";
		} elseif($perm['view'] == 2 || ($perm['view'] > 2 && $level == 'group')) { // view group only
			$from = 'membership_userrecords';
			$where = "(`$table`.`$pk`=membership_userrecords.pkValue and membership_userrecords.tableName='$table' and membership_userrecords.groupID='" . getLoggedGroupID() . "')";
		} elseif($perm['view'] == 3) { // view all
			// no further action
		} elseif($perm['view'] == 0) { // view none
			return false;
		}

		return ['where' => $where, 'from' => $from, 0 => $where, 1 => $from];
	}

	#########################################################

	function error_message($msg, $back_url = '', $full_page = true) {
		global $Translation;

		ob_start();

		if($full_page) include(__DIR__ . '/header.php');

		echo '<div class="panel panel-danger">';
			echo '<div class="panel-heading"><h3 class="panel-title">' . $Translation['error:'] . '</h3></div>';
			echo '<div class="panel-body"><p class="text-danger">' . $msg . '</p>';
			if($back_url !== false) { // explicitly passing false suppresses the back link completely
				echo '<div class="text-center">';
				if($back_url) {
					echo '<a href="' . $back_url . '" class="btn btn-danger btn-lg vspacer-lg"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</a>';
				} else {
					echo '<a href="#" class="btn btn-danger btn-lg vspacer-lg" onclick="history.go(-1); return false;"><i class="glyphicon glyphicon-chevron-left"></i> ' . $Translation['< back'] . '</a>';
				}
				echo '</div>';
			}
			echo '</div>';
		echo '</div>';

		if($full_page) include(__DIR__ . '/footer.php');

		return ob_get_clean();
	}

	#########################################################

	function toMySQLDate($formattedDate, $sep = datalist_date_separator, $ord = datalist_date_format) {
		// extract date elements
		$de=explode($sep, $formattedDate);
		$mySQLDate=intval($de[strpos($ord, 'Y')]).'-'.intval($de[strpos($ord, 'm')]).'-'.intval($de[strpos($ord, 'd')]);
		return $mySQLDate;
	}

	#########################################################

	function reIndex(&$arr) {
		$i=1;
		foreach($arr as $n=>$v) {
			$arr2[$i]=$n;
			$i++;
		}
		return $arr2;
	}

	#########################################################

	function get_embed($provider, $url, $max_width = '', $max_height = '', $retrieve = 'html') {
		global $Translation;
		if(!$url) return '';

		$providers = [
			'youtube' => ['oembed' => 'https://www.youtube.com/oembed?'],
			'googlemap' => ['oembed' => '', 'regex' => '/^http.*\.google\..*maps/i'],
		];

		if(!isset($providers[$provider])) {
			return '<div class="text-danger">' . $Translation['invalid provider'] . '</div>';
		}

		if(isset($providers[$provider]['regex']) && !preg_match($providers[$provider]['regex'], $url)) {
			return '<div class="text-danger">' . $Translation['invalid url'] . '</div>';
		}

		if($providers[$provider]['oembed']) {
			$oembed = $providers[$provider]['oembed'] . 'url=' . urlencode($url) . "&amp;maxwidth={$max_width}&amp;maxheight={$max_height}&amp;format=json";
			$data_json = request_cache($oembed);

			$data = json_decode($data_json, true);
			if($data === null) {
				/* an error was returned rather than a json string */
				if($retrieve == 'html') return "<div class=\"text-danger\">{$data_json}\n<!-- {$oembed} --></div>";
				return '';
			}

			return (isset($data[$retrieve]) ? $data[$retrieve] : $data['html']);
		}

		/* special cases (where there is no oEmbed provider) */
		if($provider == 'googlemap') return get_embed_googlemap($url, $max_width, $max_height, $retrieve);

		return '<div class="text-danger">Invalid provider!</div>';
	}

	#########################################################

	function get_embed_googlemap($url, $max_width = '', $max_height = '', $retrieve = 'html') {
		global $Translation;
		$url_parts = parse_url($url);
		$coords_regex = '/-?\d+(\.\d+)?[,+]-?\d+(\.\d+)?(,\d{1,2}z)?/'; /* https://stackoverflow.com/questions/2660201 */

		if(preg_match($coords_regex, $url_parts['path'] . '?' . $url_parts['query'], $m)) {
			list($lat, $long, $zoom) = explode(',', $m[0]);
			$zoom = intval($zoom);
			if(!$zoom) $zoom = 10; /* default zoom */
			if(!$max_height) $max_height = 360;
			if(!$max_width) $max_width = 480;

			$api_key = config('adminConfig')['googleAPIKey'];
			$embed_url = "https://www.google.com/maps/embed/v1/view?key={$api_key}&amp;center={$lat},{$long}&amp;zoom={$zoom}&amp;maptype=roadmap";
			$thumbnail_url = "https://maps.googleapis.com/maps/api/staticmap?key={$api_key}&amp;center={$lat},{$long}&amp;zoom={$zoom}&amp;maptype=roadmap&amp;size={$max_width}x{$max_height}";

			if($retrieve == 'html') {
				return "<iframe width=\"{$max_width}\" height=\"{$max_height}\" frameborder=\"0\" style=\"border:0\" src=\"{$embed_url}\"></iframe>";
			} else {
				return $thumbnail_url;
			}
		} else {
			return '<div class="text-danger">' . $Translation['cant retrieve coordinates from url'] . '</div>';
		}
	}

	#########################################################

	function request_cache($request, $force_fetch = false) {
		$max_cache_lifetime = 7 * 86400; /* max cache lifetime in seconds before refreshing from source */

		/* membership_cache table exists? if not, create it */
		static $cache_table_exists = false;
		if(!$cache_table_exists && !$force_fetch) {
			$te = sqlValue("show tables like 'membership_cache'");
			if(!$te) {
				if(!sql("CREATE TABLE `membership_cache` (`request` VARCHAR(100) NOT NULL, `request_ts` INT, `response` TEXT NOT NULL, PRIMARY KEY (`request`))", $eo)) {
					/* table can't be created, so force fetching request */
					return request_cache($request, true);
				}
			}
			$cache_table_exists = true;
		}

		/* retrieve response from cache if exists */
		if(!$force_fetch) {
			$res = sql("select response, request_ts from membership_cache where request='" . md5($request) . "'", $eo);
			if(!$row = db_fetch_array($res)) return request_cache($request, true);

			$response = $row[0];
			$response_ts = $row[1];
			if($response_ts < time() - $max_cache_lifetime) return request_cache($request, true);
		}

		/* if no response in cache, issue a request */
		if(!$response || $force_fetch) {
			$response = @file_get_contents($request);
			if($response === false) {
				$error = error_get_last();
				$error_message = preg_replace('/.*: (.*)/', '$1', $error['message']);
				return $error_message;
			} elseif($cache_table_exists) {
				/* store response in cache */
				$ts = time();
				sql("replace into membership_cache set request='" . md5($request) . "', request_ts='{$ts}', response='" . makeSafe($response, false) . "'", $eo);
			}
		}

		return $response;
	}

	#########################################################

	function check_record_permission($table, $id, $perm = 'view') {
		if($perm != 'edit' && $perm != 'delete') $perm = 'view';

		$perms = getTablePermissions($table);
		if(!$perms[$perm]) return false;

		$safe_id = makeSafe($id);
		$safe_table = makeSafe($table);

		if($perms[$perm] == 1) { // own records only
			$username = getLoggedMemberID();
			$owner = sqlValue("select memberID from membership_userrecords where tableName='{$safe_table}' and pkValue='{$safe_id}'");
			if($owner == $username) return true;
		} elseif($perms[$perm] == 2) { // group records
			$group_id = getLoggedGroupID();
			$owner_group_id = sqlValue("select groupID from membership_userrecords where tableName='{$safe_table}' and pkValue='{$safe_id}'");
			if($owner_group_id == $group_id) return true;
		} elseif($perms[$perm] == 3) { // all records
			return true;
		}

		return false;
	}

	#########################################################

	function NavMenus($options = []) {
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
		global $Translation;
		$prepend_path = PREPEND_PATH;

		/* default options */
		if(empty($options)) {
			$options = ['tabs' => 7];
		}

		$table_group_name = array_keys(get_table_groups()); /* 0 => group1, 1 => group2 .. */
		/* if only one group named 'None', set to translation of 'select a table' */
		if((count($table_group_name) == 1 && $table_group_name[0] == 'None') || count($table_group_name) < 1) $table_group_name[0] = $Translation['select a table'];
		$table_group_index = array_flip($table_group_name); /* group1 => 0, group2 => 1 .. */
		$menu = array_fill(0, count($table_group_name), '');

		$t = time();
		$arrTables = getTableList();
		if(is_array($arrTables)) {
			foreach($arrTables as $tn => $tc) {
				/* ---- list of tables where hide link in nav menu is set ---- */
				$tChkHL = array_search($tn, []);

				/* ---- list of tables where filter first is set ---- */
				$tChkFF = array_search($tn, []);
				if($tChkFF !== false && $tChkFF !== null) {
					$searchFirst = '&Filter_x=1';
				} else {
					$searchFirst = '';
				}

				/* when no groups defined, $table_group_index['None'] is NULL, so $menu_index is still set to 0 */
				$menu_index = intval($table_group_index[$tc[3]]);
				if(!$tChkHL && $tChkHL !== 0) $menu[$menu_index] .= "<li><a href=\"{$prepend_path}{$tn}_view.php?t={$t}{$searchFirst}\"><img src=\"{$prepend_path}" . ($tc[2] ? $tc[2] : 'blank.gif') . "\" height=\"32\"> {$tc[0]}</a></li>";
			}
		}

		// custom nav links, as defined in "hooks/links-navmenu.php" 
		global $navLinks;
		if(is_array($navLinks)) {
			$memberInfo = getMemberInfo();
			$links_added = [];
			foreach($navLinks as $link) {
				if(!isset($link['url']) || !isset($link['title'])) continue;
				if(getLoggedAdmin() !== false || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])) {
					$menu_index = intval($link['table_group']);
					if(!$links_added[$menu_index]) $menu[$menu_index] .= '<li class="divider"></li>';

					/* add prepend_path to custom links if they aren't absolute links */
					if(!preg_match('/^(http|\/\/)/i', $link['url'])) $link['url'] = $prepend_path . $link['url'];
					if(!preg_match('/^(http|\/\/)/i', $link['icon']) && $link['icon']) $link['icon'] = $prepend_path . $link['icon'];

					$menu[$menu_index] .= "<li><a href=\"{$link['url']}\"><img src=\"" . ($link['icon'] ? $link['icon'] : "{$prepend_path}blank.gif") . "\" height=\"32\"> {$link['title']}</a></li>";
					$links_added[$menu_index]++;
				}
			}
		}

		$menu_wrapper = '';
		for($i = 0; $i < count($menu); $i++) {
			$menu_wrapper .= <<<EOT
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">{$table_group_name[$i]} <b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu">{$menu[$i]}</ul>
				</li>
EOT;
		}

		return $menu_wrapper;
	}

	#########################################################

	function StyleSheet() {
		if(!defined('PREPEND_PATH')) define('PREPEND_PATH', '');
		$prepend_path = PREPEND_PATH;
		$appVersion = (defined('APP_VERSION') ? APP_VERSION : rand());

		$css_links = <<<EOT

			<link rel="stylesheet" href="{$prepend_path}resources/initializr/css/spacelab.css">
			<link rel="stylesheet" href="{$prepend_path}resources/lightbox/css/lightbox.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}resources/select2/select2.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}resources/timepicker/bootstrap-timepicker.min.css" media="screen">
			<link rel="stylesheet" href="{$prepend_path}dynamic.css?{$appVersion}">
EOT;

		return $css_links;
	}

	#########################################################

	function PrepareUploadedFile($FieldName, $MaxSize, $FileTypes = 'jpg|jpeg|gif|png|webp', $NoRename = false, $dir = '') {
		global $Translation;
		$f = $_FILES[$FieldName];
		if($f['error'] == 4 || !$f['name']) return '';

		$dir = getUploadDir($dir);

		/* get php.ini upload_max_filesize in bytes */
		$php_upload_size_limit = toBytes(ini_get('upload_max_filesize'));
		$MaxSize = min($MaxSize, $php_upload_size_limit);

		if($f['size'] > $MaxSize || $f['error']) {
			echo error_message(str_replace(['<MaxSize>', '{MaxSize}'], intval($MaxSize / 1024), $Translation['file too large']));
			exit;
		}
		if(!preg_match('/\.(' . $FileTypes . ')$/i', $f['name'], $ft)) {
			echo error_message(str_replace(['<FileTypes>', '{FileTypes}'], str_replace('|', ', ', $FileTypes), $Translation['invalid file type']));
			exit;
		}

		$name = str_replace(' ', '_', $f['name']);
		if(!$NoRename) $name = substr(md5(microtime() . rand(0, 100000)), -17) . $ft[0];

		if(!file_exists($dir)) @mkdir($dir, 0777);

		if(!@move_uploaded_file($f['tmp_name'], $dir . $name)) {
			echo error_message("Couldn't save the uploaded file. Try chmoding the upload folder '{$dir}' to 777.");
			exit;
		}

		@chmod($dir . $name, 0666);
		return $name;
	}

	#########################################################

	function get_home_links($homeLinks, $default_classes, $tgroup = '') {
		if(!is_array($homeLinks) || !count($homeLinks)) return '';

		$memberInfo = getMemberInfo();

		ob_start();
		foreach($homeLinks as $link) {
			if(!isset($link['url']) || !isset($link['title'])) continue;
			if($tgroup != $link['table_group'] && $tgroup != '*') continue;

			/* fall-back classes if none defined */
			if(!$link['grid_column_classes']) $link['grid_column_classes'] = $default_classes['grid_column'];
			if(!$link['panel_classes']) $link['panel_classes'] = $default_classes['panel'];
			if(!$link['link_classes']) $link['link_classes'] = $default_classes['link'];

			if(getLoggedAdmin() !== false || @in_array($memberInfo['group'], $link['groups']) || @in_array('*', $link['groups'])) {
				?>
				<div class="col-xs-12 <?php echo $link['grid_column_classes']; ?>">
					<div class="panel <?php echo $link['panel_classes']; ?>">
						<div class="panel-body">
							<a class="btn btn-block btn-lg <?php echo $link['link_classes']; ?>" title="<?php echo preg_replace("/&amp;(#[0-9]+|[a-z]+);/i", "&$1;", html_attr(strip_tags($link['description']))); ?>" href="<?php echo $link['url']; ?>"><?php echo ($link['icon'] ? '<img src="' . $link['icon'] . '">' : ''); ?><strong><?php echo $link['title']; ?></strong></a>
							<div class="panel-body-description"><?php echo $link['description']; ?></div>
						</div>
					</div>
				</div>
				<?php
			}
		}

		return ob_get_clean();
	}

	#########################################################

	function quick_search_html($search_term, $label, $separate_dv = true) {
		global $Translation;

		$safe_search = html_attr($search_term);
		$safe_label = html_attr($label);
		$safe_clear_label = html_attr($Translation['Reset Filters']);

		if($separate_dv) {
			$reset_selection = "document.myform.SelectedID.value = '';";
		} else {
			$reset_selection = "document.myform.writeAttribute('novalidate', 'novalidate');";
		}
		$reset_selection .= ' document.myform.NoDV.value=1; return true;';

		$html = <<<EOT
		<div class="input-group" id="quick-search">
			<input type="text" id="SearchString" name="SearchString" value="{$safe_search}" class="form-control" placeholder="{$safe_label}">
			<span class="input-group-btn">
				<button name="Search_x" value="1" id="Search" type="submit" onClick="{$reset_selection}" class="btn btn-default" title="{$safe_label}"><i class="glyphicon glyphicon-search"></i></button>
				<button name="ClearQuickSearch" value="1" id="ClearQuickSearch" type="submit" onClick="\$j('#SearchString').val(''); {$reset_selection}" class="btn btn-default" title="{$safe_clear_label}"><i class="glyphicon glyphicon-remove-circle"></i></button>
			</span>
		</div>
EOT;
		return $html;
	}

	#########################################################

