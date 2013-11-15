var scripts = [
    'js/jquery-1.9.1.js',
    'js/jquery.animate-enhanced.min.js',
    'jquery.easing.min.js',
    'js/**/*.js',
    '!js/scripts.js'
];

(function()
{
    'use strict';
    module.exports = function(grunt)
    {
        grunt.initConfig({
            pkg: grunt.file.readJSON('package.json'),

            bowerDir: 'bower_components',

            clean: ['assets/tmp'],

            // Grunt tasks are associated with specific properties.
            // these names generally match their npm package name.
            concat: {
                js: {
                    src: [
                        '<%= bowerDir %>/jquery/jquery.js',
                        '<%= bowerDir %>/twitter/dist/js/bootstrap.js',
                        //'./assets/scripts/vendor/*.js'
                    ],
                    dest: './assets/tmp/concat.js'
                }
            },

            copy: {
                bootstrap: {
                    files: [
                        { expand: true, cwd: '<%= bowerDir %>/bootstrap/less', src: ['bootstrap.less'], dest: 'assets/tmp/bootstrap' },
                        { expand: true, cwd: '<%= bowerDir %>/bootstrap/dist/js', src: ['bootstrap.js'], dest: 'assets/scripts' }
                    ]
                },
                /*fontawesome: {
                    files: [
                        { expand: true, cwd: '<%= bowerDir %>/font-awesome/less', src: ['font-awesome.less'], dest: 'assets/tmp/font-awesome' },
                        { expand: true, cwd: '<%= bowerDir %>/font-awesome/font', src: ['*'], dest: 'public/fonts' }
                    ]
                },*/
                jquery: {
                    files: [
                        { expand: true, cwd: '<%= bowerDir %>/jquery', src: ['jquery.js'], dest: 'assets/scripts' }
                    ]
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

            uglify: {
                options: {
                    preserveComments: false
                },
                my_target: {
                    files: {
                        'assets/scripts/script.min.js': ['assets/tmp/concat.js']
                    }
                }
            },

            watch: {
                options: {
                    livereload: true,
                },
                /*gruntfile: {
                    files: 'Gruntfile.js',
                    tasks: ['jshint:gruntfile'],
                },*/
                /*scripts: {
                    files: ['./assets/scripts/main.js'],
                    tasks: ['jshint', 'uglify', 'concat']
                },*/
                less: {
                    files: "./assets/stylesheets/less/*",
                    tasks: ["less"]
                }
            },
        });

        // Load npm tasks
        grunt.loadNpmTasks('grunt-contrib-copy');
        grunt.loadNpmTasks('grunt-contrib-clean');
        grunt.loadNpmTasks('grunt-contrib-compress');
        grunt.loadNpmTasks('grunt-contrib-concat');
        grunt.loadNpmTasks('grunt-contrib-cssmin');
        grunt.loadNpmTasks('grunt-contrib-jshint');
        grunt.loadNpmTasks('grunt-contrib-less');
        grunt.loadNpmTasks('grunt-contrib-uglify');
        grunt.loadNpmTasks('grunt-contrib-watch');
        grunt.loadNpmTasks('grunt-notify');

        grunt.registerTask('default', ['copy', 'less', 'concat', 'uglify', 'watch', 'clean']);

        // Register tasks
        //grunt.registerTask('default', ['clean:all', {{tasks}} 'concat:css', 'concat:js', 'cssmin', 'uglify', 'clean:concat']); // Default task
    };
}) ();