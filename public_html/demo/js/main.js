$('select.class').bind('change', function() {
	value = $('select.class option:selected').val();

    $.cookie("class", value, { expires: 365 });

    location.href = "./";
});
