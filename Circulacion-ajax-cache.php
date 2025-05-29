<?php
	$rdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $rdata)));
	$jdata = array_map('to_utf8', array_map('safe_html', array_map('html_attr_tags_ok', $jdata)));
?>
<script>
	$j(function() {
		var tn = 'Circulacion';

		/* data for selected record, or defaults if none is selected */
		var data = {
			id_Usuario: <?php echo json_encode(['id' => $rdata['id_Usuario'], 'value' => $rdata['id_Usuario'], 'text' => $jdata['id_Usuario']]); ?>,
			Foto_Usuario: (<?php echo strlen($jdata['Foto_Usuario']); ?> > 0 ? '<a href="<?php echo getUploadDir('') . addslashes(str_replace(["\r", "\n"], '', $jdata['Foto_Usuario'])); ?>" data-lightbox="Circulacion_dv"><img src="thumbnail.php?i=<?php echo urlencode($jdata['Foto_Usuario']); ?>&t=Usuarios&f=Foto&v=dv" class="img-thumbnail"></a>' : '<img src="photo.gif" class="img-thumbnail">'),
			id_Tipo_usuario: <?php echo json_encode(['id' => $rdata['id_Tipo_usuario'], 'value' => $rdata['id_Tipo_usuario'], 'text' => $jdata['id_Tipo_usuario']]); ?>,
			id_Politica_pretamo: <?php echo json_encode(['id' => $rdata['id_Politica_pretamo'], 'value' => $rdata['id_Politica_pretamo'], 'text' => $jdata['id_Politica_pretamo']]); ?>,
			id_Tipo_documento: <?php echo json_encode(['id' => $rdata['id_Tipo_documento'], 'value' => $rdata['id_Tipo_documento'], 'text' => $jdata['id_Tipo_documento']]); ?>,
			id_Registro: <?php echo json_encode($jdata['id_Registro']); ?>,
			Libro_Prestado: <?php echo json_encode(['id' => $rdata['Libro_Prestado'], 'value' => $rdata['Libro_Prestado'], 'text' => $jdata['Libro_Prestado']]); ?>,
			Portada_libro: (<?php echo strlen($jdata['Portada_libro']); ?> > 0 ? '<a href="<?php echo getUploadDir('') . addslashes(str_replace(["\r", "\n"], '', $jdata['Portada_libro'])); ?>" data-lightbox="Circulacion_dv"><img src="thumbnail.php?i=<?php echo urlencode($jdata['Portada_libro']); ?>&t=Catalogo&f=Portada&v=dv" class="img-thumbnail"></a>' : '<img src="photo.gif" class="img-thumbnail">'),
			id_Estado_prestamo: <?php echo json_encode(['id' => $rdata['id_Estado_prestamo'], 'value' => $rdata['id_Estado_prestamo'], 'text' => $jdata['id_Estado_prestamo']]); ?>,
			Ejemp_Disponibles: <?php echo json_encode($jdata['Ejemp_Disponibles']); ?>,
			Item: <?php echo json_encode($jdata['Item']); ?>,
			Cod_Ejemplar: <?php echo json_encode(['id' => $rdata['Cod_Ejemplar'], 'value' => $rdata['Cod_Ejemplar'], 'text' => $jdata['Cod_Ejemplar']]); ?>
		};

		/* initialize or continue using AppGini.cache for the current table */
		AppGini.cache = AppGini.cache || {};
		AppGini.cache[tn] = AppGini.cache[tn] || AppGini.ajaxCache();
		var cache = AppGini.cache[tn];

		/* saved value for id_Usuario */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_Usuario' && d.id == data.id_Usuario.id)
				return { results: [ data.id_Usuario ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for id_Usuario autofills */
		cache.addCheck(function(u, d) {
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'id_Usuario' && d.id == data.id_Usuario.id) {
				$j('#Foto_Usuario' + d[rnd]).html(data.Foto_Usuario);
				return true;
			}

			return false;
		});

		/* saved value for id_Tipo_usuario */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_Tipo_usuario' && d.id == data.id_Tipo_usuario.id)
				return { results: [ data.id_Tipo_usuario ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for id_Politica_pretamo */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_Politica_pretamo' && d.id == data.id_Politica_pretamo.id)
				return { results: [ data.id_Politica_pretamo ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for id_Tipo_documento */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_Tipo_documento' && d.id == data.id_Tipo_documento.id)
				return { results: [ data.id_Tipo_documento ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for Libro_Prestado */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Libro_Prestado' && d.id == data.Libro_Prestado.id)
				return { results: [ data.Libro_Prestado ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for Libro_Prestado autofills */
		cache.addCheck(function(u, d) {
			if(u != tn + '_autofill.php') return false;

			for(var rnd in d) if(rnd.match(/^rnd/)) break;

			if(d.mfk == 'Libro_Prestado' && d.id == data.Libro_Prestado.id) {
				$j('#id_Registro' + d[rnd]).html(data.id_Registro);
				$j('#Portada_libro' + d[rnd]).html(data.Portada_libro);
				$j('#Ejemp_Disponibles' + d[rnd]).html(data.Ejemp_Disponibles);
				$j('#Item' + d[rnd]).html(data.Item);
				return true;
			}

			return false;
		});

		/* saved value for id_Estado_prestamo */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'id_Estado_prestamo' && d.id == data.id_Estado_prestamo.id)
				return { results: [ data.id_Estado_prestamo ], more: false, elapsed: 0.01 };
			return false;
		});

		/* saved value for Cod_Ejemplar */
		cache.addCheck(function(u, d) {
			if(u != 'ajax_combo.php') return false;
			if(d.t == tn && d.f == 'Cod_Ejemplar' && d.id == data.Cod_Ejemplar.id)
				return { results: [ data.Cod_Ejemplar ], more: false, elapsed: 0.01 };
			return false;
		});

		cache.start();
	});
</script>

