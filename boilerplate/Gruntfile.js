// var vendorScripts = [
//         './bower_components/jquery/dist/jquery.js',
//         '/jquery-ui-1.10.3.custom.min.js',
//         './assets/scripts/vendor/jquery.ui.touch-punch.min.js',
        
//         './bower_components/bootstrap/dist/js/bootstrap.js',
//         './bower_components/jquery.lazyload/jquery.lazyload.js',

//         './assets/scripts/vendor/jquery-ajax-localstorage-cache.js',
        
//         './assets/scripts/vendor/bootstrap/bootstrap-select.js',
//         './assets/scripts/vendor/bootstrap/bootstrap-switch.js',
//         //'./assets/scripts/vendor/typeahead.js',

//         './assets/scripts/vendor/flatui/flatui-checkbox.js',
//         './assets/scripts/vendor/flatui/flatui-radio.js',
//         //'./assets/scripts/vendor/flatui/flatui-fileinput.js',
        
//         './assets/scripts/vendor/swfobject.js',
//         './assets/scripts/vendor/jquery.tagsinput.js',
//         './assets/scripts/vendor/jquery.placeholder.js',
//         './assets/scripts/vendor/jquery.cookie.js',
//         './assets/scripts/vendor/jquery.query.js',
//     ],
//     appScripts = [
//         './assets/scripts/script.js'
//     ],
//     scripts = vendorScripts.concat(appScripts);

