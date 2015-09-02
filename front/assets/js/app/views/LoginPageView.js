define([
	'jquery',
	'backbone',
	'models/LoginFormModel',
	'text!templates/login_page.html'
], function($, Backbone, LoginFormModel, PageTpl){
	$(PageTpl).appendTo('body');
	var LoginPageView = Backbone.View.extend({
		el: '#insurance_login_page',
		initialize: function(){
			this.login_form_model = new LoginFormModel();
			this.listenTo(this.login_form_model, 'invalid', this._onFormInvalid);
			this.listenTo(this.login_form_model, 'sync', this._onLoginFormModelSync);
		},
		events: {
			//'click .login-btn': '_onLoginBtnClick'
		},
		_onLoginBtnClick: function(event){
			this._collectFormData();
			if(this.login_form_model.isValid())
			{
				this.login_form_model.save();
			}
			return false;
		},
		_onFormInvalid: function(model, err){
			console.log(err);
		},
		_onLoginFormModelSync: function(model, resp, options){

		},
		_collectFormData: function()
		{
			var form_model = this.login_form_model;
			this.$el.find('[name=login_form] [name]').each(function(i, n){
				var key = $(n).attr('name');
				var value = $(n).val();
				form_model.set(key, value, {silent: true});
			});
		}

	});
	return LoginPageView;
});