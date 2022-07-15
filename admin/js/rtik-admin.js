jQuery(document).ready(function(){
	var loading = ''
		+'<div id="wrap-loading" style="display: none;">'
			+'<div class="lds-hourglass"></div>'
			+'<div id="persen-loading"></div>'
		+'</div>';
	jQuery('body').prepend(loading);
})