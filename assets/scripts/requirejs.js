requirejs.config({
    baseUrl: "/",

    // automatically require on page load in debug mode
    deps: ['assets/scripts/app'],

    // automatically require this for production build
    insertRequire: ['assets/scripts/app'],

    paths: {
        "bower" : "../../../bower_components",
        "module": "../modules",

        "jquery"               : "bower_components/jquery/dist/jquery",
        "jquery.ui"            : "assets/scripts/vendor/jquery-ui-1.10.3.custom.min",
        "jquery.ui.touch-punch": "assets/scripts/vendor/jquery.ui.touch-punch.min",
        "bootstrap"            : "bower_components/bootstrap/dist/js/bootstrap",
        "lazyload"             : "bower_components/jquery.lazyload/jquery.lazyload",
        "ajax-cache"           : "assets/scripts/vendor/jquery-ajax-localstorage-cache",

        "bootstrap-select"     : "assets/scripts/vendor/bootstrap/bootstrap-select",
        "bootstrap-switch"     : "assets/scripts/vendor/bootstrap/bootstrap-switch",
        //"typeahead"          : "typeahead",

        "flatui-checkbox"      : "assets/scripts/vendor/flatui/flatui-checkbox",
        "flatui-radio"         : "assets/scripts/vendor/flatui/flatui-radio",

        "swfobject"            : "assets/scripts/vendor/swfobject",
        "tagsinput"            : "assets/scripts/vendor/jquery.tagsinput",
        "placeholder"          : "assets/scripts/vendor/jquery.placeholder",
        "cookie"               : "assets/scripts/vendor/jquery.cookie",
        "query"                : "assets/scripts/vendor/jquery.query",
    }
});

// Load the main app module to start the app
requirejs(["app", "module/home"]);