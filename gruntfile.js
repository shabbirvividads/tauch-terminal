module.exports = function(grunt) {

    require('load-grunt-tasks')(grunt);

    var configBridge = grunt.file.readJSON('./node_modules/bootstrap/grunt/configBridge.json', { encoding: 'utf8' });

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        banner: '/*!\n' +
                ' * Bootstrap v<%= pkg.version %> (<%= pkg.homepage %>)\n' +
                ' * Copyright 2011-<%= grunt.template.today("yyyy") %> <%= pkg.author %>\n' +
                ' * Licensed under the <%= pkg.license %> license\n' +
                ' */\n',
        jqueryCheck: configBridge.config.jqueryCheck.join('\n'),
        jqueryVersionCheck: configBridge.config.jqueryVersionCheck.join('\n'),

        makepot: {
            target: {
                options: {
                    cwd: 'wp-content/themes/<%= pkg.name %>',
                    domainPath: '../../languages/themes',      // Where to save the POT file.
                    mainFile: 'dist/css/<%= pkg.name %>.css',      // Main project file.
                    potFilename: '<%= pkg.name %>.pot',        // Name of the POT file.
                    type: 'wp-theme',                          // Type of project (wp-plugin or wp-theme).
                    exclude: [],                               // List of files or directories to ignore.
                    processPot: function( pot, options ) {
                        pot.headers['report-msgid-bugs-to'] = 'http://nessie.me';
                        pot.headers['plural-forms'] = 'nplurals=2; plural=n != 1;';
                        pot.headers['last-translator'] = 'Vanessa Haenni <vanessa@tulamben.com>\n';
                        pot.headers['language-team'] = 'Vanessa Haenni <vanessa@tulamben.com>\n';
                        pot.headers['language'] = 'en';
                        pot.headers['x-poedit-basepath'] = '.\n';
                        pot.headers['x-poedit-language'] = 'English\n';
                        pot.headers['x-poedit-country'] = 'UNITED STATES\n';
                        pot.headers['x-poedit-sourcecharset'] = 'utf-8\n';
                        pot.headers['x-poedit-keywordslist'] = '__;_e;_x;esc_html_e;esc_html__;esc_attr_e;esc_attr__;_ex:1,2c;_nx:4c,1,2;_nx_noop:4c,1,2;_x:1,2c;_n:1,2;_n_noop:1,2;__ngettext_noop:1,2;_c,_nc:4c,1,2;\n';
                        pot.headers['x-textdomain-support'] = 'yes\n';
                        return pot;
                    }
                }
            }
        },

        exec: {
            update_po_tx: { // Update Transifex translation - grunt exec:update_po_tx
                cmd: 'tx pull -a --minimum-perc=100'
            }
            // update_po_wti: { // Update WebTranslateIt translation - grunt exec:update_po_wti
            //     cmd: 'wti pull',
            //     cwd: 'languages/',
            // }
        },

        po2mo: {
            files: {
                src: 'wp-content/languages/themes/*.po',
                expand: true,
            },
        },

        clean: {
            dist: 'dist'
        },

        less: {
            compileCore: {
                options: {
                    strictMath: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: '<%= pkg.name %>.css.map',
                    sourceMapFilename: 'wp-content/themes/<%= pkg.name %>/dist/css/<%= pkg.name %>.css.map'
                },
                src: 'wp-content/themes/<%= pkg.name %>/less/<%= pkg.name %>.less',
                dest: 'wp-content/themes/<%= pkg.name %>/dist/css/<%= pkg.name %>.css'
            }
        },

        // Compile all .scss files for woocommerce
        sass: {
            compile: {
                options: {
                    sourcemap: 'none',
                    loadPath: require('node-bourbon').includePaths
                },
                files: [{
                    expand: true,
                    cwd: 'wp-content/themes/<%= pkg.name %>/sass/',
                    src: ['*.scss', '!auth.scss', '!wc-setup.scss'],
                    dest: 'wp-content/themes/<%= pkg.name %>/dist/css',
                    ext: '.woocommerce.css'
                }]
            }
        },

        csslint: {
            options: {
                csslintrc: 'wp-content/themes/<%= pkg.name %>/less/.csslintrc'
            },
            dist: [
                'wp-content/themes/<%= pkg.name %>/dist/css/*.css'
            ]
        },

        csscomb: {
            options: {
                config: 'wp-content/themes/<%= pkg.name %>/less/csscomb.json'
            },
            dist: {
                expand: true,
                cwd: 'wp-content/themes/<%= pkg.name %>/dist/css/',
                src: ['*.css', '!*.min.css'],
                dest: 'wp-content/themes/<%= pkg.name %>/dist/css/'
            }
        },

        autoprefixer: {
            options: {
                browsers: configBridge.config.autoprefixerBrowsers
            },
            core: {
                options: {
                    map: true
                },
                src: ['wp-content/themes/<%= pkg.name %>/dist/css/<%= pkg.name %>.merged.css']
            }
        },

        cssmin: {
            options: {
                // TODO: disable `zeroUnits` optimization once clean-css 3.2 is released
                //        and then simplify the fix for https://github.com/twbs/bootstrap/issues/14837 accordingly
                compatibility: 'ie8',
                keepSpecialComments: '*',
                advanced: false
            },
            minifyCore: {
                src: 'wp-content/themes/<%= pkg.name %>/dist/css/<%= pkg.name %>.merged.css',
                dest: 'wp-content/themes/<%= pkg.name %>/dist/css/<%= pkg.name %>.min.css'
            }
        },

        concat: {
            // options: {
            //     banner: '<%= banner %>\n<%= jqueryCheck %>\n<%= jqueryVersionCheck %>',
            //     stripBanners: false
            // },
            bootstrap: {
                src: [
                  'node_modules/bootstrap/dist/js/bootstrap.min.js',
                  'wp-content/themes/<%= pkg.name %>/js/<%= pkg.name %>.js'
                ],
                dest: 'wp-content/themes/<%= pkg.name %>/dist/js/<%= pkg.name %>.js'
            },
            css: {
                src: [
                  'wp-content/themes/<%= pkg.name %>/dist/css/<%= pkg.name %>.css',
                  'wp-content/themes/<%= pkg.name %>/dist/css/*.woocommerce.css'
                ],
                dest: 'wp-content/themes/<%= pkg.name %>/dist/css/<%= pkg.name %>.merged.css'
            }
        },

        uglify: {
            options: {
                compress: {
                    warnings: false
                },
                mangle: true,
                preserveComments: 'some'
            },
            core: {
                src: '<%= concat.bootstrap.dest %>',
                dest: 'wp-content/themes/<%= pkg.name %>/dist/js/<%= pkg.name %>.min.js'
            }
        },

        jshint: {
            options: {
                jshintrc: '.jshintrc'
            },
            core: {
                src: 'wp-content/themes/<%= pkg.name %>/js/*.js'
            }
        },

        jscs: {
            options: {
                config: '.jscsrc'
            },
            core: {
                src: '<%= jshint.core.src %>'
            }
        },

        copy: {
            fonts: {
                expand: true,
                cwd: 'node_modules/bootstrap/fonts',
                src: '**',
                dest: 'wp-content/themes/<%= pkg.name %>/dist/fonts'
            }
        },

        watch: {
            less: {
                files: 'wp-content/themes/<%= pkg.name %>/less/**/*.less',
                tasks: ['less', 'concat:css', 'autoprefixer']
            },
            sass: {
                files: 'wp-content/themes/<%= pkg.name %>/sass/**/*.scss',
                tasks: ['sass', 'concat:css', 'autoprefixer']
            },
            src: {
                files: '<%= jshint.core.src %>',
                tasks: ['jshint', 'jscs', 'concat']
            },
        }

    });

    // Default task(s).
    grunt.registerTask('default', ['less', 'csscomb', 'concat:css', 'autoprefixer', 'jshint', 'jscs']);

    grunt.registerTask('dist-css', function(which) {
        var task = 'csscomb';
        if (which) task += ':' + which;
        // grunt.task.run(['less', 'sass', task, 'concat:css', 'autoprefixer', 'cssmin']);
        grunt.task.run(['less', 'sass', task, 'concat:css', 'autoprefixer', 'cssmin']);
    });
    grunt.registerTask('dist-js', ['jshint', 'jscs', 'concat', 'uglify:core']);

    // Full distribution task.
    grunt.registerTask('dist', ['clean:dist', 'dist-css', 'dist-js', 'copy']);

    grunt.registerTask('translation', [ 'makepot', 'exec', 'po2mo']);

};
