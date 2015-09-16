define([
	'jquery',
	'backbone',
	'views/LoginPageView',
	'views/InsureProcessPageView'
], function($, Backbone, LoginPageView, InsureProcessPageView){
	var MainRouter = Backbone.Router.extend({
		initialize: function(){
			this.login_page_view = new LoginPageView();
			this.insure_process_page_view = new InsureProcessPageView();
			this.listenTo(this.login_page_view, 'uri', this._onViewRequestURI);
		},
		// execute: function(callback, args, name){
		// 	if(!$.G.user && name !== 'login')
		// 	{
		// 		this.navigate('login', {trigger: true});
		// 		return false;
		// 	}
		// 	else if(callback)
		// 	{
		// 		callback.apply(this, args);
		// 	}
		// },
		_onViewRequestURI: function(view, uri){
			this.navigate(uri, {trigger: true});
		},
		routes: {
			'login': 'login',
			'(insure)': 'insure'
		},
		login: function(){
			$(':mobile-pagecontainer').pagecontainer('change', '#insurance_login_page');
		},
		insure: function(){
			$(':mobile-pagecontainer').pagecontainer('change', '#insure_process_page');
		}
	});
	return MainRouter;
});