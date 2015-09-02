define([
	'jquery',
	'backbone',
	'models/InsureProcessFormModel',
	'text!templates/insure_process_page.html'
], function($, Backbone, InsureProcessFormModel, PageTpl){
	$(PageTpl).appendTo('body');
	var InsureProcessPageView = Backbone.View.extend({
		el:'#insure_process_page',
		initialize: function(){
			this.insure_process_form_model = new InsureProcessFormModel();
		},
		events: {
			'click .goto-btn': '_onGotoBtnClick'
		},
		_onGotoBtnClick: function(event){
			var $goto_btn = $(event.target);
			var goto_target = $goto_btn.attr('data-goto');
			$('.step').hide();
			$(goto_target).fadeIn();
		}
	});
	return InsureProcessPageView;
});