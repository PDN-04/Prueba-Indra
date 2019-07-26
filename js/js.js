$(document).ready(function()
{
	// FILTRAR
	$('.buscar').click(function()
	{
		$(this).parents('form').submit();
	});

	$('.limpiar').click(function()
	{
		$(this).parents('form').find('input[name=busqueda]').val('');
		
		$('input[name=campo_orden]').val('');
		$('input[name=tipo_orden]').val('');

		$(this).parents('form').submit();
	});

	// ORDENAR
	var orden		= $('input[name=campo_orden]').val();
	var tipo_orden	= $('input[name=tipo_orden]').val();

	$('.listado th').click(function()
	{
		if (typeof $(this).attr('rel') !== typeof undefined)
		{
			if (orden == $(this).attr('rel'))
			{
				if (tipo_orden == 'DESC')
					$('input[name=tipo_orden]').val('ASC');
				else
					$('input[name=tipo_orden]').val('DESC');
			}
			else
			{
				$('input[name=campo_orden]').val($(this).attr('rel'));
				$('input[name=tipo_orden]').val('DESC');
			}

			$(this).parents('form').submit();
		}
	});

	if (typeof orden !== typeof undefined && orden != '')
		$('.listado th[rel=' + orden + '] span').addClass(tipo_orden.toLowerCase());

	// FORMULARIO
	$('.guardar').click(function()
	{
		$(this).parents('form').submit();
	});

	// ERROR
	$('.cerrar_error').click(function()
	{
		$('.fondo_error').fadeOut();
	});

	// LISTADO
	$('.listado').each(function(index, el)
	{
		$('<div class="scroll"></div>').insertBefore($(this));
		
		$($(this)).appendTo($(this).prev());
	});
});