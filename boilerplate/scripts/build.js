requirejs.config({
    // baseUrl: "../",

    // automatically require on page load in debug mode
    // deps: ['assets/scripts/main'],
    // deps: ['main'],

    // automatically require this for production build
    // insertRequire: ['assets/scripts/main'],

    paths: {
        "module": "../modules",

        "jquery"               : "../bower_components/jquery/dist/jquery",
        "jquery.ui"            : "vendor/jquery-ui-1.10.3.custom.min",
        "jquery.ui.touch-punch": "vendor/jquery.ui.touch-punch.min",
        "bootstrap"            : "../bower_components/bootstrap/dist/js/bootstrap",
        "lazyload"             : "../bower_components/jquery.lazyload/jquery.lazyload",
        "ajax-cache"           : "vendor/jquery-ajax-localstorage-cache",

        "bootstrap-select"     : "vendor/bootstrap/bootstrap-select",
        "bootstrap-switch"     : "vendor/bootstrap/bootstrap-switch",
        //"typeahead"          : "typeahead",

        "flatui-checkbox"      : "vendor/flatui/flatui-checkbox",
        "flatui-radio"         : "vendor/flatui/flatui-radio",

        "swfobject"            : "vendor/swfobject",
        "tagsinput"            : "vendor/jquery.tagsinput",
        "placeholder"          : "vendor/jquery.placeholder",
        "cookie"               : "vendor/jquery.cookie",
        "query"                : "vendor/jquery.query",
    },
    shim: {
        'jquery.ui':             ['jquery'],
        'jquery.ui.touch-punch': ['jquery'],
        'bootstrap':             ['jquery'],
        'lazyload':              ['jquery'],
        'ajax-cache':            ['jquery'],
        'bootstrap-switch':      ['bootstrap'],
        'bootstrap-select':      ['bootstrap'],
        'flatui-checkbox':       ['jquery'],
        'flatui-radio':          ['jquery'],
        'tagsinput':             ['jquery'],
        'placeholder':           ['jquery'],
        'cookie':                ['jquery'],
        'query':                 ['jquery'],
    }
}).call(this);

// Load the main app module to start the app
requirejs(["main"]);