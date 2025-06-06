<?php
	########################################################################
	/*
	~~~~~~ LIST OF FUNCTIONS ~~~~~~
		set_headers() -- sets HTTP headers (encoding, same-origin frame policy, .. etc)
		getTableList() -- returns an associative array [tableName => [tableCaption, tableDescription, tableIcon], ...] of tables accessible by current user
		getThumbnailSpecs($tableName, $fieldName, $view) -- returns an associative array specifying the width, height and identifier of the thumbnail file.
		createThumbnail($img, $specs) -- $specs is an array as returned by getThumbnailSpecs(). Returns true on success, false on failure.
		makeSafe($string)
		checkPermissionVal($pvn)
		sql($statement, $o)
		sqlValue($statement)
		getLoggedAdmin()
		logOutUser()
		getPKFieldName($tn)
		getCSVData($tn, $pkValue, $stripTag=true)
		errorMsg($msg)
		redirect($URL, $absolute=FALSE)
		htmlRadioGroup($name, $arrValue, $arrCaption, $selectedValue, $selClass="", $class="", $separator="<br>")
		htmlSelect($name, $arrValue, $arrCaption, $selectedValue, $class="", $selectedClass="")
		htmlSQLSelect($name, $sql, $selectedValue, $class="", $selectedClass="")
		isEmail($email) -- returns $email if valid or false otherwise.
		notifyMemberApproval($memberID) -- send an email to member acknowledging his approval by admin, returns false if no mail is sent
		setupMembership() -- check if membership tables exist or not. If not, create them.
		thisOr($this_val, $or) -- return $this_val if it has a value, or $or if not.
		getUploadedFile($FieldName, $MaxSize=0, $FileTypes='csv|txt', $NoRename=false, $dir='')
		toBytes($val)
		convertLegacyOptions($CSVList)
		getValueGivenCaption($query, $caption)
		time24($t) -- return time in 24h format
		time12($t) -- return time in 12h format
		application_url($page) -- return absolute URL of provided page
		is_ajax() -- return true if this is an ajax request, false otherwise
		is_allowed_username($username, $exception = false) -- returns username if valid and unique, or false otherwise (if exception is provided and same as username, no uniqueness check is performed)
		csrf_token($validate) -- csrf-proof a form
		get_plugins() -- scans for installed plugins and returns them in an array ('name', 'title', 'icon' or 'glyphicon', 'admin_path')
		maintenance_mode($new_status = '') -- retrieves (and optionally sets) maintenance mode status
		html_attr($str) -- prepare $str to be placed inside an HTML attribute
		html_attr_tags_ok($str) -- same as html_attr, but allowing HTML tags
		Notification() -- class for providing a standardized html notifications functionality
		sendmail($mail) -- sends an email using PHPMailer as specified in the assoc array $mail( ['to', 'name', 'subject', 'message', 'debug'] ) and returns true on success or an error message on failure
		safe_html($str, $noBr = false) -- sanitize HTML strings, and apply nl2br() to non-HTML ones (unless optional 2nd param is passed as true)
		get_tables_info($skip_authentication = false) -- retrieves table properties as a 2D assoc array ['table_name' => ['prop1' => 'val', ..], ..]
		getLoggedMemberID() -- returns memberID of logged member. If no login, returns anonymous memberID
		getLoggedGroupID() -- returns groupID of logged member, or anonymous groupID
		getMemberInfo() -- returns an array containing the currently signed-in member's info
		get_group_id($user = '') -- returns groupID of given user, or current one if empty
		prepare_sql_set($set_array, $glue = ', ') -- Prepares data for a SET or WHERE clause, to be used in an INSERT/UPDATE query
		insert($tn, $set_array) -- Inserts a record specified by $set_array to the given table $tn
		update($tn, $set_array, $where_array) -- Updates a record identified by $where_array to date specified by $set_array in the given table $tn
		set_record_owner($tn, $pk, $user) -- Set/update the owner of given record
		app_datetime_format($destination = 'php', $datetime = 'd') -- get date/time format string for use with one of these: 'php' (see date function), 'mysql', 'moment'. $datetime: 'd' = date, 't' = time, 'dt' = both
		mysql_datetime($app_datetime) -- converts $app_datetime to mysql-formatted datetime, 'yyyy-mm-dd H:i:s', or empty string on error
		app_datetime($mysql_datetime, $datetime = 'd') -- converts $mysql_datetime to app-formatted datetime (if 2nd param is 'dt'), or empty string on error
		to_utf8($str) -- converts string from app-configured encoding to utf8
		from_utf8($str) -- converts string from utf8 to app-configured encoding
		membership_table_functions() -- returns a list of update_membership_* functions
		configure_anonymous_group() -- sets up anonymous group and guest user if necessary
		configure_admin_group() -- sets up admins group and super admin user if necessary
		get_table_keys($tn) -- returns keys (indexes) of given table
		get_table_fields($tn) -- returns fields spec for given table
		update_membership_{tn}() -- sets up membership table tn and its indexes if necessary
		test($subject, $test) -- perform a test and return results
		invoke_method($object, $methodName, $param_array) -- invoke a private/protected method of a given object
		invoke_static_method($class, $methodName, $param_array) -- invoke a private/protected method of a given class statically
		get_parent_tables($tn) -- returns parents of given table: ['parent table' => [main lookup fields in child], ..]
		backtick_keys_once($data) -- wraps keys of given array with backticks ` if not already wrapped. Useful for use with fieldnames passed to update() and insert()
		calculated_fields() -- returns calculated fields config array: [table => [field => query, ..], ..]
		update_calc_fields($table, $id, $formulas, $mi = false) -- updates record of given $id in given $table according to given $formulas on behalf of user specified in given info array (or current user if false)
		latest_jquery() -- detects and returns the name of the latest jQuery file found in resources/jquery/js
		existing_value($tn, $fn, $id, $cache = true) -- returns (cached) value of field $fn of record having $id in table $tn. Set $cache to false to bypass caching.
		checkAppRequirements() -- if PHP doesn't meet app requirements, outputs error and exits
		getRecord($table, $id) -- return the record having a PK of $id from $table as an associative array, falsy value on error/not found
		guessMySQLDateTime($dt) -- if $dt is not already a mysql date/datetime, use mysql_datetime() to convert then return mysql date/datetime. Returns false if $dt invalid or couldn't be detected.
		pkGivenLookupText($val, $tn, $lookupField, $falseIfNotFound) -- returns corresponding PK value for given $val which is the textual lookup value for given $lookupField in given $tn table. If $val has no corresponding PK value, $val is returned as-is, unless $falseIfNotFound is set to true, in which case false is returned.
		userCanImport() -- returns true if user (or his group) can import CSV files (through the permission set in the group page in the admin area).
		bgStyleToClass($html) -- replaces bg color 'style' attr with a class to prevent style loss on xss cleanup.
		assocArrFilter($arr, $func) -- filters provided array using provided callback function. The callback receives 2 params ($key, $value) and should return a boolean.
		array_trim($arr) -- deep trim; trim each element in the array and its sub arrays.
		request_outside_admin_folder() -- returns true if currently executing script is outside admin folder, false otherwise.
		breakpoint(__FILE__, __LINE__, $msg) -- if DEBUG_MODE enabled, logs a message to {app_dir}/breakpoint.csv, if $msg is array, it will be converted to str via json_encode
		denyAccess($msg) -- Send a 403 Access Denied header, with an optional message then die
	~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	*/
	########################################################################
	function set_headers() {
		@header('Content-Type: text/html; charset=' . datalist_db_encoding);
		@header('X-Frame-Options: SAMEORIGIN'); // prevent iframing by other sites to prevent clickjacking
	}
	########################################################################
	function get_tables_info($skip_authentication = false) {
		static $all_tables = [], $accessible_tables = [];

		/* return cached results, if found */
		if(($skip_authentication || getLoggedAdmin()) && count($all_tables)) return $all_tables;
		if(!$skip_authentication && count($accessible_tables)) return $accessible_tables;

		/* table groups */
		$tg = [
			'Catalogaci&#243;n',
			'Gesti&#243;n de Pr&#233;stamos',
			'Autoridades',
			'Tablas Auxiliares'
		];

		$all_tables = [
			/* ['table_name' => [table props assoc array] */   
				'Estado_Conservacion' => [
					'Caption' => 'Estado Conservacion',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/application_from_storage.png',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'Estado_Prestable' => [
					'Caption' => 'Estado Prestable',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/application_key.png',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'Registros' => [
					'Caption' => 'Registros',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/application_form_edit.png',
					'group' => $tg[0],
					'homepageShowCount' => 1
				],
				'Estado_Prestamo' => [
					'Caption' => 'Estado Prestamo',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/application_edit.png',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'Estado_Catalogacion' => [
					'Caption' => 'Estado Catalogacion',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/application_view_tile.png',
					'group' => $tg[0],
					'homepageShowCount' => 1
				],
				'Editoriales' => [
					'Caption' => 'Editoriales',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/entity.png',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'Catalogo' => [
					'Caption' => 'Catalogo',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/book_add.png',
					'group' => $tg[0],
					'homepageShowCount' => 1
				],
				'Circulacion' => [
					'Caption' => 'Circulacion',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/arrow_refresh.png',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'Tipo_Documento' => [
					'Caption' => 'Tipo Documento',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/attributes_display.png',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'Autoridades' => [
					'Caption' => 'Autoridades',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/administrator.png',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'Estado_Suscripcion' => [
					'Caption' => 'Estado Suscripcion',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/brick_edit.png',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'Usuarios' => [
					'Caption' => 'Registro de Usuarios',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/user_add.png',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'Politica_de_Prestamos' => [
					'Caption' => 'Politica de Prestamos',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/accept.png',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'Lugares' => [
					'Caption' => 'Lugares',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/house_go.png',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'Tipo_Autoridad' => [
					'Caption' => 'Tipo Autoridad',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/user_edit.png',
					'group' => $tg[2],
					'homepageShowCount' => 1
				],
				'Tipo_Usuario' => [
					'Caption' => 'Tipo Usuario',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/folder_user.png',
					'group' => $tg[1],
					'homepageShowCount' => 1
				],
				'Materias' => [
					'Caption' => 'Materias',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/advanced_data_grid.png',
					'group' => $tg[3],
					'homepageShowCount' => 1
				],
				'Itemes' => [
					'Caption' => 'Itemes',
					'Description' => '',
					'tableIcon' => 'resources/table_icons/book_add.png',
					'group' => $tg[0],
					'homepageShowCount' => 1
				],
		];

		if($skip_authentication || getLoggedAdmin()) return $all_tables;

		foreach($all_tables as $tn => $ti) {
			$arrPerm = getTablePermissions($tn);
			if($arrPerm['access']) $accessible_tables[$tn] = $ti;
		}

		return $accessible_tables;
	}
	#########################################################
	function getTableList($skip_authentication = false) {
		$arrAccessTables = [];
		$arrTables = [
			/* 'table_name' => ['table caption', 'homepage description', 'icon', 'table group name'] */   
			'Estado_Conservacion' => ['Estado Conservacion', '', 'resources/table_icons/application_from_storage.png', 'Tablas Auxiliares'],
			'Estado_Prestable' => ['Estado Prestable', '', 'resources/table_icons/application_key.png', 'Gesti&#243;n de Pr&#233;stamos'],
			'Registros' => ['Registros', '', 'resources/table_icons/application_form_edit.png', 'Catalogaci&#243;n'],
			'Estado_Prestamo' => ['Estado Prestamo', '', 'resources/table_icons/application_edit.png', 'Gesti&#243;n de Pr&#233;stamos'],
			'Estado_Catalogacion' => ['Estado Catalogacion', '', 'resources/table_icons/application_view_tile.png', 'Catalogaci&#243;n'],
			'Editoriales' => ['Editoriales', '', 'resources/table_icons/entity.png', 'Tablas Auxiliares'],
			'Catalogo' => ['Catalogo', '', 'resources/table_icons/book_add.png', 'Catalogaci&#243;n'],
			'Circulacion' => ['Circulacion', '', 'resources/table_icons/arrow_refresh.png', 'Gesti&#243;n de Pr&#233;stamos'],
			'Tipo_Documento' => ['Tipo Documento', '', 'resources/table_icons/attributes_display.png', 'Tablas Auxiliares'],
			'Autoridades' => ['Autoridades', '', 'resources/table_icons/administrator.png', 'Autoridades'],
			'Estado_Suscripcion' => ['Estado Suscripcion', '', 'resources/table_icons/brick_edit.png', 'Gesti&#243;n de Pr&#233;stamos'],
			'Usuarios' => ['Registro de Usuarios', '', 'resources/table_icons/user_add.png', 'Gesti&#243;n de Pr&#233;stamos'],
			'Politica_de_Prestamos' => ['Politica de Prestamos', '', 'resources/table_icons/accept.png', 'Gesti&#243;n de Pr&#233;stamos'],
			'Lugares' => ['Lugares', '', 'resources/table_icons/house_go.png', 'Tablas Auxiliares'],
			'Tipo_Autoridad' => ['Tipo Autoridad', '', 'resources/table_icons/user_edit.png', 'Autoridades'],
			'Tipo_Usuario' => ['Tipo Usuario', '', 'resources/table_icons/folder_user.png', 'Gesti&#243;n de Pr&#233;stamos'],
			'Materias' => ['Materias', '', 'resources/table_icons/advanced_data_grid.png', 'Tablas Auxiliares'],
			'Itemes' => ['Itemes', '', 'resources/table_icons/book_add.png', 'Catalogaci&#243;n'],
		];
		if($skip_authentication || getLoggedAdmin()) return $arrTables;

		foreach($arrTables as $tn => $tc) {
			$arrPerm = getTablePermissions($tn);
			if($arrPerm['access']) $arrAccessTables[$tn] = $tc;
		}

		return $arrAccessTables;
	}
	########################################################################
	function getThumbnailSpecs($tableName, $fieldName, $view) {
		if($tableName=='Catalogo' && $fieldName=='Portada' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='Catalogo' && $fieldName=='Portada' && $view=='dv')
			return ['width'=>300, 'height'=>300, 'identifier'=>'_dv'];
		elseif($tableName=='Autoridades' && $fieldName=='Foto' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='Autoridades' && $fieldName=='Foto' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		elseif($tableName=='Usuarios' && $fieldName=='Foto' && $view=='tv')
			return ['width'=>50, 'height'=>50, 'identifier'=>'_tv'];
		elseif($tableName=='Usuarios' && $fieldName=='Foto' && $view=='dv')
			return ['width'=>250, 'height'=>250, 'identifier'=>'_dv'];
		return FALSE;
	}
	########################################################################
	function createThumbnail($img, $specs) {
		$w = $specs['width'];
		$h = $specs['height'];
		$id = $specs['identifier'];
		$path = dirname($img);

		// image doesn't exist or inaccessible?
		// known issue: for webp files, requires PHP 7.1+
		if(!$size = @getimagesize($img)) return false;

		// calculate thumbnail size to maintain aspect ratio
		$ow = $size[0]; // original image width
		$oh = $size[1]; // original image height
		$twbh = $h / $oh * $ow; // calculated thumbnail width based on given height
		$thbw = $w / $ow * $oh; // calculated thumbnail height based on given width
		if($w && $h) {
			if($twbh > $w) $h = $thbw;
			if($thbw > $h) $w = $twbh;
		} elseif($w) {
			$h = $thbw;
		} elseif($h) {
			$w = $twbh;
		} else {
			return false;
		}

		// dir not writeable?
		if(!is_writable($path)) return false;

		// GD lib not loaded?
		if(!function_exists('gd_info')) return false;
		$gd = gd_info();

		// GD lib older than 2.0?
		preg_match('/\d/', $gd['GD Version'], $gdm);
		if($gdm[0] < 2) return false;

		// get file extension
		preg_match('/\.[a-zA-Z]{3,4}$/U', $img, $matches);
		$ext = strtolower($matches[0]);

		// check if supplied image is supported and specify actions based on file type
		if($ext == '.gif') {
			if(!$gd['GIF Create Support']) return false;
			$thumbFunc = 'imagegif';
		} elseif($ext == '.png') {
			if(!$gd['PNG Support'])  return false;
			$thumbFunc = 'imagepng';
		} elseif($ext == '.webp') {
			if(!$gd['WebP Support'] && !$gd['WEBP Support'])  return false;
			$thumbFunc = 'imagewebp';
		} elseif($ext == '.jpg' || $ext == '.jpe' || $ext == '.jpeg') {
			if(!$gd['JPG Support'] && !$gd['JPEG Support'])  return false;
			$thumbFunc = 'imagejpeg';
		} else {
			return false;
		}

		// determine thumbnail file name
		$ext = $matches[0];
		$thumb = substr($img, 0, -5) . str_replace($ext, $id . $ext, substr($img, -5));

		// if the original image smaller than thumb, then just copy it to thumb
		if($h > $oh && $w > $ow) {
			return (@copy($img, $thumb) ? true : false);
		}

		// get image data
		if(
			$thumbFunc == 'imagewebp'
			&& !$imgData = imagecreatefromwebp($img)
		)
			return false;
		elseif(!$imgData = imagecreatefromstring(file_get_contents($img)))
			return false;

		// finally, create thumbnail
		$thumbData = imagecreatetruecolor($w, $h);

		//preserve transparency of png and gif images
		$transIndex = null;
		if($thumbFunc == 'imagepng' || $thumbFunc == 'imagewebp') {
			if(($clr = @imagecolorallocate($thumbData, 0, 0, 0)) != -1) {
				@imagecolortransparent($thumbData, $clr);
				@imagealphablending($thumbData, false);
				@imagesavealpha($thumbData, true);
			}
		} elseif($thumbFunc == 'imagegif') {
			@imagealphablending($thumbData, false);
			$transIndex = imagecolortransparent($imgData);
			if($transIndex >= 0) {
				$transClr = imagecolorsforindex($imgData, $transIndex);
				$transIndex = imagecolorallocatealpha($thumbData, $transClr['red'], $transClr['green'], $transClr['blue'], 127);
				imagefill($thumbData, 0, 0, $transIndex);
			}
		}

		// resize original image into thumbnail
		if(!imagecopyresampled($thumbData, $imgData, 0, 0 , 0, 0, $w, $h, $ow, $oh)) return false;
		unset($imgData);

		// gif transparency
		if($thumbFunc == 'imagegif' && $transIndex >= 0) {
			imagecolortransparent($thumbData, $transIndex);
			for($y = 0; $y < $h; ++$y)
				for($x = 0; $x < $w; ++$x)
					if(((imagecolorat($thumbData, $x, $y) >> 24) & 0x7F) >= 100) imagesetpixel($thumbData, $x, $y, $transIndex);
			imagetruecolortopalette($thumbData, true, 255);
			imagesavealpha($thumbData, false);
		}

		if(!$thumbFunc($thumbData, $thumb)) return false;
		unset($thumbData);

		return true;
	}
	########################################################################
	function makeSafe($string, $is_gpc = true) {
		static $cached = []; /* str => escaped_str */

		if(!strlen($string)) return '';

		if(!db_link()) sql("SELECT 1+1", $eo);

		// if this is a previously escaped string, return from cached
		// checking both keys and values
		if(isset($cached[$string])) return $cached[$string];
		$key = array_search($string, $cached);
		if($key !== false) return $string; // already an escaped string

		$cached[$string] = db_escape($string);
		return $cached[$string];
	}
	########################################################################
	function checkPermissionVal($pvn) {
		// fn to make sure the value in the given POST variable is 0, 1, 2 or 3
		// if the value is invalid, it default to 0
		$pvn = intval(Request::val($pvn));
		if($pvn != 1 && $pvn != 2 && $pvn != 3) {
			return 0;
		} else {
			return $pvn;
		}
	}
	########################################################################
	function dieErrorPage($error) {
		global $Translation;

		$header = (defined('ADMIN_AREA') ? __DIR__ . '/incHeader.php' : __DIR__ . '/../header.php');
		$footer = (defined('ADMIN_AREA') ? __DIR__ . '/incFooter.php' : __DIR__ . '/../footer.php');

		ob_start();

		@include_once($header);
		echo Notification::placeholder();
		echo Notification::show([
			'message' => $error,
			'class' => 'danger',
			'dismiss_seconds' => 7200
		]);
		@include_once($footer);

		echo ob_get_clean();
		exit;
	}
	########################################################################
	function openDBConnection(&$o) {
		static $connected = false, $db_link;

		$dbServer = config('dbServer');
		$dbUsername = config('dbUsername');
		$dbPassword = config('dbPassword');
		$dbDatabase = config('dbDatabase');
		$dbPort = config('dbPort');

		if($connected) return $db_link;

		/****** Check that MySQL module is enabled ******/
		if(!extension_loaded('mysql') && !extension_loaded('mysqli')) {
			$o['error'] = 'PHP is not configured to connect to MySQL on this machine. Please see <a href="https://www.php.net/manual/en/ref.mysql.php">this page</a> for help on how to configure MySQL.';
			if(!empty($o['silentErrors'])) return false;

			dieErrorPage($o['error']);
		}

		/****** Connect to MySQL ******/
		if(!($db_link = @db_connect($dbServer, $dbUsername, $dbPassword, NULL, $dbPort))) {
			$o['error'] = db_error($db_link, true);
			if(!empty($o['silentErrors'])) return false;

			dieErrorPage($o['error']);
		}

		/****** Select DB ********/
		if(!db_select_db($dbDatabase, $db_link)) {
			$o['error'] = db_error($db_link);
			if(!empty($o['silentErrors'])) return false;

			dieErrorPage($o['error']);
		}

		$connected = true;
		return $db_link;
	}
	########################################################################
	function sql($statement, &$o) {

		/*
			Supported options that can be passed in $o options array (as array keys):
			'silentErrors': If true, errors will be returned in $o['error'] rather than displaying them on screen and exiting.
			'noSlowQueryLog': don't log slow query if true
			'noErrorQueryLog': don't log error query if true
		*/

		global $Translation;

		$db_link = openDBConnection($o);

		/*
		 if openDBConnection() fails, it would abort execution unless 'silentErrors' is true,
		 in which case, we should return false from sql() without further action since
		 $o['error'] would be already set by openDBConnection()
		*/
		if(!$db_link) return false;

		$t0 = microtime(true);

		if(!$result = @db_query($statement, $db_link)) {
			if(!stristr($statement, "show columns")) {
				// retrieve error codes
				$errorNum = db_errno($db_link);
				$o['error'] = db_error($db_link);

				if(empty($o['noErrorQueryLog']))
					logErrorQuery($statement, $o['error']);

				if(getLoggedAdmin())
					$o['error'] = htmlspecialchars($o['error']) . 
						"<pre class=\"ltr\">{$Translation['query:']}\n" . htmlspecialchars($statement) . '</pre>' .
						"<p><i class=\"text-right\">{$Translation['admin-only info']}</i></p>" .
						"<p><a href=\"" . application_url('admin/pageRebuildFields.php') . "\">{$Translation['try rebuild fields']}</a></p>";

				if(!empty($o['silentErrors'])) return false;

				dieErrorPage($o['error']);
			}
		}

		/* log slow queries that take more than 1 sec */
		$t1 = microtime(true);
		if(($t1 - $t0) > 1.0 && empty($o['noSlowQueryLog']))
			logSlowQuery($statement, $t1 - $t0);

		return $result;
	}
	########################################################################
	function logSlowQuery($statement, $duration) {
		if(!createQueryLogTable()) return;

		$o = [
			'silentErrors' => true,
			'noSlowQueryLog' => true,
			'noErrorQueryLog' => true
		];
		$statement = makeSafe(trim(preg_replace('/^\s+/m', ' ', $statement)));
		$duration = floatval($duration);
		$memberID = makeSafe(getLoggedMemberID());
		$uri = makeSafe($_SERVER['REQUEST_URI']);

		sql("INSERT INTO `appgini_query_log` SET
			`statement`='$statement',
			`duration`=$duration,
			`memberID`='$memberID',
			`uri`='$uri'
		", $o);
	}
	########################################################################
	function logErrorQuery($statement, $error) {
		if(!createQueryLogTable()) return;

		$o = [
			'silentErrors' => true,
			'noSlowQueryLog' => true,
			'noErrorQueryLog' => true
		];
		$statement = makeSafe(trim(preg_replace('/^\s+/m', ' ', $statement)));
		$error = makeSafe($error);
		$memberID = makeSafe(getLoggedMemberID());
		$uri = makeSafe($_SERVER['REQUEST_URI']);

		sql("INSERT INTO `appgini_query_log` SET
			`statement`='$statement',
			`error`='$error',
			`memberID`='$memberID',
			`uri`='$uri'
		", $o);
	}

	########################################################################
	function createQueryLogTable() {
		static $created = false;
		if($created) return true;

		$o = [
			'silentErrors' => true,
			'noSlowQueryLog' => true,
			'noErrorQueryLog' => true
		];

		sql("CREATE TABLE IF NOT EXISTS `appgini_query_log` (
			`datetime` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
			`statement` LONGTEXT,
			`duration` DECIMAL(10,2) UNSIGNED DEFAULT 0.0,
			`error` TEXT,
			`memberID` VARCHAR(200),
			`uri` VARCHAR(200)
		) CHARSET " . mysql_charset, $o);

		// check if table created
		//$o2 = $o;
		//$o2['error'] = '';
		//sql("SELECT COUNT(1) FROM 'appgini_query_log'", $o2);

		//$created = empty($o2['error']);

		$created = true;
		return $created;
	}

	########################################################################
	function sqlValue($statement, &$error = NULL) {
		// executes a statement that retreives a single data value and returns the value retrieved
		$eo = ['silentErrors' => true];
		if(!$res = sql($statement, $eo)) { $error = $eo['error']; return false; }
		if(!$row = db_fetch_row($res)) return false;
		return $row[0];
	}
	########################################################################
	function getLoggedAdmin() {
		return Authentication::getAdmin();
	}
	########################################################################
	function initSession() {
		Authentication::initSession();
	}
	########################################################################
	function jwt_key() {
		if(!is_file(configFileName())) return false;
		return md5_file(configFileName());
	}
	########################################################################
	function jwt_token($user = false) {
		if($user === false) {
			$mi = Authentication::getUser();
			if(!$mi) return false;

			$user = $mi['memberId'];
		}

		$key = jwt_key();
		if($key === false) return false;
		return JWT::encode(['user' => $user], $key);
	}
	########################################################################
	function jwt_header() {
		/* adapted from https://stackoverflow.com/a/40582472/1945185 */
		$auth_header = null;
		if(isset($_SERVER['Authorization'])) {
			$auth_header = trim($_SERVER['Authorization']);
		} elseif(isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$auth_header = trim($_SERVER['HTTP_AUTHORIZATION']);
		} elseif(isset($_SERVER['HTTP_X_AUTHORIZATION'])) { //hack if all else fails
			$auth_header = trim($_SERVER['HTTP_X_AUTHORIZATION']);
		} elseif(function_exists('apache_request_headers')) {
			$rh = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$rh = array_combine(array_map('ucwords', array_keys($rh)), array_values($rh));
			if(isset($rh['Authorization'])) {
				$auth_header = trim($rh['Authorization']);
			} elseif(isset($rh['X-Authorization'])) {
				$auth_header = trim($rh['X-Authorization']);
			}
		}

		if(!empty($auth_header)) {
			if(preg_match('/Bearer\s(\S+)/', $auth_header, $matches)) return $matches[1];
		}

		return null;
	}
	########################################################################
	function jwt_check_login() {
		// do we have an Authorization Bearer header?
		$token = jwt_header();
		if(!$token) return false;

		$key = jwt_key();
		if($key === false) return false;

		$error = '';
		$payload = JWT::decode($token, $key, $error);
		if(empty($payload['user'])) return false;

		Authentication::signInAs($payload['user']);

		// for API calls that just trigger an action and then close connection, 
		// we need to continue running
		@ignore_user_abort(true);
		@set_time_limit(120);

		return true;
	}
	########################################################################
	function curl_insert_handler($table, $data) {
		if(!function_exists('curl_init')) return false;
		$ch = curl_init();

		$payload = $data;
		$payload['insert_x'] = 1;

		$url = (isset($_SERVER['HTTPS']) ? 'https://' : 'http://') . config('host') . '/' . application_uri("{$table}_view.php");
		$token = jwt_token();
		$options = [
			CURLOPT_URL => $url,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => http_build_query($payload),
			CURLOPT_HTTPHEADER => [
				"User-Agent: {$_SERVER['HTTP_USER_AGENT']}",
				"Accept: {$_SERVER['HTTP_ACCEPT']}",
				"Authorization: Bearer $token",
				"X-Authorization: Bearer $token",
			],
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_RETURNTRANSFER => true,

			/* this is a localhost request so need to verify SSL */
			CURLOPT_SSL_VERIFYPEER => false,

			// the following option allows sending request and then 
			// closing the connection without waiting for response
			// see https://stackoverflow.com/a/10895361/1945185
			CURLOPT_TIMEOUT => 8,
		];

		if(defined('CURLOPT_TCP_FASTOPEN')) $options[CURLOPT_TCP_FASTOPEN] = true;
		if(defined('CURLOPT_SAFE_UPLOAD'))
			$options[CURLOPT_SAFE_UPLOAD] = function_exists('curl_file_create');

		// this is safe to use as we're sending a local request
		if(defined('CURLOPT_UNRESTRICTED_AUTH')) $options[CURLOPT_UNRESTRICTED_AUTH] = 1;

		curl_setopt_array($ch, $options);

		return $ch;
	}
	########################################################################
	function curl_batch($handlers) {
		if(!function_exists('curl_init')) return false;
		if(!is_array($handlers)) return false;
		if(!count($handlers)) return false;

		$mh = curl_multi_init();
		if(function_exists('curl_multi_setopt')) {
			curl_multi_setopt($mh, CURLMOPT_PIPELINING, 1);
			curl_multi_setopt($mh, CURLMOPT_MAXCONNECTS, min(20, count($handlers)));
		}

		foreach($handlers as $ch) {
			@curl_multi_add_handle($mh, $ch);
		}

		$active = false;
		do {
			@curl_multi_exec($mh, $active);
			usleep(2000);
		} while($active > 0);
	}
	########################################################################
	function logOutUser() {
		RememberMe::logout();
	}
	########################################################################
	function getPKFieldName($tn) {
		// get pk field name of given table
		static $pk = [];
		if(isset($pk[$tn])) return $pk[$tn];

		$stn = makeSafe($tn, false);
		$eo = ['silentErrors' => true];
		if(!$res = sql("SHOW FIELDS FROM `$stn`", $eo)) return $pk[$tn] = false;

		while($row = db_fetch_assoc($res))
			if($row['Key'] == 'PRI') return $pk[$tn] = $row['Field'];

		return $pk[$tn] = false;
	}
	########################################################################
	function getCSVData($tn, $pkValue, $stripTags = true) {
		// get pk field name for given table
		if(!$pkField = getPKFieldName($tn))
			return '';

		// get a concat string to produce a csv list of field values for given table record
		if(!$res = sql("SHOW FIELDS FROM `$tn`", $eo))
			return '';

		$csvFieldList = '';
		while($row = db_fetch_assoc($res))
			$csvFieldList .= "`{$row['Field']}`,";
		$csvFieldList = substr($csvFieldList, 0, -1);

		$csvData = sqlValue("SELECT CONCAT_WS(', ', $csvFieldList) FROM `$tn` WHERE `$pkField`='" . makeSafe($pkValue, false) . "'");

		return ($stripTags ? strip_tags($csvData) : $csvData);
	}
	########################################################################
	function errorMsg($msg) {
		echo "<div class=\"alert alert-danger\">{$msg}</div>";
	}
	########################################################################
	function redirect($url, $absolute = false) {
		$fullURL = ($absolute ? $url : application_url($url));
		if(!headers_sent()) header("Location: {$fullURL}");

		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0;url={$fullURL}\">";
		echo "<br><br><a href=\"{$fullURL}\">Click here</a> if you aren't automatically redirected.";
		exit;
	}
	########################################################################
	function htmlRadioGroup($name, $arrValue, $arrCaption, $selectedValue, $selClass = 'text-primary', $class = '', $separator = '<br>') {
		if(!is_array($arrValue)) return '';

		ob_start();
		?>
		<div class="radio %%CLASS%%"><label>
			<input type="radio" name="%%NAME%%" id="%%ID%%" value="%%VALUE%%" %%CHECKED%%> %%LABEL%%
		</label></div>
		<?php
		$template = ob_get_clean();

		$out = '';
		for($i = 0; $i < count($arrValue); $i++) {
			$replacements = [
				'%%CLASS%%' => html_attr($arrValue[$i] == $selectedValue ? $selClass :$class),
				'%%NAME%%' => html_attr($name),
				'%%ID%%' => html_attr($name . $i),
				'%%VALUE%%' => html_attr($arrValue[$i]),
				'%%LABEL%%' => $arrCaption[$i],
				'%%CHECKED%%' => ($arrValue[$i]==$selectedValue ? " checked" : "")
			];
			$out .= str_replace(array_keys($replacements), array_values($replacements), $template);
		}

		return $out;
	}
	########################################################################
	function htmlSelect($name, $arrValue, $arrCaption, $selectedValue, $class = '', $selectedClass = '') {
		if($selectedClass == '')
			$selectedClass = $class;

		$out = '';
		if(is_array($arrValue)) {
			$out = "<select name=\"$name\" id=\"$name\">";
			for($i = 0; $i < count($arrValue); $i++)
				$out .= '<option value="' . $arrValue[$i] . '"' . ($arrValue[$i] == $selectedValue ? " selected class=\"$class\"" : " class=\"$selectedClass\"") . '>' . $arrCaption[$i] . '</option>';
			$out .= '</select>';
		}
		return $out;
	}
	########################################################################
	function htmlSQLSelect($name, $sql, $selectedValue, $class = '', $selectedClass = '') {
		$arrVal = [''];
		$arrCap = [''];
		if($res = sql($sql, $eo)) {
			while($row = db_fetch_row($res)) {
				$arrVal[] = $row[0];
				$arrCap[] = $row[1];
			}
			return htmlSelect($name, $arrVal, $arrCap, $selectedValue, $class, $selectedClass);
		}

		return '';
	}
	########################################################################
	function bootstrapSelect($name, $arrValue, $arrCaption, $selectedValue, $class = '', $selectedClass = '') {
		if($selectedClass == '') $selectedClass = $class;

		$out = "<select class=\"form-control\" name=\"{$name}\" id=\"{$name}\">";
		if(is_array($arrValue)) {
			for($i = 0; $i < count($arrValue); $i++) {
				$selected = "class=\"{$class}\"";
				if($arrValue[$i] == $selectedValue) $selected = "selected class=\"{$selectedClass}\"";
				$out .= "<option value=\"{$arrValue[$i]}\" {$selected}>{$arrCaption[$i]}</option>";
			}
		}
		$out .= '</select>';

		return $out;
	}
	########################################################################
	function bootstrapSQLSelect($name, $sql, $selectedValue, $class = '', $selectedClass = '') {
		$arrVal = [''];
		$arrCap = [''];
		$eo = ['silentErrors' => true];
		if($res = sql($sql, $eo)) {
			while($row = db_fetch_row($res)) {
				$arrVal[] = $row[0];
				$arrCap[] = $row[1];
			}
			return bootstrapSelect($name, $arrVal, $arrCap, $selectedValue, $class, $selectedClass);
		}

		return '';
	}
	########################################################################
	function isEmail($email){
		if(preg_match('/^([*+!.&#$�\'\\%\/0-9a-z^_`{}=?~:-]+)@(([0-9a-z-]+\.)+[0-9a-z]{2,30})$/i', $email))
			return $email;

		return false;
	}
	########################################################################
	function notifyMemberApproval($memberID) {
		$adminConfig = config('adminConfig');
		$memberID = strtolower($memberID);

		$email = sqlValue("select email from membership_users where lcase(memberID)='{$memberID}'");

		return sendmail([
			'to' => $email,
			'name' => $memberID,
			'subject' => $adminConfig['approvalSubject'],
			'message' => nl2br($adminConfig['approvalMessage']),
		]);
	}
	########################################################################
	function setupMembership() {
		if(empty($_SESSION) || empty($_SESSION['memberID'])) return;

		// run once per session, but force proceeding if not all mem tables created
		$res = sql("show tables like 'membership_%'", $eo);
		$num_mem_tables = db_num_rows($res);
		$mem_update_fn = membership_table_functions();
		if(isset($_SESSION['setupMembership']) && $num_mem_tables >= count($mem_update_fn)) return;

		/* abort if current page is one of the following exceptions */
		if(in_array(basename($_SERVER['PHP_SELF']), [
			'pageEditMember.php', 
			'membership_passwordReset.php', 
			'membership_profile.php', 
			'membership_signup.php', 
			'pageChangeMemberStatus.php', 
			'pageDeleteGroup.php', 
			'pageDeleteMember.php', 
			'pageEditGroup.php', 
			'pageEditMemberPermissions.php', 
			'pageRebuildFields.php', 
			'pageSettings.php',
			'ajax_check_login.php',
			'ajax-update-calculated-fields.php',
		])) return;

		// call each update_membership function
		foreach($mem_update_fn as $mem_fn) {
			$mem_fn();
		}

		configure_anonymous_group();
		configure_admin_group();

		$_SESSION['setupMembership'] = time();
	}
	########################################################################
	function membership_table_functions() {
		// returns a list of update_membership_* functions
		$arr = get_defined_functions();
		return array_filter($arr['user'], function($f) {
			return (strpos($f, 'update_membership_') !== false);
		});
	}
	########################################################################
	function configure_anonymous_group() {
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		$adminConfig = config('adminConfig');
		$today = @date('Y-m-d');

		$anon_group_safe = makeSafe($adminConfig['anonymousGroup']);
		$anon_user = strtolower($adminConfig['anonymousMember']);
		$anon_user_safe = makeSafe($anon_user);

		/* create anonymous group if not there and get its ID */
		$same_fields = "`allowSignup`=0, `needsApproval`=0";
		sql("INSERT INTO `membership_groups` SET 
				`name`='{$anon_group_safe}', {$same_fields}, 
				`description`='Anonymous group created automatically on {$today}'
			ON DUPLICATE KEY UPDATE {$same_fields}", 
		$eo);

		$anon_group_id = sqlValue("SELECT `groupID` FROM `membership_groups` WHERE `name`='{$anon_group_safe}'");
		if(!$anon_group_id) return;

		/* create guest user if not there or if guest name in config differs from that in db */
		$anon_user_db = sqlValue("SELECT LCASE(`memberID`) FROM `membership_users` 
			WHERE `groupID`='{$anon_group_id}'");
		if(!$anon_user_db || $anon_user_db != $anon_user) {
			sql("DELETE FROM `membership_users` WHERE `groupID`='{$anon_group_id}'", $eo);
			sql("INSERT INTO `membership_users` SET 
				`memberID`='{$anon_user_safe}', 
				`signUpDate`='{$today}', 
				`groupID`='{$anon_group_id}', 
				`isBanned`=0, 
				`isApproved`=1, 
				`comments`='Anonymous member created automatically on {$today}'", 
			$eo);
		}
	}
	########################################################################
	function configure_admin_group() {
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		$adminConfig = config('adminConfig');
		$today = @date('Y-m-d');
		$admin_group_safe = 'Admins';
		$admin_user_safe = makeSafe(strtolower($adminConfig['adminUsername']));
		$admin_hash_safe = makeSafe($adminConfig['adminPassword']);
		$admin_email_safe = makeSafe($adminConfig['senderEmail']);

		/* create admin group if not there and get its ID */
		$same_fields = "`allowSignup`=0, `needsApproval`=1";
		sql("INSERT INTO `membership_groups` SET 
				`name`='{$admin_group_safe}', {$same_fields}, 
				`description`='Admin group created automatically on {$today}'
			ON DUPLICATE KEY UPDATE {$same_fields}", 
		$eo);
		$admin_group_id = sqlValue("SELECT `groupID` FROM `membership_groups` WHERE `name`='{$admin_group_safe}'");
		if(!$admin_group_id) return;

		/* create super-admin user if not there (if exists, query would abort with suppressed error) */
		sql("INSERT INTO `membership_users` SET 
			`memberID`='{$admin_user_safe}', 
			`passMD5`='{$admin_hash_safe}', 
			`email`='{$admin_email_safe}', 
			`signUpDate`='{$today}', 
			`groupID`='{$admin_group_id}', 
			`isBanned`=0, 
			`isApproved`=1, 
			`comments`='Admin member created automatically on {$today}'", 
		$eo);

		/* insert/update admin group permissions to allow full access to all tables */
		$tables = getTableList(true);
		foreach($tables as $tn => $ignore) {
			$same_fields = '`allowInsert`=1,`allowView`=3,`allowEdit`=3,`allowDelete`=3';
			sql("INSERT INTO `membership_grouppermissions` SET
					`groupID`='{$admin_group_id}',
					`tableName`='{$tn}',
					{$same_fields}
				ON DUPLICATE KEY UPDATE {$same_fields}",
			$eo);
		}
	}
	########################################################################
	function get_table_keys($tn) {
		$keys = [];
		$res = sql("SHOW KEYS FROM `{$tn}`", $eo);
		while($row = db_fetch_assoc($res))
			$keys[$row['Key_name']][$row['Seq_in_index']] = $row;

		return $keys;
	}
	########################################################################
	function get_table_fields($tn = null) {
		static $schema = null;
		if($schema === null) {
			/* application schema as created in AppGini */
			$schema = [
				'Estado_Conservacion' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Descripcion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Descripcion',
							'description' => '',
						],
					],
				],
				'Estado_Prestable' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Descripcion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Descripcion',
							'description' => '',
						],
					],
				],
				'Registros' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Codigo_de_Registro' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'C&#243;digo_Registro',
							'description' => '',
						],
					],
					'Codigo_Barras' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Codigo Barras',
							'description' => '',
						],
					],
					'id_Estado_Conservacion' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Estado de Conservacion',
							'description' => '',
						],
					],
					'id_Estado_Prestable' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Estado Prestable',
							'description' => '',
						],
					],
					'Fecha_Regsitro' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Fecha Regsitro',
							'description' => '',
						],
					],
				],
				'Estado_Prestamo' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Descripcion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Descripcion',
							'description' => '',
						],
					],
				],
				'Estado_Catalogacion' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Descripcion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Descripcion',
							'description' => '',
						],
					],
				],
				'Editoriales' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Nombre' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Nombre',
							'description' => '',
						],
					],
					'Direccion' => [
						'appgini' => "VARCHAR(200) NULL",
						'info' => [
							'caption' => 'Direccion',
							'description' => '',
						],
					],
					'Telefono' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Telefono',
							'description' => '',
						],
					],
					'Correo' => [
						'appgini' => "VARCHAR(100) NULL",
						'info' => [
							'caption' => 'Correo',
							'description' => '',
						],
					],
					'Contacto' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Contacto',
							'description' => '',
						],
					],
				],
				'Catalogo' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Portada' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Portada',
							'description' => 'Maximum file size allowed: 100000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'Codigo_Registro' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Codigo Registro',
							'description' => '',
						],
					],
					'Cod_Barras' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'C&#243;digo de  Barras',
							'description' => '',
						],
					],
					'Item' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Item',
							'description' => '',
						],
					],
					'Cod_Ejemplar' => [
						'appgini' => "VARCHAR(40) NULL",
						'info' => [
							'caption' => 'Cod Ejemplar',
							'description' => '',
						],
					],
					'Tipo_Literatura' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Tipo de Literatura',
							'description' => '',
						],
					],
					'Tipo_Documento' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Tipo de Documento',
							'description' => '',
						],
					],
					'id_Estado_Catalogacion' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Estado de Catalogacion',
							'description' => '',
						],
					],
					'Signatura_Topografica' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Signatura Topografica',
							'description' => '',
						],
					],
					'Id_Autoridad' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Autor',
							'description' => '',
						],
					],
					'Titulo' => [
						'appgini' => "VARCHAR(250) NULL",
						'info' => [
							'caption' => 'Titulo',
							'description' => '',
						],
					],
					'Responsabilidades' => [
						'appgini' => "VARCHAR(250) NULL",
						'info' => [
							'caption' => 'Responsabilidades',
							'description' => '',
						],
					],
					'Edicion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Edicion',
							'description' => '',
						],
					],
					'Id_Lugar' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Lugar de Publicaci&#243;n',
							'description' => '',
						],
					],
					'id_Editorial' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Editorial',
							'description' => '',
						],
					],
					'Fecha_Publicacion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Fecha de Publicacion',
							'description' => '',
						],
					],
					'Desc_Fisica' => [
						'appgini' => "VARCHAR(100) NULL",
						'info' => [
							'caption' => 'Descripci&#243;n Fisica',
							'description' => '',
						],
					],
					'Notas' => [
						'appgini' => "TEXT NULL",
						'info' => [
							'caption' => 'Notas',
							'description' => '',
						],
					],
					'Materia_1' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Materia 1',
							'description' => '',
						],
					],
					'Materia_2' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Materia 2',
							'description' => '',
						],
					],
					'Materia_3' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Materia 3',
							'description' => '',
						],
					],
					'Ejemplares' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'Ejemplares',
							'description' => '',
						],
					],
					'Fecha_Catalogacion' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Fecha de Catalogaci&#243;n',
							'description' => '',
						],
					],
				],
				'Circulacion' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'id_Usuario' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Usuario',
							'description' => '',
						],
					],
					'Foto_Usuario' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Foto Usuario',
							'description' => '',
						],
					],
					'id_Tipo_usuario' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Tipo de Usuario',
							'description' => '',
						],
					],
					'id_Politica_pretamo' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Politica de pretamo',
							'description' => '',
						],
					],
					'id_Tipo_documento' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Tipo de documento',
							'description' => '',
						],
					],
					'id_Registro' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Registro',
							'description' => '',
						],
					],
					'Libro_Prestado' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Libro Prestado',
							'description' => '',
						],
					],
					'Portada_libro' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Portada del Libro',
							'description' => '',
						],
					],
					'Fecha_Prestamo' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Fecha de Prestamo',
							'description' => '',
						],
					],
					'Fecha_Devolucion' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Fecha de Devoluci&#243;n',
							'description' => '',
						],
					],
					'id_Estado_prestamo' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Estado de Prestamo',
							'description' => '',
						],
					],
					'Cantidad' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'Cantidad',
							'description' => '',
						],
					],
					'Ejemp_Disponibles' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Ejemplares Disponibles',
							'description' => '',
						],
					],
					'Item' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Item',
							'description' => '',
						],
					],
					'Cod_Ejemplar' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Cod Ejemplar',
							'description' => '',
						],
					],
				],
				'Tipo_Documento' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Descripcion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Descripcion',
							'description' => '',
						],
					],
				],
				'Autoridades' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Foto' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Foto',
							'description' => 'Maximum file size allowed: 100000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'id_Tipo_autoridad' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Id Tipo autoridad',
							'description' => '',
						],
					],
					'Nombre' => [
						'appgini' => "VARCHAR(150) NULL",
						'info' => [
							'caption' => 'Nombre',
							'description' => '',
						],
					],
					'Fecha_Extrema' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Fecha Extrema',
							'description' => '',
						],
					],
					'Vease_Ademas' => [
						'appgini' => "VARCHAR(200) NULL",
						'info' => [
							'caption' => 'Vease Ademas',
							'description' => '',
						],
					],
				],
				'Estado_Suscripcion' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Descripcion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Descripcion',
							'description' => '',
						],
					],
				],
				'Usuarios' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Foto' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Foto',
							'description' => 'Maximum file size allowed: 100000 KB.<br>Allowed file types: jpg, jpeg, gif, png, webp',
						],
					],
					'id_Tipo_usuario' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Id Tipo usuario',
							'description' => '',
						],
					],
					'Apellidos' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Apellidos',
							'description' => '',
						],
					],
					'Nombres' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Nombres',
							'description' => '',
						],
					],
					'Correo' => [
						'appgini' => "VARCHAR(100) NULL",
						'info' => [
							'caption' => 'Correo',
							'description' => '',
						],
					],
					'Telefono' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Telefono',
							'description' => '',
						],
					],
					'id_Estado_suscripcion' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Id Estado suscripcion',
							'description' => '',
						],
					],
					'Fecha_Registro' => [
						'appgini' => "DATE NULL",
						'info' => [
							'caption' => 'Fecha Registro',
							'description' => '',
						],
					],
				],
				'Politica_de_Prestamos' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'id_Tipo_usuario' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Tipo de Usuario',
							'description' => '',
						],
					],
					'id_Tipo_documento' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Tipo de documento',
							'description' => '',
						],
					],
					'Duracion_Prestamo' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'Duracion del Pr&#233;stamo',
							'description' => '',
						],
					],
					'Lim_Doc_Presado' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'L&#237;mite de Doc_Prestado',
							'description' => '',
						],
					],
				],
				'Lugares' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Descripcion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Descripcion',
							'description' => '',
						],
					],
				],
				'Tipo_Autoridad' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Descripcion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Descripcion',
							'description' => '',
						],
					],
				],
				'Tipo_Usuario' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Descripcion' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Descripcion',
							'description' => '',
						],
					],
					'Lim_Doc_Prestado' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'L&#237;mite Docmemt_Prestado',
							'description' => '',
						],
					],
					'Lim_Doc_Reserva' => [
						'appgini' => "INT NULL",
						'info' => [
							'caption' => 'L&#237;mite Doc_Reserva',
							'description' => '',
						],
					],
				],
				'Materias' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Descriptor' => [
						'appgini' => "VARCHAR(250) NULL",
						'info' => [
							'caption' => 'Descriptor',
							'description' => '',
						],
					],
				],
				'Itemes' => [
					'id' => [
						'appgini' => "INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT",
						'info' => [
							'caption' => 'ID',
							'description' => '',
						],
					],
					'Cod_item' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Cod item',
							'description' => '',
						],
					],
					'Estado_Conservacion' => [
						'appgini' => "INT UNSIGNED NULL",
						'info' => [
							'caption' => 'Estado Conservacion',
							'description' => '',
						],
					],
					'Num_Copia' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Num Copia',
							'description' => '',
						],
					],
					'Cod_Ejemplar' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Cod Ejemplar',
							'description' => '',
						],
					],
					'Estado_de_Baja' => [
						'appgini' => "VARCHAR(50) NULL",
						'info' => [
							'caption' => 'Estado de Baja',
							'description' => '',
						],
					],
				],
			];
		}

		if($tn === null) return $schema;

		return isset($schema[$tn]) ? $schema[$tn] : [];
	}
	########################################################################
	function update_membership_groups() {
		$tn = 'membership_groups';
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		sql(
			"CREATE TABLE IF NOT EXISTS `{$tn}` (
				`groupID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`name` varchar(100) NOT NULL,
				`description` TEXT,
				`allowSignup` TINYINT,
				`needsApproval` TINYINT,
				`allowCSVImport` TINYINT NOT NULL DEFAULT '0',
				PRIMARY KEY (`groupID`)
			) CHARSET " . mysql_charset,
		$eo);

		sql("ALTER TABLE `{$tn}` CHANGE COLUMN `name` `name` VARCHAR(100) NOT NULL", $eo);
		sql("ALTER TABLE `{$tn}` ADD UNIQUE INDEX `name` (`name`)", $eo);
		sql("ALTER TABLE `{$tn}` ADD COLUMN `allowCSVImport` TINYINT NOT NULL DEFAULT '0'", $eo);
	}
	########################################################################
	function update_membership_users() {
		$tn = 'membership_users';
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		sql(
			"CREATE TABLE IF NOT EXISTS `{$tn}` (
				`memberID` VARCHAR(100) NOT NULL, 
				`passMD5` VARCHAR(255), 
				`email` VARCHAR(100), 
				`signupDate` DATE, 
				`groupID` INT UNSIGNED, 
				`isBanned` TINYINT, 
				`isApproved` TINYINT, 
				`custom1` TEXT, 
				`custom2` TEXT, 
				`custom3` TEXT, 
				`custom4` TEXT, 
				`comments` TEXT, 
				`pass_reset_key` VARCHAR(100),
				`pass_reset_expiry` INT UNSIGNED,
				`flags` TEXT,
				`allowCSVImport` TINYINT NOT NULL DEFAULT '0', 
				`data` LONGTEXT,
				PRIMARY KEY (`memberID`),
				INDEX `groupID` (`groupID`)
			) CHARSET " . mysql_charset,
		$eo);

		sql("ALTER TABLE `{$tn}` ADD COLUMN `pass_reset_key` VARCHAR(100)", $eo);
		sql("ALTER TABLE `{$tn}` ADD COLUMN `pass_reset_expiry` INT UNSIGNED", $eo);
		sql("ALTER TABLE `{$tn}` CHANGE COLUMN `passMD5` `passMD5` VARCHAR(255)", $eo);
		sql("ALTER TABLE `{$tn}` CHANGE COLUMN `memberID` `memberID` VARCHAR(100) NOT NULL", $eo);
		sql("ALTER TABLE `{$tn}` ADD INDEX `groupID` (`groupID`)", $eo);
		sql("ALTER TABLE `{$tn}` ADD COLUMN `flags` TEXT", $eo);
		sql("ALTER TABLE `{$tn}` ADD COLUMN `allowCSVImport` TINYINT NOT NULL DEFAULT '0'", $eo);
		sql("ALTER TABLE `{$tn}` ADD COLUMN `data` LONGTEXT", $eo);
	}
	########################################################################
	function update_membership_userrecords() {
		$tn = 'membership_userrecords';
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		sql(
			"CREATE TABLE IF NOT EXISTS `{$tn}` (
				`recID` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, 
				`tableName` VARCHAR(100), 
				`pkValue` VARCHAR(255), 
				`memberID` VARCHAR(100), 
				`dateAdded` BIGINT UNSIGNED, 
				`dateUpdated` BIGINT UNSIGNED, 
				`groupID` INT UNSIGNED, 
				PRIMARY KEY (`recID`),
				UNIQUE INDEX `tableName_pkValue` (`tableName`, `pkValue`(100)),
				INDEX `pkValue` (`pkValue`),
				INDEX `tableName` (`tableName`),
				INDEX `memberID` (`memberID`),
				INDEX `groupID` (`groupID`)
			) CHARSET " . mysql_charset,
		$eo);

		sql("ALTER TABLE `{$tn}` ADD UNIQUE INDEX `tableName_pkValue` (`tableName`, `pkValue`(100))", $eo);
		sql("ALTER TABLE `{$tn}` ADD INDEX `pkValue` (`pkValue`)", $eo);
		sql("ALTER TABLE `{$tn}` ADD INDEX `tableName` (`tableName`)", $eo);
		sql("ALTER TABLE `{$tn}` ADD INDEX `memberID` (`memberID`)", $eo);
		sql("ALTER TABLE `{$tn}` ADD INDEX `groupID` (`groupID`)", $eo);
		sql("ALTER TABLE `{$tn}` CHANGE COLUMN `memberID` `memberID` VARCHAR(100)", $eo);
	}
	########################################################################
	function update_membership_grouppermissions() {
		$tn = 'membership_grouppermissions';
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		sql(
			"CREATE TABLE IF NOT EXISTS `{$tn}` (
				`permissionID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`groupID` INT UNSIGNED,
				`tableName` VARCHAR(100),
				`allowInsert` TINYINT NOT NULL DEFAULT '0',
				`allowView` TINYINT NOT NULL DEFAULT '0',
				`allowEdit` TINYINT NOT NULL DEFAULT '0',
				`allowDelete` TINYINT NOT NULL DEFAULT '0',
				PRIMARY KEY (`permissionID`)
			) CHARSET " . mysql_charset,
		$eo);

		sql("ALTER TABLE `{$tn}` ADD UNIQUE INDEX `groupID_tableName` (`groupID`, `tableName`)", $eo);
	}
	########################################################################
	function update_membership_userpermissions() {
		$tn = 'membership_userpermissions';
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		sql(
			"CREATE TABLE IF NOT EXISTS `{$tn}` (
				`permissionID` INT UNSIGNED NOT NULL AUTO_INCREMENT,
				`memberID` VARCHAR(100) NOT NULL,
				`tableName` VARCHAR(100),
				`allowInsert` TINYINT NOT NULL DEFAULT '0',
				`allowView` TINYINT NOT NULL DEFAULT '0',
				`allowEdit` TINYINT NOT NULL DEFAULT '0',
				`allowDelete` TINYINT NOT NULL DEFAULT '0',
				PRIMARY KEY (`permissionID`)
			) CHARSET " . mysql_charset,
		$eo);

		sql("ALTER TABLE `{$tn}` CHANGE COLUMN `memberID` `memberID` VARCHAR(100) NOT NULL", $eo);
		sql("ALTER TABLE `{$tn}` ADD UNIQUE INDEX `memberID_tableName` (`memberID`, `tableName`)", $eo);
	}
	########################################################################
	function update_membership_usersessions() {
		$tn = 'membership_usersessions';
		$eo = ['silentErrors' => true, 'noErrorQueryLog' => true];

		sql(
			"CREATE TABLE IF NOT EXISTS `membership_usersessions` (
				`memberID` VARCHAR(100) NOT NULL,
				`token` VARCHAR(100) NOT NULL,
				`agent` VARCHAR(100) NOT NULL,
				`expiry_ts` INT(10) UNSIGNED NOT NULL,
				UNIQUE INDEX `memberID_token_agent` (`memberID`, `token`(50), `agent`(50)),
				INDEX `memberID` (`memberID`),
				INDEX `expiry_ts` (`expiry_ts`)
			) CHARSET " . mysql_charset,
		$eo);
	}
	########################################################################
	function thisOr($this_val, $or = '&nbsp;') {
		return ($this_val != '' ? $this_val : $or);
	}
	########################################################################
	function getUploadedFile($FieldName, $MaxSize = 0, $FileTypes = 'csv|txt', $NoRename = false, $dir = '') {
		if(empty($_FILES) || empty($_FILES[$FieldName]))
			return 'Your php settings don\'t allow file uploads.';

		$f = $_FILES[$FieldName];

		if(!$MaxSize)
			$MaxSize = toBytes(ini_get('upload_max_filesize'));

		@mkdir(__DIR__ . '/csv');

		$dir = (is_dir($dir) && is_writable($dir) ? $dir : __DIR__ . '/csv/');

		if($f['error'] != 4 && $f['name'] != '') {
			if($f['size'] > $MaxSize || $f['error']) {
				return 'File size exceeds maximum allowed of '.intval($MaxSize / 1024).'KB';
			}

			if(!preg_match('/\.('.$FileTypes.')$/i', $f['name'], $ft)) {
				return 'File type not allowed. Only these file types are allowed: '.str_replace('|', ', ', $FileTypes);
			}

			if($NoRename) {
				$n  = str_replace(' ', '_', $f['name']);
			} else {
				$n  = microtime();
				$n  = str_replace(' ', '_', $n);
				$n  = str_replace('0.', '', $n);
				$n .= $ft[0];
			}

			if(!@move_uploaded_file($f['tmp_name'], $dir . $n)) {
				return 'Couldn\'t save the uploaded file. Try chmoding the upload folder "'.$dir.'" to 777.';
			} else {
				@chmod($dir.$n, 0666);
				return $dir.$n;
			}
		}
		return 'An error occurred while uploading the file. Please try again.';
	}
	########################################################################
	function toBytes($val) {
		$val = trim($val);
		$last = strtolower($val[strlen($val) - 1]);

		$val = intval($val);
		switch($last) {
			 case 'g':
					$val *= 1024;
			 case 'm':
					$val *= 1024;
			 case 'k':
					$val *= 1024;
		}

		return $val;
	}
	########################################################################
	function convertLegacyOptions($CSVList) {
		$CSVList=str_replace(';;;', ';||', $CSVList);
		$CSVList=str_replace(';;', '||', $CSVList);
		return trim($CSVList, '|');
	}
	########################################################################
	function getValueGivenCaption($query, $caption) {
		if(!preg_match('/select\s+(.*?)\s*,\s*(.*?)\s+from\s+(.*?)\s+order by.*/i', $query, $m)) {
			if(!preg_match('/select\s+(.*?)\s*,\s*(.*?)\s+from\s+(.*)/i', $query, $m)) {
				return '';
			}
		}

		// get where clause if present
		if(preg_match('/\s+from\s+(.*?)\s+where\s+(.*?)\s+order by.*/i', $query, $mw)) {
			$where = "where ({$mw[2]}) AND";
			$m[3] = $mw[1];
		} else {
			$where = 'where';
		}

		$caption = makeSafe($caption);
		return sqlValue("SELECT {$m[1]} FROM {$m[3]} {$where} {$m[2]}='{$caption}'");
	}
	########################################################################
	function time24($t = false) {
		if($t === false) $t = date('Y-m-d H:i:s'); // time now if $t not passed
		elseif(!$t) return ''; // empty string if $t empty
		return date('H:i:s', strtotime($t));
	}
	########################################################################
	function time12($t = false) {
		if($t === false) $t = date('Y-m-d H:i:s'); // time now if $t not passed
		elseif(!$t) return ''; // empty string if $t empty
		return date('h:i:s A', strtotime($t));
	}
	########################################################################
	function normalize_path($path) {
		// Adapted from https://developer.wordpress.org/reference/functions/wp_normalize_path/

		// Standardise all paths to use /
		$path = str_replace('\\', '/', $path);

		// Replace multiple slashes down to a singular, allowing for network shares having two slashes.
		$path = preg_replace('|(?<=.)/+|', '/', $path);

		// Windows paths should uppercase the drive letter
		if(':' === substr($path, 1, 1)) {
			$path = ucfirst($path);
		}

		return $path;
	}
	########################################################################
	function application_url($page = '', $s = false) {
		if($s === false) $s = $_SERVER;
		$ssl = (!empty($s['HTTPS']) && strtolower($s['HTTPS']) != 'off');
		$http = ($ssl ? 'https:' : 'http:');
		$port = $s['SERVER_PORT'];
		$port = ($port == '80' || $port == '443' || !$port) ? '' : ':' . $port;
		// HTTP_HOST already includes server port if not standard, but SERVER_NAME doesn't
		$host = (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : $s['SERVER_NAME'] . $port);

		$uri = config('appURI');
		if(!$uri) $uri = '/';

		// uri must begin and end with /, but not be '//'
		if($uri != '/' && $uri[0] != '/') $uri = "/{$uri}";
		if($uri != '/' && $uri[strlen($uri) - 1] != '/') $uri = "{$uri}/";

		return "{$http}//{$host}{$uri}{$page}";
	}
	########################################################################
	function application_uri($page = '') {
		$url = application_url($page);
		return trim(parse_url($url, PHP_URL_PATH), '/');
	}
	########################################################################
	function is_ajax() {
		return (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	}
	########################################################################
	function is_allowed_username($username, $exception = false) {
		$username = trim(strtolower($username));
		if(!preg_match('/^[a-z0-9][a-z0-9 _.@]{3,100}$/', $username) || preg_match('/(@@|  |\.\.|___)/', $username)) return false;

		if($username == $exception) return $username;

		if(sqlValue("select count(1) from membership_users where lcase(memberID)='{$username}'")) return false;
		return $username;
	}
	########################################################################
	/*
		if called without parameters, looks for a non-expired token in the user's session (or creates one if
		none found) and returns html code to insert into the form to be protected.

		if set to true, validates token sent in $_REQUEST against that stored in the session
		and returns true if valid or false if invalid, absent or expired.

		usage:
			1. in a new form that needs csrf proofing: echo csrf_token();
			   >> in case of ajax requests and similar, retrieve token directly
			      by calling csrf_token(false, true);
			2. when validating a submitted form: if(!csrf_token(true)) { reject_submission_somehow(); }
	*/
	function csrf_token($validate = false, $token_only = false) {
		// a long token age is better for UX with SPA and browser back/forward buttons
		// and it would expire when the session ends anyway
		$token_age = 86400 * 2;

		/* retrieve token from session */
		$csrf_token = (isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : false);
		$csrf_token_expiry = (isset($_SESSION['csrf_token_expiry']) ? $_SESSION['csrf_token_expiry'] : false);

		if(!$validate) {
			/* create a new token if necessary */
			if($csrf_token_expiry < time() || !$csrf_token) {
				$csrf_token = bin2hex(random_bytes(16));
				$csrf_token_expiry = time() + $token_age;
				$_SESSION['csrf_token'] = $csrf_token;
				$_SESSION['csrf_token_expiry'] = $csrf_token_expiry;
			}

			if($token_only) return $csrf_token;
			return '<input type="hidden" id="csrf_token" name="csrf_token" value="' . $csrf_token . '">';
		}

		/* validate submitted token */
		$user_token = Request::val('csrf_token', false);
		if($csrf_token_expiry < time() || !$user_token || $user_token != $csrf_token) {
			return false;
		}

		return true;
	}
	########################################################################
	function get_plugins() {
		$plugins = [];
		$plugins_path = __DIR__ . '/../plugins/';

		if(!is_dir($plugins_path)) return $plugins;

		$pd = dir($plugins_path);
		while(false !== ($plugin = $pd->read())) {
			if(!is_dir($plugins_path . $plugin) || in_array($plugin, ['projects', 'plugins-resources', '.', '..'])) continue;

			$info_file = "{$plugins_path}{$plugin}/plugin-info.json";
			if(!is_file($info_file)) continue;

			$plugins[] = json_decode(file_get_contents($info_file), true);
			$plugins[count($plugins) - 1]['admin_path'] = "../plugins/{$plugin}";
		}
		$pd->close();

		return $plugins;
	}
	########################################################################
	function maintenance_mode($new_status = '') {
		$maintenance_file = __DIR__ . '/.maintenance';

		if($new_status === true) {
			/* turn on maintenance mode */
			@touch($maintenance_file);
		} elseif($new_status === false) {
			/* turn off maintenance mode */
			@unlink($maintenance_file);
		}

		/* return current maintenance mode status */
		return is_file($maintenance_file);
	}
	########################################################################
	function handle_maintenance($echo = false) {
		if(!maintenance_mode()) return;

		global $Translation;
		$adminConfig = config('adminConfig');

		$admin = getLoggedAdmin();
		if($admin) {
			return ($echo ? '<div class="alert alert-danger" style="margin: 5em auto -5em;"><b>' . $Translation['maintenance mode admin notification'] . '</b></div>' : '');
		}

		if(!$echo) exit;

		exit('<div class="alert alert-danger" style="margin-top: 5em; font-size: 2em;"><i class="glyphicon glyphicon-exclamation-sign"></i> ' . $adminConfig['maintenance_mode_message'] . '</div>');
	}
	#########################################################
	function html_attr($str) {
		if(version_compare(PHP_VERSION, '5.2.3') >= 0) return htmlspecialchars($str, ENT_QUOTES, datalist_db_encoding, false);
		return htmlspecialchars($str, ENT_QUOTES, datalist_db_encoding);
	}
	#########################################################
	function html_attr_tags_ok($str) {
		// use this instead of html_attr() if you don't want html tags to be escaped
		$new_str = html_attr($str);
		return str_replace(['&lt;', '&gt;'], ['<', '>'], $new_str);
	}
	#########################################################
	class Notification{
		/*
			Usage:
			* in the main document, initiate notifications support using this PHP code:
				echo Notification::placeholder();

			* whenever you want to show a notifcation, use this PHP code inside a script tag:
				echo Notification::show([
					'message' => 'Notification text to display',
					'class' => 'danger', // or other bootstrap state cues, 'default' if not provided
					'dismiss_seconds' => 5, // optional auto-dismiss after x seconds
					'dismiss_days' => 7, // optional dismiss for x days if closed by user -- must provide an id
					'id' => 'xyz' // optional string to identify the notification -- must use for 'dismiss_days' to work
				]);
		*/
		protected static $placeholder_id; /* to force a single notifcation placeholder */

		protected function __construct() {} /* to prevent initialization */

		public static function placeholder() {
			if(self::$placeholder_id) return ''; // output placeholder code only once

			self::$placeholder_id = 'notifcation-placeholder-' . rand(10000000, 99999999);

			ob_start();
			?>

			<div class="notifcation-placeholder" id="<?php echo self::$placeholder_id; ?>"></div>
			<script>
				$j(function() {
					if(window.show_notification != undefined) return;

					window.show_notification = function(options) {
						var dismiss_class = '';
						var dismiss_icon = '';
						var cookie_name = 'hide_notification_' + options.id;
						var notif_id = 'notifcation-' + Math.ceil(Math.random() * 1000000);

						/* apply provided notficiation id if unique in page */
						if(options.id != undefined) {
							if(!$j('#' + options.id).length) notif_id = options.id;
						}

						/* notifcation should be hidden? */
						if(localStorage.getItem(cookie_name) != undefined) return;

						/* notification should be dismissable? */
						if(options.dismiss_seconds > 0 || options.dismiss_days > 0) {
							dismiss_class = ' alert-dismissible';
							dismiss_icon = '<button type="button" class="close" data-dismiss="alert">&times;</button>';
						}

						/* remove old dismissed notficiations */
						$j('.alert-dismissible.invisible').remove();

						/* append notification to notifications container */
						$j(
							'<div class="alert alert-' + options['class'] + dismiss_class + '" id="' + notif_id + '">' + 
								dismiss_icon +
								options.message + 
							'</div>'
						).appendTo('#<?php echo self::$placeholder_id; ?>');

						var this_notif = $j('#' + notif_id);

						/* dismiss after x seconds if requested */
						if(options.dismiss_seconds > 0) {
							setTimeout(function() { this_notif.addClass('invisible'); }, options.dismiss_seconds * 1000);
						}

						/* dismiss for x days if requested and user dismisses it */
						if(options.dismiss_days > 0) {
							var ex_days = options.dismiss_days;
							this_notif.on('closed.bs.alert', function() {
								/* set a cookie not to show this alert for ex_days */
								localStorage.setItem(cookie_name, '1');
							});
						}
					}
				})
			</script>

			<?php

			return ob_get_clean();
		}

		protected static function default_options(&$options) {
			if(!isset($options['message'])) $options['message'] = 'Notification::show() called without a message!';

			if(!isset($options['class'])) $options['class'] = 'default';

			if(!isset($options['dismiss_seconds']) || isset($options['dismiss_days'])) $options['dismiss_seconds'] = 0;

			if(!isset($options['dismiss_days'])) $options['dismiss_days'] = 0;
			if(!isset($options['id'])) {
				$options['id'] = 0;
				$options['dismiss_days'] = 0;
			}
		}

		/**
		 *  @brief Notification::show($options) displays a notification
		 *  
		 *  @param $options assoc array
		 *  
		 *  @return html code for displaying the notifcation
		 */
		public static function show($options = []) {
			self::default_options($options);

			ob_start();
			?>
			<script>
				$j(function() {
					show_notification(<?php echo json_encode($options); ?>);
				})
			</script>
			<?php

			return ob_get_clean();
		}
	}
	#########################################################
	function addMailRecipients(&$pm, $recipients, $type = 'to') {
		if(empty($recipients)) return;

		$func = [];

		switch(strtolower($type)) {
			case 'cc':
				$func = [$pm, 'addCC'];
				break;
			case 'bcc':
				$func = [$pm, 'addBCC'];
				break;
			case 'to':
			default:
				$func = [$pm, 'addAddress'];
				break;
		}

		// if recipients is a str, arrayify it!
		if(is_string($recipients)) $recipients = [[$recipients]];
		if(!is_array($recipients)) return;

		// if recipients is an array, loop thru and add emails/names
		foreach ($recipients as $rcpt) {
			// if rcpt is string, add as email
			if(is_string($rcpt) && isEmail($rcpt))
				call_user_func_array($func, [$rcpt]);

			// else if rcpt is array [email, name], or just [email]
			elseif(is_array($rcpt) && isEmail($rcpt[0]))
				call_user_func_array($func, [$rcpt[0], empty($rcpt[1]) ? '' : $rcpt[1]]);
		}
	}
	#########################################################
	function sendmail($mail) {
		if(empty($mail['to'])) return 'No recipient defined';

		// convert legacy 'to' and 'name' to new format [[to, name]]
		if(is_string($mail['to']))
			$mail['to'] = [
				[
					$mail['to'], 
					empty($mail['name']) ? '' : $mail['name']
				]
			];

		if(!isEmail($mail['to'][0][0])) return 'Invalid recipient email';

		$cfg = config('adminConfig');
		$smtp = ($cfg['mail_function'] == 'smtp');

		if(!class_exists('PHPMailer', false)) {
			include_once(__DIR__ . '/../resources/PHPMailer/class.phpmailer.php');
			if($smtp) include_once(__DIR__ . '/../resources/PHPMailer/class.smtp.php');
		}

		$pm = new PHPMailer;
		$pm->CharSet = datalist_db_encoding;

		if($smtp) {
			$pm->isSMTP();
			$pm->SMTPDebug = isset($mail['debug']) ? min(4, max(0, intval($mail['debug']))) : 0;
			$pm->Debugoutput = 'html';
			$pm->Host = $cfg['smtp_server'];
			$pm->Port = $cfg['smtp_port'];
			$pm->SMTPAuth = !empty($cfg['smtp_user']) || !empty($cfg['smtp_pass']);
			$pm->SMTPSecure = $cfg['smtp_encryption'];
			$pm->SMTPAutoTLS = $cfg['smtp_encryption'] ? true : false;
			$pm->Username = $cfg['smtp_user'];
			$pm->Password = $cfg['smtp_pass'];
		}

		$pm->setFrom($cfg['senderEmail'], $cfg['senderName']);
		$pm->Subject = isset($mail['subject']) ? $mail['subject'] : '';

		// handle recipients
		addMailRecipients($pm, $mail['to']);
		if(!empty($mail['cc'])) addMailRecipients($pm, $mail['cc'], 'cc');
		if(!empty($mail['bcc'])) addMailRecipients($pm, $mail['bcc'], 'bcc');

		/* if message already contains html tags, don't apply nl2br */
		$mail['message'] = isset($mail['message']) ? $mail['message'] : '';
		if($mail['message'] == strip_tags($mail['message']))
			$mail['message'] = nl2br($mail['message']);

		$pm->msgHTML($mail['message'], realpath(__DIR__ . '/..'));

		/*
		 * pass 'tag' as-is if provided in $mail .. 
		 * this is useful for passing any desired values to sendmail_handler
		 */
		if(!empty($mail['tag'])) $pm->tag = $mail['tag'];

		/* if sendmail_handler(&$pm) is defined (in hooks/__global.php) */
		if(function_exists('sendmail_handler')) sendmail_handler($pm);

		if(!$pm->send()) return $pm->ErrorInfo;

		return true;
	}
	#########################################################
	function safe_html($str, $noBr = false) {
		/* if $str has no HTML tags, apply nl2br */
		if($str == strip_tags($str)) return $noBr ? $str : nl2br($str);

		$hc = new CI_Input(datalist_db_encoding);
		$str = $hc->xss_clean(bgStyleToClass($str));

		// sandbox iframes if they aren't already
		$str = preg_replace('/(<|&lt;)iframe(\s+sandbox)*(.*?)(>|&gt;)/i', '$1iframe sandbox$3$4', $str);

		return $str;
	}
	#########################################################
	function getLoggedGroupID() {
		return Authentication::getLoggedGroupId();
	}
	#########################################################
	function getLoggedMemberID() {
		$u = Authentication::getUser();
		return $u ? $u['username'] : false;
	}
	#########################################################
	function setAnonymousAccess() {
		return Authentication::setAnonymousAccess();
	}
	#########################################################
	function getMemberInfo($memberID = null) {
		if($memberID === null) {
			$u = Authentication::getUser();
			if(!$u) return [];

			$memberID = $u['username'];
		}

		return Authentication::getMemberInfo($memberID);
	}
	#########################################################
	function get_group_id($user = null) {
		$mi = getMemberInfo($user);
		return $mi['groupID'];
	}
	#########################################################
	/**
	 *  @brief Prepares data for a SET or WHERE clause, to be used in an INSERT/UPDATE query
	 *  
	 *  @param [in] $set_array Assoc array of field names => values
	 *  @param [in] $glue optional glue. Set to ' AND ' or ' OR ' if preparing a WHERE clause, or to ',' (default) for a SET clause
	 *  @return SET string
	 */
	function prepare_sql_set($set_array, $glue = ', ') {
		$fnvs = [];
		foreach($set_array as $fn => $fv) {
			if($fv === null && trim($glue) == ',') { $fnvs[] = "{$fn}=NULL"; continue; }
			if($fv === null) { $fnvs[] = "{$fn} IS NULL"; continue; }

			if(is_array($fv) && trim($glue) != ',') {
				$fnvs[] = "{$fn} IN ('" . implode("','", array_map('makeSafe', $fv)) . "')";
				continue;
			}

			$sfv = makeSafe($fv);
			$fnvs[] = "{$fn}='{$sfv}'";
		}
		return implode($glue, $fnvs);
	}
	#########################################################
	/**
	 *  @brief Inserts a record to the database
	 *  
	 *  @param [in] $tn table name where the record would be inserted
	 *  @param [in] $set_array Assoc array of field names => values to be inserted
	 *  @param [out] $error optional string containing error message if insert fails
	 *  @return boolean indicating success/failure
	 */
	function insert($tn, $set_array, &$error = '') {
		$set = prepare_sql_set($set_array);
		if(!$set) return false;

		$eo = ['silentErrors' => true];
		$res = sql("INSERT INTO `{$tn}` SET {$set}", $eo);
		if($res) return true;

		$error = $eo['error'];
		return false;
	}
	#########################################################
	/**
	 *  @brief Updates a record in the database
	 *  
	 *  @param [in] $tn table name where the record would be updated
	 *  @param [in] $set_array Assoc array of field names => values to be updated
	 *  @param [in] $where_array Assoc array of field names => values used to build the WHERE clause
	 *  @param [out] $error optional string containing error message if insert fails
	 *  @return boolean indicating success/failure
	 */
	function update($tn, $set_array, $where_array, &$error = '') {
		$set = prepare_sql_set($set_array);
		if(!$set) return false;

		$where = prepare_sql_set($where_array, ' AND ');
		if(!$where) $where = '1=1';

		$eo = ['silentErrors' => true];
		$res = sql("UPDATE `{$tn}` SET {$set} WHERE {$where}", $eo);
		if($res) return true;

		$error = $eo['error'];
		return false;
	}
	#########################################################
	/**
	 *  @brief Set/update the owner of given record
	 *  
	 *  @param [in] $tn name of table
	 *  @param [in] $pk primary key value
	 *  @param [in] $user username to set as owner. If not provided (or false), update dateUpdated only
	 *  @return boolean indicating success/failure
	 */
	function set_record_owner($tn, $pk, $user = false) {
		$fields = [
			'memberID' => strtolower($user),
			'dateUpdated' => time(),
			'groupID' => get_group_id($user)
		];

		// don't update user if false
		if($user === false) unset($fields['memberID'], $fields['groupID']);

		$where_array = ['tableName' => $tn, 'pkValue' => $pk];
		$where = prepare_sql_set($where_array, ' AND ');
		if(!$where) return false;

		/* do we have an existing ownership record? */
		$res = sql("SELECT * FROM `membership_userrecords` WHERE {$where}", $eo);
		if($row = db_fetch_assoc($res)) {
			if($row['memberID'] == $user) return true; // owner already set to $user

			/* update owner and/or dateUpdated */
			$res = update('membership_userrecords', backtick_keys_once($fields), $where_array);
			return ($res ? true : false);
		}

		/* add new ownership record */
		$fields = array_merge($fields, $where_array, ['dateAdded' => time()]);
		$res = insert('membership_userrecords', backtick_keys_once($fields));
		return ($res ? true : false);
	}
	#########################################################
	/**
	 *  @brief get date/time format string for use in different cases.
	 *  
	 *  @param [in] $destination string, one of these: 'php' (see date function), 'mysql', 'moment'
	 *  @param [in] $datetime string, one of these: 'd' = date, 't' = time, 'dt' = both
	 *  @return string
	 */
	function app_datetime_format($destination = 'php', $datetime = 'd') {
		switch(strtolower($destination)) {
			case 'mysql':
				$date = '%m/%d/%Y';
				$time = '%h:%i:%s %p';
				break;
			case 'moment':
				$date = 'MM/DD/YYYY';
				$time = 'hh:mm:ss A';
				break;
			case 'phps': // php short format
				$date = 'n/j/Y';
				$time = 'h:i:s a';
				break;
			default: // php
				$date = 'm/d/Y';
				$time = 'h:i:s A';
		}

		$datetime = strtolower($datetime);
		if($datetime == 'dt' || $datetime == 'td') return "{$date} {$time}";
		if($datetime == 't') return $time;
		return $date; // default case of 'd'
	}
	#########################################################
	/**
	 *  @brief perform a test and return results
	 *  
	 *  @param [in] $subject string used as title of test
	 *  @param [in] $test callable function containing the test to be performed, should return true on success, false or a log string on error
	 *  @return test result
	 */
	function test($subject, $test) {
		ob_start();
		$result = $test();
		if($result === true) {
			echo "<div class=\"alert alert-success vspacer-sm\" style=\"padding: 0.2em;\"><i class=\"glyphicon glyphicon-ok hspacer-lg\"></i> {$subject}</div>";
			return ob_get_clean();
		}

		$log = '';
		if($result !== false) $log = "<pre style=\"margin-left: 2em; padding: 0.2em;\">{$result}</pre>";
		echo "<div class=\"alert alert-danger vspacer-sm\" style=\"padding: 0.2em;\"><i class=\"glyphicon glyphicon-remove hspacer-lg\"></i> <span class=\"text-bold\">{$subject}</span>{$log}</div>";
		return ob_get_clean();
	}
	#########################################################
	/**
	 *  @brief invoke a method of an object -- useful to call private/protected methods
	 *  
	 *  @param [in] $object instance of object containing the method
	 *  @param [in] $methodName string name of method to invoke
	 *  @param [in] $parameters array of parameters to pass to the method
	 *  @return the returned value from the invoked method
	 */
	function invoke_method(&$object, $methodName, array $parameters = []) {
		$reflection = new ReflectionClass(get_class($object));
		$method = $reflection->getMethod($methodName);
		$method->setAccessible(true);

		return $method->invokeArgs($object, $parameters);
	}
	#########################################################
	/**
	 *  @brief retrieve the value of a property of an object -- useful to retrieve private/protected props
	 *  
	 *  @param [in] $object instance of object containing the method
	 *  @param [in] $propName string name of property to retrieve
	 *  @return the returned value of the given property, or null if property doesn't exist
	 */
	function get_property(&$object, $propName) {
		$reflection = new ReflectionClass(get_class($object));
		try {
			$prop = $reflection->getProperty($propName);
		} catch(Exception $e) {
			return null;
		}

		$prop->setAccessible(true);

		return $prop->getValue($object);
	}

	#########################################################
	/**
	 *  @brief invoke a method of a static class -- useful to call private/protected methods
	 *  
	 *  @param [in] $class string name of the class containing the method
	 *  @param [in] $methodName string name of method to invoke
	 *  @param [in] $parameters array of parameters to pass to the method
	 *  @return the returned value from the invoked method
	 */
	function invoke_static_method($class, $methodName, array $parameters = []) {
		$reflection = new ReflectionClass($class);
		$method = $reflection->getMethod($methodName);
		$method->setAccessible(true);

		return $method->invokeArgs(null, $parameters);
	}
	#########################################################
	/**
	 *  @param [in] $app_datetime string, a datetime formatted in app-specific format
	 *  @return string, mysql-formatted datetime, 'yyyy-mm-dd H:i:s', or empty string on error
	 */
	function mysql_datetime($app_datetime, $date_format = null, $time_format = null) {
		$app_datetime = trim($app_datetime);

		if($date_format === null) $date_format = app_datetime_format('php', 'd');
		$date_separator = $date_format[1];
		if($time_format === null) $time_format = app_datetime_format('php', 't');
		$time24 = (strpos($time_format, 'H') !== false); // true if $time_format is 24hr rather than 12

		$date_regex = str_replace(
			array('Y', 'm', 'd', '/', '.'),
			array('([0-9]{4})', '(1[012]|0?[1-9])', '([12][0-9]|3[01]|0?[1-9])', '\/', '\.'),
			$date_format
		);

		$time_regex = str_replace(
			array('H', 'h', ':i', ':s'),
			array(
				'(1[0-9]|2[0-3]|0?[0-9])', 
				'(1[012]|0?[0-9])', 
				'(:([1-5][0-9]|0?[0-9]))', 
				'(:([1-5][0-9]|0?[0-9]))?'
			),
			$time_format
		);
		if(stripos($time_regex, ' a'))
			$time_regex = str_ireplace(' a', '\s*(am|pm|a|p)?', $time_regex);
		else
			$time_regex = str_ireplace( 'a', '\s*(am|pm|a|p)?', $time_regex);

		// extract date and time
		$time = '';
		$mat = [];
		$regex = "/^({$date_regex})(\s+{$time_regex})?$/i";
		$valid_dt = preg_match($regex, $app_datetime, $mat);
		if(!$valid_dt || count($mat) < 5) return ''; // invlaid datetime
		// if we have a time, get it and change 'a' or 'p' at the end to 'am'/'pm'
		if(count($mat) >= 8) $time = preg_replace('/(a|p)$/i', '$1m', trim($mat[5]));

		// extract date elements from regex match, given 1st 2 items are full string and full date
		$date_order = str_replace($date_separator, '', $date_format);
		$day = $mat[stripos($date_order, 'd') + 2];
		$month = $mat[stripos($date_order, 'm') + 2];
		$year = $mat[stripos($date_order, 'y') + 2];

		// convert time to 24hr format if necessary
		if($time && !$time24) $time = date('H:i:s', strtotime("2000-01-01 {$time}"));

		$mysql_datetime = trim("{$year}-{$month}-{$day} {$time}");

		// strtotime handles dates between 1902 and 2037 only
		// so we need another test date for dates outside this range ...
		$test = $mysql_datetime;
		if($year < 1902 || $year > 2037) $test = str_replace($year, '2000', $mysql_datetime);

		return (strtotime($test) ? $mysql_datetime : '');
	}
	#########################################################
	/**
	 *  @param [in] $mysql_datetime string, Mysql-formatted datetime
	 *  @param [in] $datetime string, one of these: 'd' = date, 't' = time, 'dt' = both
	 *  @return string, app-formatted datetime, or empty string on error
	 *  
	 *  @details works for formatting date, time and datetime, based on 2nd param
	 */  
	function app_datetime($mysql_datetime, $datetime = 'd') {
		$pyear = $myear = substr($mysql_datetime, 0, 4);

		// if date is 0 (0000-00-00) return empty string
		if(!$mysql_datetime || substr($mysql_datetime, 0, 10) == '0000-00-00') return '';

		// strtotime handles dates between 1902 and 2037 only
		// so we need a temp date for dates outside this range ...
		if($myear < 1902 || $myear > 2037) $pyear = 2000;
		$mysql_datetime = str_replace("$myear", "$pyear", $mysql_datetime);

		$ts = strtotime($mysql_datetime);
		if(!$ts) return '';

		$pdate = date(app_datetime_format('php', $datetime), $ts);
		return str_replace("$pyear", "$myear", $pdate);
	}
	#########################################################
	/**
	 *  @brief converts string from app-configured encoding to utf8
	 *  
	 *  @param [in] $str string to convert to utf8
	 *  @return utf8-encoded string
	 *  
	 *  @details if the constant 'datalist_db_encoding' is not defined, original string is returned
	 */
	function to_utf8($str) {
		if(!defined('datalist_db_encoding')) return $str;
		if(datalist_db_encoding == 'UTF-8') return $str;
		return iconv(datalist_db_encoding, 'UTF-8', $str);
	}
	#########################################################
	/**
	 *  @brief converts string from utf8 to app-configured encoding
	 *  
	 *  @param [in] $str string to convert from utf8
	 *  @return utf8-decoded string
	 *  
	 *  @details if the constant 'datalist_db_encoding' is not defined, original string is returned
	 */
	function from_utf8($str) {
		if(!strlen($str)) return $str;
		if(!defined('datalist_db_encoding')) return $str;
		if(datalist_db_encoding == 'UTF-8') return $str;
		return iconv('UTF-8', datalist_db_encoding, $str);
	}
	#########################################################
	/* deep trimmer function */
	function array_trim($arr) {
		if(!is_array($arr)) return trim($arr);
		return array_map('array_trim', $arr);
	}
	#########################################################
	function request_outside_admin_folder() {
		return (realpath(__DIR__) != realpath(dirname($_SERVER['SCRIPT_FILENAME'])));
	}
	#########################################################
	function get_parent_tables($table) {
		/* parents array:
		 * 'child table' => [parents], ...
		 *         where parents array:
		 *             'parent table' => [main lookup fields in child]
		 */
		$parents = [
			'Registros' => [
				'Estado_Conservacion' => ['id_Estado_Conservacion'],
				'Estado_Prestable' => ['id_Estado_Prestable'],
			],
			'Catalogo' => [
				'Registros' => ['Codigo_Registro'],
				'Tipo_Documento' => ['Tipo_Documento'],
				'Estado_Catalogacion' => ['id_Estado_Catalogacion'],
				'Autoridades' => ['Id_Autoridad'],
				'Lugares' => ['Id_Lugar'],
				'Editoriales' => ['id_Editorial'],
				'Materias' => ['Materia_3', 'Materia_2', 'Materia_1'],
			],
			'Circulacion' => [
				'Usuarios' => ['id_Usuario'],
				'Tipo_Usuario' => ['id_Tipo_usuario'],
				'Politica_de_Prestamos' => ['id_Politica_pretamo'],
				'Tipo_Documento' => ['id_Tipo_documento'],
				'Catalogo' => ['Libro_Prestado'],
				'Estado_Prestamo' => ['id_Estado_prestamo'],
				'Itemes' => ['Cod_Ejemplar'],
			],
			'Autoridades' => [
				'Tipo_Autoridad' => ['id_Tipo_autoridad'],
			],
			'Usuarios' => [
				'Tipo_Usuario' => ['id_Tipo_usuario'],
				'Estado_Suscripcion' => ['id_Estado_suscripcion'],
			],
			'Politica_de_Prestamos' => [
				'Tipo_Usuario' => ['id_Tipo_usuario'],
				'Tipo_Documento' => ['id_Tipo_documento'],
			],
			'Itemes' => [
				'Catalogo' => ['Cod_item'],
				'Estado_Conservacion' => ['Estado_Conservacion'],
			],
		];

		return isset($parents[$table]) ? $parents[$table] : [];
	}
	#########################################################
	function backtick_keys_once($arr_data) {
		return array_combine(
			/* add backticks to keys */
			array_map(
				function($e) { return '`' . trim($e, '`') . '`'; }, 
				array_keys($arr_data)
			), 
			/* and combine with values */
			array_values($arr_data)
		);
	}
	#########################################################
	function calculated_fields() {
		/*
		 * calculated fields configuration array, $calc:
		 *         table => [calculated fields], ..
		 *         where calculated fields:
		 *             field => query, ...
		 */
		return [
			'Estado_Conservacion' => [
			],
			'Estado_Prestable' => [
			],
			'Registros' => [
			],
			'Estado_Prestamo' => [
			],
			'Estado_Catalogacion' => [
			],
			'Editoriales' => [
			],
			'Catalogo' => [
			],
			'Circulacion' => [
			],
			'Tipo_Documento' => [
			],
			'Autoridades' => [
			],
			'Estado_Suscripcion' => [
			],
			'Usuarios' => [
			],
			'Politica_de_Prestamos' => [
			],
			'Lugares' => [
			],
			'Tipo_Autoridad' => [
			],
			'Tipo_Usuario' => [
			],
			'Materias' => [
			],
			'Itemes' => [
			],
		];
	}
	#########################################################
	function update_calc_fields($table, $id, $formulas, $mi = false) {
		if($mi === false) $mi = getMemberInfo();
		$pk = getPKFieldName($table);
		$safe_id = makeSafe($id);
		$eo = ['silentErrors' => true];
		$caluclations_made = [];
		$replace = [
			'%ID%' => $safe_id,
			'%USERNAME%' => makeSafe($mi['username']),
			'%GROUPID%' => makeSafe($mi['groupID']),
			'%GROUP%' => makeSafe($mi['group']),
			'%TABLENAME%' => makeSafe($table),
			'%PKFIELD%' => makeSafe($pk),
		];

		foreach($formulas as $field => $query) {
			// for queries that include unicode entities, replace them with actual unicode characters
			if(preg_match('/&#\d{2,5};/', $query)) $query = entitiesToUTF8($query);

			$query = str_replace(array_keys($replace), array_values($replace), $query);
			$calc_value = sqlValue($query);
			if($calc_value  === false) continue;

			// update calculated field
			$safe_calc_value = makeSafe($calc_value);
			$update_query = "UPDATE `{$table}` SET `{$field}`='{$safe_calc_value}' " .
				"WHERE `{$pk}`='{$safe_id}'";
			$res = sql($update_query, $eo);
			if($res) $caluclations_made[] = [
				'table' => $table,
				'id' => $id,
				'field' => $field,
				'value' => $calc_value,
			];
		}

		return $caluclations_made;
	}
	#########################################################
	function latest_jquery() {
		$jquery_dir = __DIR__ . '/../resources/jquery/js';

		$files = scandir($jquery_dir, SCANDIR_SORT_DESCENDING);
		foreach($files as $entry) {
			if(preg_match('/^jquery[-0-9\.]*\.min\.js$/i', $entry))
				return $entry;
		}

		return '';
	}
	#########################################################
	function existing_value($tn, $fn, $id, $cache = true) {
		/* cache results in records[tablename][id] */
		static $record = [];

		if($cache && !empty($record[$tn][$id])) return $record[$tn][$id][$fn];
		if(!$pk = getPKFieldName($tn)) return false;

		$sid = makeSafe($id);
		$eo = ['silentErrors' => true];
		$res = sql("SELECT * FROM `{$tn}` WHERE `{$pk}`='{$sid}'", $eo);
		$record[$tn][$id] = db_fetch_assoc($res);

		return $record[$tn][$id][$fn];
	}
	#########################################################
	function checkAppRequirements() {
		global $Translation;

		$reqErrors = [];
		$minPHP = '7.0';
		$phpVersion = floatval(phpversion());

		if($phpVersion < $minPHP)
			$reqErrors[] = str_replace(
				['<PHP_VERSION>', '<minPHP>'], 
				[$phpVersion, $minPHP], 
				$Translation['old php version']
			);

		if(!function_exists('mysqli_connect'))
			$reqErrors[] = str_replace('<EXTENSION>', 'mysqli', $Translation['extension not enabled']);

		if(!function_exists('mb_convert_encoding'))
			$reqErrors[] = str_replace('<EXTENSION>', 'mbstring', $Translation['extension not enabled']);

		if(!function_exists('iconv'))
			$reqErrors[] = str_replace('<EXTENSION>', 'iconv', $Translation['extension not enabled']);

		// end of checks

		if(!count($reqErrors)) return;

		exit(
			'<div style="padding: 3em; font-size: 1.5em; color: #A94442; line-height: 150%; font-family: arial; text-rendering: optimizelegibility; text-shadow: 0px 0px 1px;">' .
				'<ul><li>' .
				implode('</li><li>', $reqErrors) .
				'</li><ul>' .
			'</div>'
		);
	}
	#########################################################
	function getRecord($table, $id) {
		// get PK fieldname
		if(!$pk = getPKFieldName($table)) return false;

		$safeId = makeSafe($id);
		$eo = ['silentErrors' => true];
		$res = sql("SELECT * FROM `{$table}` WHERE `{$pk}`='{$safeId}'", $eo);
		return db_fetch_assoc($res);
	}
	#########################################################
	function guessMySQLDateTime($dt) {
		// extract date and time, assuming a space separator
		list($date, $time, $ampm) = preg_split('/\s+/', trim($dt));

		// if date is not already in mysql format, try mysql_datetime
		if(!(preg_match('/^[0-9]{4}-(0?[1-9]|1[0-2])-([1-2][0-9]|30|31|0?[1-9])$/', $date) && strtotime($date)))
			if(!$date = mysql_datetime($date)) return false;

		// if time 
		if($t = time12(trim("$time $ampm")))
			$time = time24($t);
		elseif($t = time24($time))
			$time = $t;
		else
			$time = '';

		return trim("$date $time");
	}
	#########################################################
	function lookupQuery($tn, $lookupField) {
		/* 
			This is the query accessible from the 'Advanced' window under the 'Lookup field' tab in AppGini.
			For auto-fill lookups, this is the same as the query of the main lookup field, except the second
			column is replaced by the caption of the auto-fill lookup field.
		*/
		$lookupQuery = [
			'Estado_Conservacion' => [
			],
			'Estado_Prestable' => [
			],
			'Registros' => [
				'id_Estado_Conservacion' => 'SELECT `Estado_Conservacion`.`id`, `Estado_Conservacion`.`Descripcion` FROM `Estado_Conservacion` ORDER BY 2',
				'id_Estado_Prestable' => 'SELECT `Estado_Prestable`.`id`, `Estado_Prestable`.`Descripcion` FROM `Estado_Prestable` ORDER BY 2',
			],
			'Estado_Prestamo' => [
			],
			'Estado_Catalogacion' => [
			],
			'Editoriales' => [
			],
			'Catalogo' => [
				'Codigo_Registro' => 'SELECT `Registros`.`id`, `Registros`.`Codigo_de_Registro` FROM `Registros` LEFT JOIN `Estado_Conservacion` as Estado_Conservacion1 ON `Estado_Conservacion1`.`id`=`Registros`.`id_Estado_Conservacion` LEFT JOIN `Estado_Prestable` as Estado_Prestable1 ON `Estado_Prestable1`.`id`=`Registros`.`id_Estado_Prestable` ORDER BY 2',
				'Cod_Barras' => 'SELECT `Registros`.`id`, `Registros`.`Codigo_Barras` FROM `Registros` LEFT JOIN `Estado_Conservacion` as Estado_Conservacion1 ON `Estado_Conservacion1`.`id`=`Registros`.`id_Estado_Conservacion` LEFT JOIN `Estado_Prestable` as Estado_Prestable1 ON `Estado_Prestable1`.`id`=`Registros`.`id_Estado_Prestable` ORDER BY 2',
				'Tipo_Documento' => 'SELECT `Tipo_Documento`.`id`, `Tipo_Documento`.`Descripcion` FROM `Tipo_Documento` ORDER BY 2',
				'id_Estado_Catalogacion' => 'SELECT `Estado_Catalogacion`.`id`, `Estado_Catalogacion`.`Descripcion` FROM `Estado_Catalogacion` ORDER BY 2',
				'Id_Autoridad' => 'SELECT `Autoridades`.`id`, `Autoridades`.`Nombre` FROM `Autoridades` LEFT JOIN `Tipo_Autoridad` as Tipo_Autoridad1 ON `Tipo_Autoridad1`.`id`=`Autoridades`.`id_Tipo_autoridad` ORDER BY 2',
				'Id_Lugar' => 'SELECT `Lugares`.`id`, `Lugares`.`Descripcion` FROM `Lugares` ORDER BY 2',
				'id_Editorial' => 'SELECT `Editoriales`.`id`, `Editoriales`.`Nombre` FROM `Editoriales` ORDER BY 2',
				'Materia_1' => 'SELECT `Materias`.`id`, `Materias`.`Descriptor` FROM `Materias` ORDER BY 2',
				'Materia_2' => 'SELECT `Materias`.`id`, `Materias`.`Descriptor` FROM `Materias` ORDER BY 2',
				'Materia_3' => 'SELECT `Materias`.`id`, `Materias`.`Descriptor` FROM `Materias` ORDER BY 2',
			],
			'Circulacion' => [
				'id_Usuario' => 'SELECT `Usuarios`.`id`, IF(CHAR_LENGTH(`Usuarios`.`Apellidos`) || CHAR_LENGTH(`Usuarios`.`Nombres`), CONCAT_WS(\'\', `Usuarios`.`Apellidos`, \', \', `Usuarios`.`Nombres`), \'\') FROM `Usuarios` LEFT JOIN `Tipo_Usuario` as Tipo_Usuario1 ON `Tipo_Usuario1`.`id`=`Usuarios`.`id_Tipo_usuario` LEFT JOIN `Estado_Suscripcion` as Estado_Suscripcion1 ON `Estado_Suscripcion1`.`id`=`Usuarios`.`id_Estado_suscripcion` ORDER BY 2',
				'Foto_Usuario' => 'SELECT `Usuarios`.`id`, `Usuarios`.`Foto` FROM `Usuarios` LEFT JOIN `Tipo_Usuario` as Tipo_Usuario1 ON `Tipo_Usuario1`.`id`=`Usuarios`.`id_Tipo_usuario` LEFT JOIN `Estado_Suscripcion` as Estado_Suscripcion1 ON `Estado_Suscripcion1`.`id`=`Usuarios`.`id_Estado_suscripcion` ORDER BY 2',
				'id_Tipo_usuario' => 'SELECT `Tipo_Usuario`.`id`, `Tipo_Usuario`.`Descripcion` FROM `Tipo_Usuario` ORDER BY 2',
				'id_Politica_pretamo' => 'SELECT `Politica_de_Prestamos`.`id`, IF(CHAR_LENGTH(`Politica_de_Prestamos`.`Duracion_Prestamo`) || CHAR_LENGTH(`Politica_de_Prestamos`.`Lim_Doc_Presado`), CONCAT_WS(\'\', `Politica_de_Prestamos`.`Duracion_Prestamo`, \' dias. L&#237;mite: \', `Politica_de_Prestamos`.`Lim_Doc_Presado`), \'\') FROM `Politica_de_Prestamos` LEFT JOIN `Tipo_Usuario` as Tipo_Usuario1 ON `Tipo_Usuario1`.`id`=`Politica_de_Prestamos`.`id_Tipo_usuario` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Politica_de_Prestamos`.`id_Tipo_documento` ORDER BY 2',
				'id_Tipo_documento' => 'SELECT `Tipo_Documento`.`id`, `Tipo_Documento`.`Descripcion` FROM `Tipo_Documento` ORDER BY 2',
				'id_Registro' => 'SELECT `Catalogo`.`id`, IF(    CHAR_LENGTH(`Registros1`.`Codigo_de_Registro`), CONCAT_WS(\'\',   `Registros1`.`Codigo_de_Registro`), \'\') FROM `Catalogo` LEFT JOIN `Registros` as Registros1 ON `Registros1`.`id`=`Catalogo`.`Codigo_Registro` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Catalogo`.`Tipo_Documento` LEFT JOIN `Estado_Catalogacion` as Estado_Catalogacion1 ON `Estado_Catalogacion1`.`id`=`Catalogo`.`id_Estado_Catalogacion` LEFT JOIN `Autoridades` as Autoridades1 ON `Autoridades1`.`id`=`Catalogo`.`Id_Autoridad` LEFT JOIN `Lugares` as Lugares1 ON `Lugares1`.`id`=`Catalogo`.`Id_Lugar` LEFT JOIN `Editoriales` as Editoriales1 ON `Editoriales1`.`id`=`Catalogo`.`id_Editorial` LEFT JOIN `Materias` as Materias1 ON `Materias1`.`id`=`Catalogo`.`Materia_1` LEFT JOIN `Materias` as Materias2 ON `Materias2`.`id`=`Catalogo`.`Materia_2` LEFT JOIN `Materias` as Materias3 ON `Materias3`.`id`=`Catalogo`.`Materia_3` ORDER BY 2',
				'Libro_Prestado' => 'SELECT `Catalogo`.`id`, `Catalogo`.`Titulo` FROM `Catalogo` LEFT JOIN `Registros` as Registros1 ON `Registros1`.`id`=`Catalogo`.`Codigo_Registro` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Catalogo`.`Tipo_Documento` LEFT JOIN `Estado_Catalogacion` as Estado_Catalogacion1 ON `Estado_Catalogacion1`.`id`=`Catalogo`.`id_Estado_Catalogacion` LEFT JOIN `Autoridades` as Autoridades1 ON `Autoridades1`.`id`=`Catalogo`.`Id_Autoridad` LEFT JOIN `Lugares` as Lugares1 ON `Lugares1`.`id`=`Catalogo`.`Id_Lugar` LEFT JOIN `Editoriales` as Editoriales1 ON `Editoriales1`.`id`=`Catalogo`.`id_Editorial` LEFT JOIN `Materias` as Materias1 ON `Materias1`.`id`=`Catalogo`.`Materia_1` LEFT JOIN `Materias` as Materias2 ON `Materias2`.`id`=`Catalogo`.`Materia_2` LEFT JOIN `Materias` as Materias3 ON `Materias3`.`id`=`Catalogo`.`Materia_3` ORDER BY 2',
				'Portada_libro' => 'SELECT `Catalogo`.`id`, `Catalogo`.`Portada` FROM `Catalogo` LEFT JOIN `Registros` as Registros1 ON `Registros1`.`id`=`Catalogo`.`Codigo_Registro` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Catalogo`.`Tipo_Documento` LEFT JOIN `Estado_Catalogacion` as Estado_Catalogacion1 ON `Estado_Catalogacion1`.`id`=`Catalogo`.`id_Estado_Catalogacion` LEFT JOIN `Autoridades` as Autoridades1 ON `Autoridades1`.`id`=`Catalogo`.`Id_Autoridad` LEFT JOIN `Lugares` as Lugares1 ON `Lugares1`.`id`=`Catalogo`.`Id_Lugar` LEFT JOIN `Editoriales` as Editoriales1 ON `Editoriales1`.`id`=`Catalogo`.`id_Editorial` LEFT JOIN `Materias` as Materias1 ON `Materias1`.`id`=`Catalogo`.`Materia_1` LEFT JOIN `Materias` as Materias2 ON `Materias2`.`id`=`Catalogo`.`Materia_2` LEFT JOIN `Materias` as Materias3 ON `Materias3`.`id`=`Catalogo`.`Materia_3` ORDER BY 2',
				'id_Estado_prestamo' => 'SELECT `Estado_Prestamo`.`id`, `Estado_Prestamo`.`Descripcion` FROM `Estado_Prestamo` ORDER BY 2',
				'Ejemp_Disponibles' => 'SELECT `Catalogo`.`id`, `Catalogo`.`Ejemplares` FROM `Catalogo` LEFT JOIN `Registros` as Registros1 ON `Registros1`.`id`=`Catalogo`.`Codigo_Registro` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Catalogo`.`Tipo_Documento` LEFT JOIN `Estado_Catalogacion` as Estado_Catalogacion1 ON `Estado_Catalogacion1`.`id`=`Catalogo`.`id_Estado_Catalogacion` LEFT JOIN `Autoridades` as Autoridades1 ON `Autoridades1`.`id`=`Catalogo`.`Id_Autoridad` LEFT JOIN `Lugares` as Lugares1 ON `Lugares1`.`id`=`Catalogo`.`Id_Lugar` LEFT JOIN `Editoriales` as Editoriales1 ON `Editoriales1`.`id`=`Catalogo`.`id_Editorial` LEFT JOIN `Materias` as Materias1 ON `Materias1`.`id`=`Catalogo`.`Materia_1` LEFT JOIN `Materias` as Materias2 ON `Materias2`.`id`=`Catalogo`.`Materia_2` LEFT JOIN `Materias` as Materias3 ON `Materias3`.`id`=`Catalogo`.`Materia_3` ORDER BY 2',
				'Item' => 'SELECT `Catalogo`.`id`, `Catalogo`.`Item` FROM `Catalogo` LEFT JOIN `Registros` as Registros1 ON `Registros1`.`id`=`Catalogo`.`Codigo_Registro` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Catalogo`.`Tipo_Documento` LEFT JOIN `Estado_Catalogacion` as Estado_Catalogacion1 ON `Estado_Catalogacion1`.`id`=`Catalogo`.`id_Estado_Catalogacion` LEFT JOIN `Autoridades` as Autoridades1 ON `Autoridades1`.`id`=`Catalogo`.`Id_Autoridad` LEFT JOIN `Lugares` as Lugares1 ON `Lugares1`.`id`=`Catalogo`.`Id_Lugar` LEFT JOIN `Editoriales` as Editoriales1 ON `Editoriales1`.`id`=`Catalogo`.`id_Editorial` LEFT JOIN `Materias` as Materias1 ON `Materias1`.`id`=`Catalogo`.`Materia_1` LEFT JOIN `Materias` as Materias2 ON `Materias2`.`id`=`Catalogo`.`Materia_2` LEFT JOIN `Materias` as Materias3 ON `Materias3`.`id`=`Catalogo`.`Materia_3` ORDER BY 2',
				'Cod_Ejemplar' => 'SELECT `Itemes`.`id`, `Itemes`.`Cod_Ejemplar` FROM `Itemes` LEFT JOIN `Catalogo` as Catalogo1 ON `Catalogo1`.`id`=`Itemes`.`Cod_item` LEFT JOIN `Estado_Conservacion` as Estado_Conservacion1 ON `Estado_Conservacion1`.`id`=`Itemes`.`Estado_Conservacion` ORDER BY 2',
			],
			'Tipo_Documento' => [
			],
			'Autoridades' => [
				'id_Tipo_autoridad' => 'SELECT `Tipo_Autoridad`.`id`, `Tipo_Autoridad`.`Descripcion` FROM `Tipo_Autoridad` ORDER BY 2',
			],
			'Estado_Suscripcion' => [
			],
			'Usuarios' => [
				'id_Tipo_usuario' => 'SELECT `Tipo_Usuario`.`id`, `Tipo_Usuario`.`Descripcion` FROM `Tipo_Usuario` ORDER BY 2',
				'id_Estado_suscripcion' => 'SELECT `Estado_Suscripcion`.`id`, `Estado_Suscripcion`.`Descripcion` FROM `Estado_Suscripcion` ORDER BY 2',
			],
			'Politica_de_Prestamos' => [
				'id_Tipo_usuario' => 'SELECT `Tipo_Usuario`.`id`, `Tipo_Usuario`.`Descripcion` FROM `Tipo_Usuario` ORDER BY 2',
				'id_Tipo_documento' => 'SELECT `Tipo_Documento`.`id`, `Tipo_Documento`.`Descripcion` FROM `Tipo_Documento` ORDER BY 2',
			],
			'Lugares' => [
			],
			'Tipo_Autoridad' => [
			],
			'Tipo_Usuario' => [
			],
			'Materias' => [
			],
			'Itemes' => [
				'Cod_item' => 'SELECT `Catalogo`.`id`, `Catalogo`.`Item` FROM `Catalogo` LEFT JOIN `Registros` as Registros1 ON `Registros1`.`id`=`Catalogo`.`Codigo_Registro` LEFT JOIN `Tipo_Documento` as Tipo_Documento1 ON `Tipo_Documento1`.`id`=`Catalogo`.`Tipo_Documento` LEFT JOIN `Estado_Catalogacion` as Estado_Catalogacion1 ON `Estado_Catalogacion1`.`id`=`Catalogo`.`id_Estado_Catalogacion` LEFT JOIN `Autoridades` as Autoridades1 ON `Autoridades1`.`id`=`Catalogo`.`Id_Autoridad` LEFT JOIN `Lugares` as Lugares1 ON `Lugares1`.`id`=`Catalogo`.`Id_Lugar` LEFT JOIN `Editoriales` as Editoriales1 ON `Editoriales1`.`id`=`Catalogo`.`id_Editorial` LEFT JOIN `Materias` as Materias1 ON `Materias1`.`id`=`Catalogo`.`Materia_1` LEFT JOIN `Materias` as Materias2 ON `Materias2`.`id`=`Catalogo`.`Materia_2` LEFT JOIN `Materias` as Materias3 ON `Materias3`.`id`=`Catalogo`.`Materia_3` ORDER BY 2',
				'Estado_Conservacion' => 'SELECT `Estado_Conservacion`.`id`, `Estado_Conservacion`.`Descripcion` FROM `Estado_Conservacion` ORDER BY 2',
			],
		];

		return $lookupQuery[$tn][$lookupField];
	}

	#########################################################
	function pkGivenLookupText($val, $tn, $lookupField, $falseIfNotFound = false) {
		static $cache = [];
		if(isset($cache[$tn][$lookupField][$val])) return $cache[$tn][$lookupField][$val];

		if(!$lookupQuery = lookupQuery($tn, $lookupField)) {
			$cache[$tn][$lookupField][$val] = false;
			return false;
		}

		$m = [];

		// quit if query can't be parsed
		if(!preg_match('/select\s+(.*?),\s+(.*?)\s+from\s+(.*)/i', $lookupQuery, $m)) {
			$cache[$tn][$lookupField][$val] = false;
			return false;
		}

		list($all, $pkField, $lookupField, $from) = $m;
		$from = preg_replace('/\s+order\s+by.*$/i', '', $from);
		if(!$lookupField || !$from) {
			$cache[$tn][$lookupField][$val] = false;
			return false;
		}

		// append WHERE if not already there
		if(!preg_match('/\s+where\s+/i', $from)) $from .= ' WHERE 1=1 AND';

		$safeVal = makeSafe($val);
		$id = sqlValue("SELECT {$pkField} FROM {$from} {$lookupField}='{$safeVal}'");
		if($id !== false) {
			$cache[$tn][$lookupField][$val] = $id;
			return $id;
		}

		// no corresponding PK value found
		if($falseIfNotFound) {
			$cache[$tn][$lookupField][$val] = false;
			return false;
		} else {
			$cache[$tn][$lookupField][$val] = $val;
			return $val;
		}
	}
	#########################################################
	function userCanImport() {
		$mi = getMemberInfo();
		$safeUser = makeSafe($mi['username']);
		$groupID = intval($mi['groupID']);

		// admins can always import
		if($mi['group'] == 'Admins') return true;

		// anonymous users can never import
		if($mi['group'] == config('adminConfig')['anonymousGroup']) return false;

		// specific user can import?
		if(sqlValue("SELECT COUNT(1) FROM `membership_users` WHERE `memberID`='{$safeUser}' AND `allowCSVImport`='1'")) return true;

		// user's group can import?
		if(sqlValue("SELECT COUNT(1) FROM `membership_groups` WHERE `groupID`='{$groupID}' AND `allowCSVImport`='1'")) return true;

		return false;
	}
	#########################################################
	function parseTemplate($template) {
		if(trim($template) == '') return $template;

		global $Translation;
		foreach($Translation as $symbol => $trans)
			$template = str_replace("<%%TRANSLATION($symbol)%%>", $trans, $template);

		// Correct <MaxSize> and <FileTypes> to prevent invalid HTML
		$template = str_replace(['<MaxSize>', '<FileTypes>'], ['{MaxSize}', '{FileTypes}'], $template);
		$template = str_replace('<%%BASE_UPLOAD_PATH%%>', getUploadDir(''), $template);

		return $template;
	}
	#########################################################
	function getUploadDir($dir = '') {
		if($dir == '') $dir = config('adminConfig')['baseUploadPath'];

		return rtrim($dir, '\\/') . '/';
	}
	#########################################################
	function bgStyleToClass($html) {
		return preg_replace(
			'/ style="background-color: rgb\((\d+), (\d+), (\d+)\);"/',
			' class="nicedit-bg" data-nicedit_r="$1" data-nicedit_g="$2" data-nicedit_b="$3"',
			$html
		);
	}
	#########################################################
	function assocArrFilter($arr, $func) {
		if(!is_array($arr) || !count($arr)) return $arr;
		if(!is_callable($func)) return false;

		$filtered = [];
		foreach ($arr as $key => $value)
			if(call_user_func_array($func, [$key, $value]) === true)
				$filtered[$key] = $value;

		return $filtered;
	}
	#########################################################
	function setUserData($key, $value = null) {
		$data = [];

		$user = makeSafe(getMemberInfo()['username']);
		if(!$user) return false;

		$dataJson = sqlValue("SELECT `data` FROM `membership_users` WHERE `memberID`='$user'");
		if($dataJson) {
			$data = @json_decode($dataJson, true);
			if(!$data) $data = [];
		}

		$data[$key] = $value;

		return update(
			'membership_users', 
			['data' => @json_encode($data, JSON_PARTIAL_OUTPUT_ON_ERROR)], 
			['memberID' => $user]
		);
	}
	#########################################################
	function getUserData($key) {
		$user = makeSafe(getMemberInfo()['username']);
		if(!$user) return null;

		$dataJson = sqlValue("SELECT `data` FROM `membership_users` WHERE `memberID`='$user'");
		if(!$dataJson) return null;

		$data = @json_decode($dataJson, true);
		if(!$data) return null;

		if(!isset($data[$key])) return null;

		return $data[$key];
	}
	#########################################################
	/*
	 Usage:
	 breakpoint(__FILE__, __LINE__, 'message here');
	 */
	function breakpoint($file, $line, $msg) {
		if(!DEBUG_MODE) return;
		if(strpos($_SERVER['PHP_SELF'], 'ajax_check_login.php') !== false) return;
		static $startTs = null;
		static $fp = null;
		if(!$startTs) $startTs = microtime(true);
		if(!$fp) {
			$logFile = __DIR__ . '/breakpoint.csv';
			$isNew = !is_file($logFile);
			$fp = fopen($logFile, 'a');
			if($isNew) fputcsv($fp, [
				'Time offset',
				'Requested script',
				'Running script',
				'Line #',
				'Message',
			]);

			fputcsv($fp, [date('Y-m-d H:i:s'), $_SERVER['REQUEST_URI'], '', '', '']);
		}

		fputcsv($fp, [
			number_format(microtime(true) - $startTs, 3),
			basename($_SERVER['PHP_SELF']),
			str_replace(__DIR__, '', $file),
			$line,
			is_array($msg) ? json_encode($msg) : $msg,
		]);
	}
	#########################################################
	function denyAccess($msg = null) {
		@header($_SERVER['SERVER_PROTOCOL'] . ' 403 Access Denied');
		die($msg);
	}
