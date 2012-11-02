$(document).ready(function(){
	$('.compare-link').on('click', function( element ){
		element.preventDefault();
		var link = $(this);
		
		var productID = link.parent().next().find('span').html();
		
		// добавить товар в список сравнения
		$.ajax({
			url: link.attr('href'),
			type: "GET",
			data: { 
				'id': productID 
			},
			dataType: "json",
			success: function( resultJSON ) {
				// заменить ссылку
				link.fadeOut('fast', function(){
					link.attr('href', resultJSON.href ).text(resultJSON.text).removeClass('compare-link').fadeIn('fast');
					link.unbind('click');
				});
				
				// заменить общее количество товаров в сравнении
				var totalCompareProductsLink = $( '.comparison-text' ).first();
				totalCompareProductsLink.fadeOut('fast', function(){
					totalCompareProductsLink.attr('href', resultJSON.href ).text(resultJSON.totalText).removeClass('hidden').fadeIn('fast');
				});
			}
		});
	});
});