/*global module:false*/
module.exports = function(grunt) {
    'use strict';

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),


        // Set variables to be used inside Grunt
        project: {
            dist:        '../dist'
        },


        // Banner for generated files
        banner: '/*!\n' +
              ' * <%= pkg.name %>\n' +
              ' * <%= pkg.title %>\n' +
              ' * <%= pkg.url %>\n' +
              ' * @author <%= pkg.author %>\n' +
              ' * @version <%= pkg.version %>\n' +
              ' * Copyright <%= pkg.copyright %> <%= grunt.template.today("yyyy") %>. <%= pkg.license %> licensed.\n' +
              ' */\n',

        // Clean dev assets
        clean: {
            fonts: {
                src: [
                    '<%= project.dist %>/fonts'
                ]
            },

            js: {
                src: [
                    '<%= project.dist %>/modules/',
                    '<%= project.dist %>/videouri.js'
                ]
            },

            css: {
                src: [
                    '<%= project.dist %>/videouri.css',
                ]
            }
        },


        copy: {
            fonts: {
                flatten: true,
                expand: true,
                src: [
                    'bower_components/video.js/dist/video-js/font/*',
                    'bower_components/font-awesome/fonts/*',
                    './fonts/**/*'
                ],
                dest: '<%= project.dist %>/fonts/'
            },

            misc: {
                flatten: true,
                expand: true,
                src: [
                    'bower_components/video.js/dist/video-js/video-js.swf'
                ],
                dest: '<%= project.dist %>/misc/'
            },

            jsModules: {
                flatten: true,
                expand: true,
                src: [
                    'scripts/modules/*.js'
                ],
                dest: '<%= project.dist %>/modules/'
            }
        },

        // pretty clear what this is
        // requirejs: {
        //     dev: {
        //         options: {
        //             // almond: true,
        //             modules: ['videosListing'],
        //             // dir: '<%= project.dist %>',
        //             baseUrl:            'scripts',
        //             // mainConfigFile:     'scripts/build.js',
        //             mainConfigFile:     'scripts/main.js',
        //             // name:               '../bower_components/almond/almond',
        //             name:               'main',
        //             // include:            ['build', 'main'],
        //             out:                '<%= project.dist %>/videouri.js',
        //             optimize: 'none',
        //             // useStrict: true,
        //             // findNestedDependencies: true,
        //             generateSourceMaps: true,
        //             paths: {
        //                 // "module": "../modules",

        //                 "jquery"               : "../bower_components/jquery/dist/jquery",
        //                 "jquery.ui"            : "vendor/jquery-ui-1.10.3.custom.min",
        //                 "jquery.bridget"       : "../bower_components/jquery-bridget/jquery.bridget",
        //                 "jquery.ui.touch-punch": "vendor/jquery.ui.touch-punch.min",

        //                 "jquery.placeholder"   : "vendor/jquery.placeholder",
        //                 "jquery.cookie"        : "vendor/jquery.cookie",
        //                 "jquery.query"         : "vendor/jquery.query",

        //                 "bootstrap"            : "../bower_components/bootstrap/dist/js/bootstrap",
        //                 "lazyload"             : "../bower_components/jquery.lazyload/jquery.lazyload",
        //                 'isotope'              : '../bower_components/isotope/dist/isotope.pkgd',
        //                 // "ajax-cache"           : "vendor/jquery-ajax-localstorage-cache",

        //                 // "swfobject"            : "vendor/swfobject",
                         
        //                 // 'flat-ui'              : 'vendor/flat-ui-pro',

        //                 "videojs"             : "../bower_components/video.js/dist/video-js/video",
        //                 "videojs-youtube"     : "../bower_components/videojs-youtube/dist/vjs.youtube",
        //                 "videojs-vimeo"       : "../bower_components/videojs-vimeo/vjs.vimeo",
        //                 "videojs-dailymotion" : "vendor/video.js-dailymotion/vjs.dailymotion"
        //             },
        //             shim: {
        //                 // jquery: {
        //                 //     exports: '$'
        //                 // },
        //                 'jquery.ui':             ['jquery'],
        //                 // 'jquery.bridget':        ['jquery'],
        //                 'jquery.ui.touch-punch': ['jquery'],

        //                 'jquery.placeholder':           ['jquery'],
        //                 'jquery.cookie':                ['jquery'],
        //                 'jquery.query':                 ['jquery'],

        //                 'bootstrap':             ['jquery'],
        //                 'lazyload':              ['jquery'],
        //                 'isotope':               ['jquery'], 
                        
        //                 // 'flat-ui': ['jquery'],

        //                 'videojs': {exports: 'videojs'}
        //                 // 'video-js-youtube':      ['video-js'],
        //                 // 'video-js-vimeo':        ['video-js'],
        //                 // 'video-js-dailymotion':  ['video-js']
        //             }
        //         }
        //     },

        //     dist: {
        //         options: {
        //             baseUrl:            'scripts',
        //             mainConfigFile:     'scripts/build.js',
        //             //name:               '<%= project.bowerDir %>/almond/almond',
        //             name:               'main',
        //             include:            ['build'],
        //             out:                '<%= project.dist %>/videouri.min.js',
        //             generateSourceMaps: true,
        //             preserveLicenseComments: false,
        //             useStrict: true,
        //             wrap: true,
        //             inlineText: true, 
        //             optimize: 'uglify2'
        //         }
        //     }
        // },

        // Compile LESS files
        less: {
            dev: {
                options: {
                    // paths: ["stylesheets/less"],
                    ieCompat: true
                },
                files: {
                    "<%= project.dist %>/videouri.css": "stylesheets/less/boilerplate.less"
                }
            },
            dist: {
                options: {
                    // paths: ["stylesheets/less"],
                    // compress: true,
                    cleancss: true,
                    ieCompat: true
                },
                files: {
                    "<%= project.dist %>/videouri.css": "stylesheets/less/boilerplate.less"
                }
            }
        },


        // Concatenate files
        concat: {
            options: {
                banner: '<%= banner %>',
                stripBanners: true,
                nonull: true,
            },
            js: {
                src: [
                    "bower_components/jquery/dist/jquery.js",
                    "scripts/vendor/jquery-ui-1.10.3.custom.min.js",
                    "scripts/vendor/jquery.ui.touch-punch.min.js",

                    "scripts/vendor/jquery.placeholder.js",
                    "scripts/vendor/jquery.cookie.js",
                    "scripts/vendor/jquery.query.js",

                    "bower_components/bootstrap/dist/js/bootstrap.js",
                    "bower_components/jquery.lazyload/jquery.lazyload.js",
                    "bower_components/isotope/dist/isotope.pkgd.js",

                    "bower_components/video.js/dist/video-js/video.js",
                    "bower_components/videojs-youtube/dist/vjs.youtube.js",
                    "bower_components/videojs-vimeo/vjs.vimeo.js",
                    "scripts/vendor/video.js-dailymotion/vjs.dailymotion.js",
                    "scripts/main.js"
                ],
                dest: '<%= project.dist %>/videouri.js'
            }
        },

        // Minify and such, for production
        /*uglify: {
            options: {
                banner: '<%= banner %>'
            },
            dist: {
                files: {
                    '<%= project.js %>': [scripts]
                }
            }
        },*/

        jshint: {
            files: [
                'scripts/modules/*.js',
                'scripts/application.js',
                'scripts/build.js',
                'scripts/main.js',
                'Gruntfile.js'
            ],
            options: {
                // "node": true,
                "browser": true,
                "es5": true,
                // "esnext": true,
                "bitwise": true,
                "camelcase": true,
                "curly": true,
                "eqeqeq": true,
                "immed": true,
                "indent": 4,
                // "latedef": true,
                "newcap": true,
                "noarg": true,
                "quotmark": "mixed",
                // "regexp": true,
                // "undef": true,
                "unused": true,
                "strict": true,
                // "trailing": false,
                "smarttabs": true,
                "globals" : {
                    "requirejs": true,
                    "require": true,
                    "$": true,
                    "jQuery": true,
                    "Modernizr": true
                }
            }
        },

        watch: {
            options: {
                livereload: true
            },

            grunt: {
                files: ['Gruntfile.js']
            },


            //////
            /// COPY
            //////
            fonts: {
                files: [
                    'bower_components/video.js/dist/video-js/font/*',
                    'bower_components/font-awesome/fonts/*',
                    './fonts/**/*'
                ],
                tasks: ['copy:fonts']
            },
            misc: {
                files: [
                    'bower_components/video.js/dist/video-js/video-js.swf'
                ],
                tasks: ['copy:misc']
            },
            
            //////
            /// STYLES
            //////
            less: {
                // files: 'stylesheets/less/**/*.less',
                files: 'stylesheets/less/**/*.less',
                tasks: ['less:dev']
            },

            //////
            /// SCRIPTS
            //////
            // requirejs: {
            //     files: [
            //         'scripts/vendor/{,*/}*.js',
            //         'scripts/build.js',
            //         'scripts/main.js'
            //     ],
            //     // tasks: ['jshint', 'requirejs:dev']
            //     tasks: ['requirejs:dev']
            // },
            jsConcat: {
                files: [
                    'scripts/main.js'
                ],
                tasks: ['concat:js']
            },
            jsModules: {
                files: [
                    'scripts/modules/*.js'
                ],
                tasks: ['copy:jsModules']
            }
            // livereload: {
            //     files: [
            //         //'<%= project.assets %>/css/*.css',
            //         '<%= project.css %>',
            //         //'<%= project.assets %>/js/{,*/}*.js',
            //         '<%= project.js %>',
            //         //'<%= project.assets %>/{,*/}*.{png,jpg,jpeg,gif,webp,svg}'
            //     ]
            // }
        }
    });

    // These plugins provide necessary tasks.
    grunt.loadNpmTasks('grunt-contrib-requirejs');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-copy');
    // grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    // grunt.loadNpmTasks('grunt-notify');

    // Defining Tasks
    //grunt.registerTask('default', ['less', 'concat']);
    //grunt.registerTask('production', ['less', 'jshint', 'concat', 'uglify']);

    grunt.registerTask('production', ['clean', 'copy', 'less', 'concat', 'uglify']);
    grunt.registerTask('default', ['watch']);

};
