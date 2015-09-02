var base_url = './'
require.config({
	baseUrl: base_url + '/assets/js',
	paths: {
		'jquery': 'jquery-2.1.4',
		'jqm': 'jquery.mobile-1.4.5.min',
		'underscore': 'underscore',
		'backbone': 'backbone',
		'text': 'text',
		'models': 'app/models',
		'views': 'app/views',
		'templates': 'app/templates',
		'routers': 'app/routers'
	}, 
	urlArgs: 'bust=1',
	waitSecond: 0,
	shim:{
		'jqm':{
			deps:['jquery']
		}
	}
});

//加载jquery
require(['jquery'], function(){

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
	
	//加载jquery.mobile
	require(['backbone', 'routers/MainRouter', 'jqm'], function(Backbone, MainRouter){
		this.main_router = new MainRouter();
		Backbone.history.start();
		$('body').fadeIn();
	});
});