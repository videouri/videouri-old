'use strict';

require.config({
    // baseUrl: "../",
    
    // dir: 'dist/',

    // automatically require on page load in debug mode
    // deps: ['assets/scripts/main'],
    // deps: ['main'],

    // automatically require this for production build
    // insertRequire: ['main'],

    // packages: ['home', 'video'],

    paths: {
        // "module": "../modules",

        "jquery"               : "../bower_components/jquery/dist/jquery",
        "jquery.ui"            : "vendor/jquery-ui-1.10.3.custom.min",
        "jquery.bridget"       : "../bower_components/jquery-bridget/jquery.bridget",
        "jquery.ui.touch-punch": "vendor/jquery.ui.touch-punch.min",

        "jquery.placeholder"   : "vendor/jquery.placeholder",
        "jquery.cookie"        : "vendor/jquery.cookie",
        "jquery.query"         : "vendor/jquery.query",

        "bootstrap"            : "../bower_components/bootstrap/dist/js/bootstrap",
        "lazyload"             : "../bower_components/jquery.lazyload/jquery.lazyload",
        'isotope'              : '../bower_components/isotope/dist/isotope.pkgd',
        // "ajax-cache"           : "vendor/jquery-ajax-localstorage-cache",

        // "swfobject"            : "vendor/swfobject",
         
        // 'flat-ui'              : 'vendor/flat-ui-pro',

        "videojs"             : "../bower_components/video.js/dist/video-js/video",
        "videojs-youtube"     : "../bower_components/videojs-youtube/dist/vjs.youtube",
        "videojs-vimeo"       : "../bower_components/videojs-vimeo/vjs.vimeo",
        "videojs-dailymotion" : "vendor/video.js-dailymotion/vjs.dailymotion"
    },
    shim: {
        // jquery: {
        //     exports: '$'
        // },
        'jquery.ui':             ['jquery'],
        // 'jquery.bridget':        ['jquery'],
        'jquery.ui.touch-punch': ['jquery'],

        'jquery.placeholder':           ['jquery'],
        'jquery.cookie':                ['jquery'],
        'jquery.query':                 ['jquery'],

        'bootstrap':             ['jquery'],
        'lazyload':              ['jquery'],
        'isotope':               ['jquery'], 
        
        // 'flat-ui': ['jquery'],

        'videojs': {exports: 'videojs'}
        // 'video-js-youtube':      ['video-js'],
        // 'video-js-vimeo':        ['video-js'],
        // 'video-js-dailymotion':  ['video-js']
    }
});