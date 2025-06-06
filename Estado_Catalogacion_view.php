<?php
// This script and data application were generated by AppGini 22.14
// Download AppGini for free from https://bigprof.com/appgini/download/

	include_once(__DIR__ . '/lib.php');
	@include_once(__DIR__ . '/hooks/Estado_Catalogacion.php');
	include_once(__DIR__ . '/Estado_Catalogacion_dml.php');

	// mm: can the current member access this page?
	$perm = getTablePermissions('Estado_Catalogacion');
	if(!$perm['access']) {
		echo error_message($Translation['tableAccessDenied']);
		exit;
	}

	$x = new DataList;
	$x->TableName = 'Estado_Catalogacion';

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = [
		"`Estado_Catalogacion`.`id`" => "id",
		"`Estado_Catalogacion`.`Descripcion`" => "Descripcion",
	];
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = [
		1 => '`Estado_Catalogacion`.`id`',
		2 => 2,
	];

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = [
		"`Estado_Catalogacion`.`id`" => "id",
		"`Estado_Catalogacion`.`Descripcion`" => "Descripcion",
	];
	// Fields that can be filtered
	$x->QueryFieldsFilters = [
		"`Estado_Catalogacion`.`id`" => "ID",
		"`Estado_Catalogacion`.`Descripcion`" => "Descripcion",
	];

	// Fields that can be quick searched
	$x->QueryFieldsQS = [
		"`Estado_Catalogacion`.`id`" => "id",
		"`Estado_Catalogacion`.`Descripcion`" => "Descripcion",
	];

	// Lookup fields that can be used as filterers
	$x->filterers = [];

	$x->QueryFrom = "`Estado_Catalogacion` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm['view'] == 0 ? 1 : 0);
	$x->AllowDelete = $perm['delete'];
	$x->AllowMassDelete = (getLoggedAdmin() !== false);
	$x->AllowInsert = $perm['insert'];
	$x->AllowUpdate = $perm['edit'];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = (getLoggedAdmin() !== false);
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowPrintingDV = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 10;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation['quick search'];
	$x->ScriptFileName = 'Estado_Catalogacion_view.php';
	$x->TableTitle = 'Estado Catalogacion';
	$x->TableIcon = 'resources/table_icons/application_view_tile.png';
	$x->PrimaryKey = '`Estado_Catalogacion`.`id`';

	$x->ColWidth = [150, ];
	$x->ColCaption = ['Descripcion', ];
	$x->ColFieldName = ['Descripcion', ];
	$x->ColNumber  = [2, ];

	// template paths below are based on the app main directory
	$x->Template = 'templates/Estado_Catalogacion_templateTV.html';
	$x->SelectedTemplate = 'templates/Estado_Catalogacion_templateTVS.html';
	$x->TemplateDV = 'templates/Estado_Catalogacion_templateDV.html';
	$x->TemplateDVP = 'templates/Estado_Catalogacion_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HasCalculatedFields = false;
	$x->AllowConsoleLog = false;
	$x->AllowDVNavigation = true;

	// hook: Estado_Catalogacion_init
	$render = true;
	if(function_exists('Estado_Catalogacion_init')) {
		$args = [];
		$render = Estado_Catalogacion_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: Estado_Catalogacion_header
	$headerCode = '';
	if(function_exists('Estado_Catalogacion_header')) {
		$args = [];
		$headerCode = Estado_Catalogacion_header($x->ContentType, getMemberInfo(), $args);
	}

	if(!$headerCode) {
		include_once(__DIR__ . '/header.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/header.php');
		echo str_replace('<%%HEADER%%>', ob_get_clean(), $headerCode);
	}

	echo $x->HTML;

	// hook: Estado_Catalogacion_footer
	$footerCode = '';
	if(function_exists('Estado_Catalogacion_footer')) {
		$args = [];
		$footerCode = Estado_Catalogacion_footer($x->ContentType, getMemberInfo(), $args);
	}

	if(!$footerCode) {
		include_once(__DIR__ . '/footer.php'); 
	} else {
		ob_start();
		include_once(__DIR__ . '/footer.php');
		echo str_replace('<%%FOOTER%%>', ob_get_clean(), $footerCode);
	}
