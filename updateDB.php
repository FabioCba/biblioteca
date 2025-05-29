<?php
	// check this file's MD5 to make sure it wasn't called before
	$tenantId = Authentication::tenantIdPadded();
	$setupHash = __DIR__ . "/setup{$tenantId}.md5";

	$prevMD5 = @file_get_contents($setupHash);
	$thisMD5 = md5_file(__FILE__);

	// check if this setup file already run
	if($thisMD5 != $prevMD5) {
		// set up tables
		setupTable(
			'Estado_Conservacion', " 
			CREATE TABLE IF NOT EXISTS `Estado_Conservacion` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Descripcion` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Estado_Prestable', " 
			CREATE TABLE IF NOT EXISTS `Estado_Prestable` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Descripcion` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Registros', " 
			CREATE TABLE IF NOT EXISTS `Registros` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Codigo_de_Registro` VARCHAR(40) NULL,
				`Codigo_Barras` VARCHAR(50) NULL,
				`id_Estado_Conservacion` INT UNSIGNED NULL,
				`id_Estado_Prestable` INT UNSIGNED NULL,
				`Fecha_Regsitro` DATE NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Registros', ['id_Estado_Conservacion','id_Estado_Prestable',]);

		setupTable(
			'Estado_Prestamo', " 
			CREATE TABLE IF NOT EXISTS `Estado_Prestamo` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Descripcion` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Estado_Catalogacion', " 
			CREATE TABLE IF NOT EXISTS `Estado_Catalogacion` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Descripcion` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Editoriales', " 
			CREATE TABLE IF NOT EXISTS `Editoriales` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Nombre` VARCHAR(50) NULL,
				`Direccion` VARCHAR(200) NULL,
				`Telefono` VARCHAR(50) NULL,
				`Correo` VARCHAR(100) NULL,
				`Contacto` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Catalogo', " 
			CREATE TABLE IF NOT EXISTS `Catalogo` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Portada` VARCHAR(50) NULL,
				`Codigo_Registro` INT UNSIGNED NULL,
				`Cod_Barras` INT UNSIGNED NULL,
				`Item` VARCHAR(40) NULL,
				`Cod_Ejemplar` VARCHAR(40) NULL,
				`Tipo_Literatura` VARCHAR(50) NULL,
				`Tipo_Documento` INT UNSIGNED NULL,
				`id_Estado_Catalogacion` INT UNSIGNED NULL,
				`Signatura_Topografica` VARCHAR(50) NULL,
				`Id_Autoridad` INT UNSIGNED NULL,
				`Titulo` VARCHAR(250) NULL,
				`Responsabilidades` VARCHAR(250) NULL,
				`Edicion` VARCHAR(50) NULL,
				`Id_Lugar` INT UNSIGNED NULL,
				`id_Editorial` INT UNSIGNED NULL,
				`Fecha_Publicacion` VARCHAR(50) NULL,
				`Desc_Fisica` VARCHAR(100) NULL,
				`Notas` TEXT NULL,
				`Materia_1` INT UNSIGNED NULL,
				`Materia_2` INT UNSIGNED NULL,
				`Materia_3` INT UNSIGNED NULL,
				`Ejemplares` INT NULL,
				`Fecha_Catalogacion` DATE NULL
			) CHARSET utf8mb4", [
				" ALTER TABLE `Catalogo` CHANGE `Item` `Item` VARCHAR(40) NULL ",
			]
		);
		setupIndexes('Catalogo', ['Codigo_Registro','Tipo_Documento','id_Estado_Catalogacion','Id_Autoridad','Id_Lugar','id_Editorial','Materia_1','Materia_2','Materia_3',]);

		setupTable(
			'Circulacion', " 
			CREATE TABLE IF NOT EXISTS `Circulacion` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`id_Usuario` INT UNSIGNED NULL,
				`Foto_Usuario` INT UNSIGNED NULL,
				`id_Tipo_usuario` INT UNSIGNED NULL,
				`id_Politica_pretamo` INT UNSIGNED NULL,
				`id_Tipo_documento` INT UNSIGNED NULL,
				`id_Registro` INT UNSIGNED NULL,
				`Libro_Prestado` INT UNSIGNED NULL,
				`Portada_libro` INT UNSIGNED NULL,
				`Fecha_Prestamo` DATE NULL,
				`Fecha_Devolucion` DATE NULL,
				`id_Estado_prestamo` INT UNSIGNED NULL,
				`Cantidad` INT NULL,
				`Ejemp_Disponibles` INT UNSIGNED NULL,
				`Item` INT UNSIGNED NULL,
				`Cod_Ejemplar` INT UNSIGNED NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Circulacion', ['id_Usuario','id_Tipo_usuario','id_Politica_pretamo','id_Tipo_documento','Libro_Prestado','id_Estado_prestamo','Cod_Ejemplar',]);

		setupTable(
			'Tipo_Documento', " 
			CREATE TABLE IF NOT EXISTS `Tipo_Documento` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Descripcion` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Autoridades', " 
			CREATE TABLE IF NOT EXISTS `Autoridades` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Foto` VARCHAR(50) NULL,
				`id_Tipo_autoridad` INT UNSIGNED NULL,
				`Nombre` VARCHAR(150) NULL,
				`Fecha_Extrema` VARCHAR(50) NULL,
				`Vease_Ademas` VARCHAR(200) NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Autoridades', ['id_Tipo_autoridad',]);

		setupTable(
			'Estado_Suscripcion', " 
			CREATE TABLE IF NOT EXISTS `Estado_Suscripcion` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Descripcion` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Usuarios', " 
			CREATE TABLE IF NOT EXISTS `Usuarios` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Foto` VARCHAR(50) NULL,
				`id_Tipo_usuario` INT UNSIGNED NULL,
				`Apellidos` VARCHAR(50) NULL,
				`Nombres` VARCHAR(50) NULL,
				`Correo` VARCHAR(100) NULL,
				`Telefono` VARCHAR(50) NULL,
				`id_Estado_suscripcion` INT UNSIGNED NULL,
				`Fecha_Registro` DATE NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Usuarios', ['id_Tipo_usuario','id_Estado_suscripcion',]);

		setupTable(
			'Politica_de_Prestamos', " 
			CREATE TABLE IF NOT EXISTS `Politica_de_Prestamos` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`id_Tipo_usuario` INT UNSIGNED NULL,
				`id_Tipo_documento` INT UNSIGNED NULL,
				`Duracion_Prestamo` INT NULL,
				`Lim_Doc_Presado` INT NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Politica_de_Prestamos', ['id_Tipo_usuario','id_Tipo_documento',]);

		setupTable(
			'Lugares', " 
			CREATE TABLE IF NOT EXISTS `Lugares` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Descripcion` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Tipo_Autoridad', " 
			CREATE TABLE IF NOT EXISTS `Tipo_Autoridad` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Descripcion` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Tipo_Usuario', " 
			CREATE TABLE IF NOT EXISTS `Tipo_Usuario` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Descripcion` VARCHAR(50) NULL,
				`Lim_Doc_Prestado` INT NULL,
				`Lim_Doc_Reserva` INT NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Materias', " 
			CREATE TABLE IF NOT EXISTS `Materias` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Descriptor` VARCHAR(250) NULL
			) CHARSET utf8mb4"
		);

		setupTable(
			'Itemes', " 
			CREATE TABLE IF NOT EXISTS `Itemes` ( 
				`id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				PRIMARY KEY (`id`),
				`Cod_item` INT UNSIGNED NULL,
				`Estado_Conservacion` INT UNSIGNED NULL,
				`Num_Copia` VARCHAR(50) NULL,
				`Cod_Ejemplar` VARCHAR(50) NULL,
				`Estado_de_Baja` VARCHAR(50) NULL
			) CHARSET utf8mb4"
		);
		setupIndexes('Itemes', ['Cod_item','Estado_Conservacion',]);



		// save MD5
		@file_put_contents($setupHash, $thisMD5);
	}


	function setupIndexes($tableName, $arrFields) {
		if(!is_array($arrFields) || !count($arrFields)) return false;

		foreach($arrFields as $fieldName) {
			if(!$res = @db_query("SHOW COLUMNS FROM `$tableName` like '$fieldName'")) continue;
			if(!$row = @db_fetch_assoc($res)) continue;
			if($row['Key']) continue;

			@db_query("ALTER TABLE `$tableName` ADD INDEX `$fieldName` (`$fieldName`)");
		}
	}


	function setupTable($tableName, $createSQL = '', $arrAlter = '') {
		global $Translation;
		$oldTableName = '';
		ob_start();

		echo '<div style="padding: 5px; border-bottom:solid 1px silver; font-family: verdana, arial; font-size: 10px;">';

		// is there a table rename query?
		if(is_array($arrAlter)) {
			$matches = [];
			if(preg_match("/ALTER TABLE `(.*)` RENAME `$tableName`/i", $arrAlter[0], $matches)) {
				$oldTableName = $matches[1];
			}
		}

		if($res = @db_query("SELECT COUNT(1) FROM `$tableName`")) { // table already exists
			if($row = @db_fetch_array($res)) {
				echo str_replace(['<TableName>', '<NumRecords>'], [$tableName, $row[0]], $Translation['table exists']);
				if(is_array($arrAlter)) {
					echo '<br>';
					foreach($arrAlter as $alter) {
						if($alter != '') {
							echo "$alter ... ";
							if(!@db_query($alter)) {
								echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
								echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
							} else {
								echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
							}
						}
					}
				} else {
					echo $Translation['table uptodate'];
				}
			} else {
				echo str_replace('<TableName>', $tableName, $Translation['couldnt count']);
			}
		} else { // given tableName doesn't exist

			if($oldTableName != '') { // if we have a table rename query
				if($ro = @db_query("SELECT COUNT(1) FROM `$oldTableName`")) { // if old table exists, rename it.
					$renameQuery = array_shift($arrAlter); // get and remove rename query

					echo "$renameQuery ... ";
					if(!@db_query($renameQuery)) {
						echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
						echo '<div class="text-danger">' . $Translation['mysql said'] . ' ' . db_error(db_link()) . '</div>';
					} else {
						echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
					}

					if(is_array($arrAlter)) setupTable($tableName, $createSQL, false, $arrAlter); // execute Alter queries on renamed table ...
				} else { // if old tableName doesn't exist (nor the new one since we're here), then just create the table.
					setupTable($tableName, $createSQL, false); // no Alter queries passed ...
				}
			} else { // tableName doesn't exist and no rename, so just create the table
				echo str_replace("<TableName>", $tableName, $Translation["creating table"]);
				if(!@db_query($createSQL)) {
					echo '<span class="label label-danger">' . $Translation['failed'] . '</span>';
					echo '<div class="text-danger">' . $Translation['mysql said'] . db_error(db_link()) . '</div>';

					// create table with a dummy field
					@db_query("CREATE TABLE IF NOT EXISTS `$tableName` (`_dummy_deletable_field` TINYINT)");
				} else {
					echo '<span class="label label-success">' . $Translation['ok'] . '</span>';
				}
			}

			// set Admin group permissions for newly created table if membership_grouppermissions exists
			if($ro = @db_query("SELECT COUNT(1) FROM `membership_grouppermissions`")) {
				// get Admins group id
				$ro = @db_query("SELECT `groupID` FROM `membership_groups` WHERE `name`='Admins'");
				if($ro) {
					$adminGroupID = intval(db_fetch_row($ro)[0]);
					if($adminGroupID) @db_query("INSERT IGNORE INTO `membership_grouppermissions` SET
						`groupID`='$adminGroupID',
						`tableName`='$tableName',
						`allowInsert`=1, `allowView`=1, `allowEdit`=1, `allowDelete`=1
					");
				}
			}
		}

		echo '</div>';

		$out = ob_get_clean();
		if(defined('APPGINI_SETUP') && APPGINI_SETUP) echo $out;
	}
