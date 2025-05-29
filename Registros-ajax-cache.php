<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Registros';

		/* data for selected record, or defaults if none is selected */
		var data = {
			id_Estado_Conservacion: <?php echo json_encode(['id' => $rdata['id_Estado_Conservacion'], 'value' => $rdata['id_Estado_Conservacion'], 'text' => $jdata['id_Estado_Conservacion']]); ?>,
			id_Estado_Prestable: <?php echo json_encode(['id' => $rdata['id_Estado_Prestable'], 'value' => $rdata['id_Estado_Prestable'], 'text' => $jdata['id_Estado_Prestable']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for id_Estado_Conservacion */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_Estado_Conservacion' && d.id == data.id_Estado_Conservacion.id)
				return { results: [ data.id_Estado_Conservacion ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for id_Estado_Prestable */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_Estado_Prestable' && d.id == data.id_Estado_Prestable.id)
				return { results: [ data.id_Estado_Prestable ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

