var base_url = '/front/'
require.config({
	baseUrl: base_url + 'assets/js',
	paths: {
		'jquery': 'jquery-2.1.4',
		'jqm': 'jquery.mobile-1.4.5.min',
        'jqm_widget_ext': 'jquery.mobile.widget.ext',
		'underscore': 'underscore',
		'backbone': 'backbone',
		'text': 'text',
		'models': 'app/models',
		'views': 'app/views',
		'templates': 'app/templates',
		'routers': 'app/routers'
	}, 
	urlArgs: 'bust=1',
	waitSeconds: 0,
	shim:{
		'jqm': {
			deps:['jquery']
		},
		'jqm_widget_ext': {
			deps:['jquery','jqm']
		} 
	}
});

//加载jquery
require(['jquery'], function(){

	$.G = {};
	$.G.user = null;

	//全局ajaxSuccess事件(由后台发出的客户端事件)
    $(document).ajaxSuccess(function(event, xhr, options, data){

        if(data.err_msg)
        {
            $.cm.toast({
                msg:data.err_msg
            });
        }
    });

	//jquerymobile配置
    $(document).on('mobileinit', function(){
        //禁用jquerymobile的链接绑定
        $.mobile.linkBindingEnabled = false;
        //禁用jquerymobile的hashchange侦听
        $.mobile.hashListeningEnabled = false;

        $.mobile.defaultPageTransition = false;

        $.mobile.loader.prototype.options.text = "loading hardly";
        $.mobile.loader.prototype.options.textVisible = false;
        $.mobile.loader.prototype.options.theme = "a";
        $.mobile.loader.prototype.options.html = "";

        $.mobile.page.prototype.options.keepNative = ".no-enhance";
    });

    $.ajax({
    	url: '/front/user_state',
    	method: 'GET',
    	dataType: 'json',
    	global: true
    }).done(function(data){
    	if(data.row) $.G.user = data.row;
		//加载jquery.mobile
		require(['backbone', 'routers/MainRouter', 'jqm', 'jqm_widget_ext'], function(Backbone, MainRouter){
			this.main_router = new MainRouter();
			Backbone.history.start();
			$('body').fadeIn();
		});
    });
	
});