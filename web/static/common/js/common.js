$(function(){
	$('body').on('click', '.del', function(e) {
		e.preventDefault();
		allowHtml();
		var $this = $(this);
		var title = "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i>警告</h4></div>";
		$( "#dialog-confirm" ).removeClass('hide').dialog({
			resizable: false,
			modal: true,
			title: title,
			title_html: true,
			buttons: [
				{
					html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; 确 认",
					"class" : "btn btn-danger btn-xs",
					click: function() {
						 $.get($this.attr('href'), function(xhr){
                             if (xhr.status == 1) {
                                 if ($this.attr('del-target')) {
                                     $this.parents($this.attr('del-target'))
                                          .hide('fast', function(){
                                             $(this).remove();
                                           });
                                 } else {
                                     window.location.reload(); 
                                 }
                             } else {
                                 alert(xhr.info);
                                 return true;
                             }
                         },'json');
						$( this ).dialog( "close" );
					}
				}
				,
				{
					html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; 取 消",
					"class" : "btn btn-xs",
					click: function() {
						$( this ).dialog( "close" );
					}
				}
			]
		});
	});
});

function allowHtml(){
	$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
		_title: function(title) {
			var $title = this.options.title || '&nbsp;'
			if( ("title_html" in this.options) && this.options.title_html == true )
				title.html($title);
			else title.text($title);
		}
	}));
}
