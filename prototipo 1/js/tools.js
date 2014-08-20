$(function(){
	$('input').setMask();
});

function bindPlaceHolder(el, val, text){
	if(text == true){
		$(el).focus(function(){if($(this).html() == val)$(this).html('');});
		$(el).blur(function(){if($(this).html() == "")$(this).html(val);});
	}else{
		$(el).focus(function(){if($(this).val() == val)$(this).val('');});
		$(el).blur(function(){if($(this).val() == "")$(this).val(val);});
	}
}