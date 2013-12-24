'use strict';

var vendorScripts = [
        './bower_components/jquery/jquery.js',
        '/jquery-ui-1.10.3.custom.min.js',
        './assets/scripts/vendor/jquery.ui.touch-punch.min.js',
        
        './bower_components/twitter/dist/js/bootstrap.js',
        './bower_components/jquery.lazyload/jquery.lazyload.js',

        './assets/scripts/vendor/jquery-ajax-localstorage-cache.js',
        
        './assets/scripts/vendor/bootstrap/bootstrap-select.js',
        './assets/scripts/vendor/bootstrap/bootstrap-switch.js',
        //'./assets/scripts/vendor/bootstrap/bootstrap-typeahead.js',

        './assets/scripts/vendor/flatui/flatui-checkbox.js',
        './assets/scripts/vendor/flatui/flatui-radio.js',
        //'./assets/scripts/vendor/flatui/flatui-fileinput.js',
        
        './assets/scripts/vendor/jquery.placeholder.js',
        './assets/scripts/vendor/jquery.stackable.js',
        './assets/scripts/vendor/jquery.cookie.js',
        './assets/scripts/vendor/jquery.query.js',
    ],
    appScripts = [
        './assets/scripts/script.js'
    ],
    scripts = vendorScripts.concat(appScripts);

/*global module:false*/
module.exports = function(grunt) {

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        /**
         * Set project info
         */
        project: {
            assets: './assets',
            bowerDir: './bower_components',
            css: [
                '<%= project.assets %>/stylesheets/css/main.css'
            ],
            js: [
                '<%= project.assets %>/scripts/scripts.min.js',
            ]
        },
            
        banner: '/*!\n' +
              ' * <%= pkg.name %>\n' +
              ' * <%= pkg.title %>\n' +
              ' * <%= pkg.url %>\n' +
              ' * @author <%= pkg.author %>\n' +
              ' * @version <%= pkg.version %>\n' +
              ' * Copyright <%= pkg.copyright %> <%= grunt.template.today("yyyy") %>. <%= pkg.license %> licensed.\n' +
              ' */\n',


        clean: ['assets/tmp'],

        // Concatenate files
        concat: {
            options: {
                banner: '<%= banner %>',
                stripBanners: true,
                nonull: true,
            },
            js: {
                src: scripts,
                //dest: '<%= project.js %>'
                dest: './assets/scripts/main.js'
            }
        },

        // Minify and such, for production
        uglify: {
            options: {
                banner: '<%= banner %>'
            },
            dist: {
                files: {
                    '<%= project.js %>': [scripts]
                }
            }
        },

        // Compile LESS files
        less: {
            development: {
                options: {
                    paths: ["./assets/stylesheets/less"],
                    yuicompress: true,
                    ieCompat: true
                },
                files: {
                    "./assets/stylesheets/css/main.css": "./assets/stylesheets/less/main.less"
                }
            }
        },

        jshint: {
            files: [
                '<%= project.assets %>/scripts/script.js',
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
            concat: {
                files: '<%= project.assets %>/scripts/{,*/}*.js',
                tasks: ['concat:js']
            },
            less: {
                files: "./assets/stylesheets/less/**/*.less",
                tasks: ["less"]
            },
            livereload: {
                options: {
                    livereload: true
                },
                files: [
                    //'<%= project.assets %>/css/*.css',
                    '<%= project.css %>',
                    //'<%= project.assets %>/js/{,*/}*.js',
                    '<%= project.js %>',
                    //'<%= project.assets %>/{,*/}*.{png,jpg,jpeg,gif,webp,svg}'
                ]
            }
        }
    });

    // These plugins provide necessary tasks.
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
    //grunt.registerTask('default', ['less', 'jshint', 'concat']);
    grunt.registerTask('default', ['less', 'concat']);
    //grunt.registerTask('production', ['less', 'jshint', 'concat', 'uglify']);
    grunt.registerTask('production', ['less', 'concat', 'uglify']);

};
