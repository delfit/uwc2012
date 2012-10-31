// дождаться загрузки документа
$(document).ready(function(){
	// скрыть по-умолчанию кнопку
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
});
