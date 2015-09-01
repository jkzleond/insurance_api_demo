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

		}
	});
	return InsureProcessPageView;
});