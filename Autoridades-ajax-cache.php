<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Autoridades';

		/* data for selected record, or defaults if none is selected */
		var data = {
			id_Tipo_autoridad: <?php echo json_encode(['id' => $rdata['id_Tipo_autoridad'], 'value' => $rdata['id_Tipo_autoridad'], 'text' => $jdata['id_Tipo_autoridad']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for id_Tipo_autoridad */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_Tipo_autoridad' && d.id == data.id_Tipo_autoridad.id)
				return { results: [ data.id_Tipo_autoridad ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

