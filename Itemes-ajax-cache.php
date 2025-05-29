<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Itemes';

		/* data for selected record, or defaults if none is selected */
		var data = {
			Cod_item: <?php echo json_encode(['id' => $rdata['Cod_item'], 'value' => $rdata['Cod_item'], 'text' => $jdata['Cod_item']]); ?>,
			Estado_Conservacion: <?php echo json_encode(['id' => $rdata['Estado_Conservacion'], 'value' => $rdata['Estado_Conservacion'], 'text' => $jdata['Estado_Conservacion']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for Cod_item */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Cod_item' && d.id == data.Cod_item.id)
				return { results: [ data.Cod_item ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for Estado_Conservacion */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Estado_Conservacion' && d.id == data.Estado_Conservacion.id)
				return { results: [ data.Estado_Conservacion ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

