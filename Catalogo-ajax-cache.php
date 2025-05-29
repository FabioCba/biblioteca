<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Catalogo';

		/* data for selected record, or defaults if none is selected */
		var data = {
			Codigo_Registro: <?php echo json_encode(['id' => $rdata['Codigo_Registro'], 'value' => $rdata['Codigo_Registro'], 'text' => $jdata['Codigo_Registro']]); ?>,
			Cod_Barras: <?php echo json_encode($jdata['Cod_Barras']); ?>,
			Tipo_Documento: <?php echo json_encode(['id' => $rdata['Tipo_Documento'], 'value' => $rdata['Tipo_Documento'], 'text' => $jdata['Tipo_Documento']]); ?>,
			id_Estado_Catalogacion: <?php echo json_encode(['id' => $rdata['id_Estado_Catalogacion'], 'value' => $rdata['id_Estado_Catalogacion'], 'text' => $jdata['id_Estado_Catalogacion']]); ?>,
			Id_Autoridad: <?php echo json_encode(['id' => $rdata['Id_Autoridad'], 'value' => $rdata['Id_Autoridad'], 'text' => $jdata['Id_Autoridad']]); ?>,
			Id_Lugar: <?php echo json_encode(['id' => $rdata['Id_Lugar'], 'value' => $rdata['Id_Lugar'], 'text' => $jdata['Id_Lugar']]); ?>,
			id_Editorial: <?php echo json_encode(['id' => $rdata['id_Editorial'], 'value' => $rdata['id_Editorial'], 'text' => $jdata['id_Editorial']]); ?>,
			Materia_1: <?php echo json_encode(['id' => $rdata['Materia_1'], 'value' => $rdata['Materia_1'], 'text' => $jdata['Materia_1']]); ?>,
			Materia_2: <?php echo json_encode(['id' => $rdata['Materia_2'], 'value' => $rdata['Materia_2'], 'text' => $jdata['Materia_2']]); ?>,
			Materia_3: <?php echo json_encode(['id' => $rdata['Materia_3'], 'value' => $rdata['Materia_3'], 'text' => $jdata['Materia_3']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for Codigo_Registro */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Codigo_Registro' && d.id == data.Codigo_Registro.id)
				return { results: [ data.Codigo_Registro ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for Codigo_Registro autofills */
		cache.addCheck(function(u, d) {
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'Codigo_Registro' && d.id == data.Codigo_Registro.id) {
				$j('#Cod_Barras' + d[rnd]).html(data.Cod_Barras);
				return true;
			}

			return false;
		});

		/* saved value for Tipo_Documento */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Tipo_Documento' && d.id == data.Tipo_Documento.id)
				return { results: [ data.Tipo_Documento ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for id_Estado_Catalogacion */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_Estado_Catalogacion' && d.id == data.id_Estado_Catalogacion.id)
				return { results: [ data.id_Estado_Catalogacion ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for Id_Autoridad */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Id_Autoridad' && d.id == data.Id_Autoridad.id)
				return { results: [ data.Id_Autoridad ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for Id_Lugar */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Id_Lugar' && d.id == data.Id_Lugar.id)
				return { results: [ data.Id_Lugar ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for id_Editorial */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_Editorial' && d.id == data.id_Editorial.id)
				return { results: [ data.id_Editorial ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for Materia_1 */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Materia_1' && d.id == data.Materia_1.id)
				return { results: [ data.Materia_1 ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for Materia_2 */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Materia_2' && d.id == data.Materia_2.id)
				return { results: [ data.Materia_2 ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for Materia_3 */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Materia_3' && d.id == data.Materia_3.id)
				return { results: [ data.Materia_3 ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

