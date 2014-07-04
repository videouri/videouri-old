'use strict';

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

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),


        // Set variables to be used inside Grunt
        project: {
            assets:      './assets',
            stylesheets: './assets/stylesheets',
            scripts:     './assets/scripts',
            bowerDir:    './bower_components',
            css: [
                '<%= project.stylesheets %>/css/main.css'
            ],
            js: [
                '<%= project.scripts %>/scripts.min.js',
            ]
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

        /**
         * 
         */
        //clean: ['assets'],
        

        // pretty clear what this is
        requirejs: {
            options: {
                baseUrl: "./",
                mainConfigFile: "<%= project.scripts %>/build.js",
                name: "<%= project.bowerDir %>/almond/almond",
                out: "<%= project.scripts %>/videouri.js"
            },

            debug: {
                options: {
                    optimize: 'none'
                }
            },

            production: {
                options: {
                    optimize: 'uglify2'
                }
            }
        },

        // Compile LESS files
        less: {
            development: {
                options: {
                    paths: ["<%= project.stylesheets %>/less"],
                    //compress: true,
                    //cleancss: true,
                    ieCompat: true
                },
                files: {
                    "<%= project.stylesheets %>/css/main.css": "<%= project.stylesheets %>/less/main.less"
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
            /*js: {
                src: scripts,
                dest: '<%= project.scripts %>/main.js'
            },*/
            css: {
                src: [
                        '<%= project.bowerDir %>/bootstrap/dist/css/bootstrap.css', 
                        '<%= project.stylesheets %>/css/font-awesome.css',
                        '<%= project.stylesheets %>/css/main.css'
                     ],
                dest: '<%= project.stylesheets %>/css/main.css',
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
                '<%= project.scripts %>/script.js',
                'Gruntfile.js'
            ],
            options: {
                "node": true,
                "browser": true,
                "es5": true,
                "esnext": true,
                "bitwise": true,
                "camelcase": true,
                "curly": true,
                "eqeqeq": true,
                "immed": true,
                "indent": 4,
                "latedef": true,
                "newcap": true,
                "noarg": true,
                "quotmark": "mixed",
                "regexp": true,
                "undef": true,
                "unused": true,
                "strict": true,
                "trailing": false,
                "smarttabs": true,
                "globals" : {
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
            /// STYLES
            //////
            less: {
                files: '<%= project.stylesheets %>/less/**/*.less',
                tasks: ["less"]
            },
            concat: {
                files: '<%= project.stylesheets %>/css/**/*.css',
                //tasks: ['concat:js', 'concat:css']
                tasks: ['concat:css']
            },


            //////
            /// SCRIPTS
            //////
            requirejs: {
                files: [
                        '<%= project.scripts %>/vendor/{,*/}*.js',
                        '<%= project.scripts %>/module/{,*/}*.js',
                        '<%= project.scripts %>/build.js',
                        '<%= project.scripts %>/main.js'
                        ],
                tasks: ['requirejs:debug']
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
    grunt.loadNpmTasks('grunt-contrib-compress');
    grunt.loadNpmTasks('grunt-contrib-concat');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-notify');

    // Defining Tasks
    //grunt.registerTask('default', ['less', 'concat']);
    grunt.registerTask('work', ['watch']);
    //grunt.registerTask('production', ['less', 'jshint', 'concat', 'uglify']);
    grunt.registerTask('production', ['less', 'concat', 'uglify']);
    grunt.registerTask('default', ['work']);

};