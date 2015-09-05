define([
	'backbone'
], function(Backbone){
	var LoginFormModel = Backbone.Model.extend({
		url: '/front/login',
		parse: function(resp, options){
			if(options.collection) return resp;
			return resp.row || {};
		},
		validate: function(attrs, options){

			if(!attrs.user_name)
			{
				return '请输入用户名';
			}

			if(!attrs.pwd)
			{
				return '请输入密码'
			}

		}
	});
	return LoginFormModel;
});