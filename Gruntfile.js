var concatScripts = [
    './bower_components/jquery/jquery.js',
    './assets/scripts/vendor/jquery-ui-1.10.3.custom.min.js',
    './assets/scripts/vendor/jquery.ui.touch-punch.min.js',
    './bower_components/twitter/dist/js/bootstrap.js',
    './assets/scripts/vendor/bootstrap/bootstrap-select.js',
    './assets/scripts/vendor/bootstrap/bootstrap-switch.js',
    './assets/scripts/vendor/flatui/flatui-checkbox.js',
    './assets/scripts/vendor/flatui/flatui-radio.js',
    './assets/scripts/vendor/jquery.placeholder.js',
    './assets/scripts/vendor/jquery.stackable.js',
    './assets/scripts/vendor/jquery.cookie.js',
];

/*global module:false*/
module.exports = function(grunt) {

    // Project configuration.
    grunt.initConfig({
        // Metadata.
        meta: {
            version: '0.1.0'
        },
        banner: '/*! Videouri - v<%= meta.version %> - ' +
            '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
            '* http://videouri.com/\n' +
            '* Copyright (c) <%= grunt.template.today("yyyy") %> ' +
            'Alexandru Budurovici; Licensed MIT */\n',

        bowerDir: 'bower_components',

        clean: ['assets/tmp'],

        // Task configuration.
        concat: {
            options: {
                banner: '<%= banner %>',
                stripBanners: true
            },
            js: {
                src: concatScripts,
                dest: './assets/scripts/main.js'
            }
        },

        // Compile LESS files
        less: {
            development: {
                options: {
                    paths: ["./assets/stylesheets/less"],
                    yuicompress: false,
                    ieCompat: true
                },
                files: {
                    "./assets/stylesheets/css/main.css": "./assets/stylesheets/less/main.less"
                }
            }
        },

        uglify: {
            options: {
                banner: '<%= banner %>'
            },
            dist: {
                src: './assets/tmp/concat.js',
                dest: './assets/scripts/main.js'
            }
        },

        jshint: {
            options: {
                curly: true,
                eqeqeq: true,
                immed: true,
                latedef: true,
                newcap: true,
                noarg: true,
                sub: true,
                undef: true,
                unused: true,
                boss: true,
                eqnull: true,
                browser: true,
                globals: {
                    jQuery: true
                }
            },
              gruntfile: {
                src: 'Gruntfile.js'
            }
        },
        watch: {
            options: {
                livereload: true,
            },
            concat: {
                files: []
            },
            gruntfile: {
                files: '<%= jshint.gruntfile.src %>',
                tasks: ['jshint:gruntfile']
            },
            less: {
                files: "./assets/stylesheets/less/*",
                tasks: ["less"]
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
    grunt.registerTask('default', ['less', 'jshint', 'concat']);
    grunt.registerTask('production', ['less', 'jshint', 'concat', 'uglify']);

};
