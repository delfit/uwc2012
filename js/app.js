// дождаться загрузки документа
$(document).ready(function(){
	// скрыть по-умолчанию кнопку "Вверх"
	$(".top-link").hide();
    
    $(function () {
        $(window).scroll(function () {
			// показать кнопку при скролле вниз
            if ($(this).scrollTop() > 100) {
                $('.top-link').fadeIn();
            } 
			// скрыть кнопку при скролле вверх
			else {
                $('.top-link').fadeOut();
            }
        });
    });
	
	
	
	
	// обработчик кнопки добавления товара в сравнение
	$('.compare-link').on('click', function( element ){
		element.preventDefault();
		var link = $(this);
		
		// добавить товар в список сравнения
		$.ajax({
			url: link.attr('href'),
			type: "GET",
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
