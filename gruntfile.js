module.exports = function(grunt) {

    require('load-grunt-tasks')(grunt);

    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        makepot: {
            target: {
                options: {
                    domainPath: 'wp-content/themes/tauchterminal/languages/',      // Where to save the POT file.
                    mainFile: 'wp-content/themes/tauchterminal/css/tt-flat.css',                    // Main project file.
                    potFilename: 'tauchterminal.pot',         // Name of the POT file.
                    type: 'wp-theme',                         // Type of project (wp-plugin or wp-theme).
                    exclude: [],                              // List of files or directories to ignore.
                    processPot: function( pot, options ) {
                        pot.headers['report-msgid-bugs-to'] = 'http://nessie.me';
                        pot.headers['plural-forms'] = 'nplurals=2; plural=n != 1;';
                        pot.headers['last-translator'] = 'Vanessa Haenni <vanessa@tulamben.com>\n';
                        pot.headers['language-team'] = 'Vanessa Haenni <vanessa@tulamben.com>\n';
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
                src: 'wp-content/languages/*.po',
                expand: true,
            },
        },

        less: {
            compileCore: {
                options: {
                    strictMath: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'tt-flat.css.map',
                    sourceMapFilename: 'wp-content/themes/tauchterminal/css/tt-flat.css.map'
                },
                src: 'node_modules/bootstrap/less/bootstrap.less',
                dest: 'wp-content/themes/tauchterminal/css/tt-flat.css'
            },
            compileTheme: {
                options: {
                    strictMath: true,
                    sourceMap: true,
                    outputSourceFiles: true,
                    sourceMapURL: 'tt-flat-theme.css.map',
                    sourceMapFilename: 'wp-content/themes/tauchterminal/css/tt-flat-theme.css.map'
                },
                src: 'wp-content/themes/tauchterminal/less/theme.less',
                dest: 'wp-content/themes/tauchterminal/css/tt-flat-theme.css'
            }
        },

        watch: {
            less: {
                files: 'wp-content/themes/tauchterminal/less/**/*.less',
                tasks: 'less'
            }
        }

    });

    // Default task(s).
    grunt.registerTask( 'default', [ 'makepot', 'exec', 'po2mo', 'less' ] );

};
