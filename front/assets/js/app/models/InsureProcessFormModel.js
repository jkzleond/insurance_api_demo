define([
	'backbone'
], function(Backbone){
	var InsureProcessFormModel = Backbone.Model.extend({
		url: './index.php?c=insure&a=process',
		parse: function(resp, options){
			if(options.collection) return resp;
			return resp.row || {};
		},
		validate: function(attrs, options){
			
		}
	});
	return InsureProcessFormModel;
});