/* jshint node:true */
module.exports = function( grunt ) {
	require( 'load-grunt-tasks' )( grunt );

	// Project configuration.
	grunt.initConfig( {
		pkg: grunt.file.readJSON( 'package.json' ),

		// PHPLint
		phplint: {
			options: {
				phpArgs: {
					'-lf': null
				}
			},
			all: [ 'classes/**/*.php' ]
		},

		// PHP Code Sniffer
		phpcs: {
			application: {
				src: [
					'**/*.php',
					'!deploy/**',
					'!node_modules/**',
					'!src/**'
				]
			},
			options: {
				standard: 'phpcs.ruleset.xml',
				showSniffCodes: true
			}
		},

		// JSHint
		jshint: {
			options: grunt.file.readJSON( '.jshintrc' ),
			grunt: {
				src: [ 'Gruntfile.js' ]
			},
			core: {
				expand: true,
				cwd: 'src',
				src: [
					'js/*.js'
				]
			}
		},

		// Check WordPress version
		checkwpversion: {
			options: {
				readme: 'readme.txt',
				plugin: 'pronamic-google-maps.php'
			},
			check: {
				version1: 'plugin',
				version2: 'readme',
				compare: '=='
			},
			check2: {
				version1: 'plugin',
				version2: '<%= pkg.version %>',
				compare: '=='
			}
		},

		// Check textdomain errors
		checktextdomain: {
			options:{
				text_domain: '<%= pkg.name %>',
				keywords: [
					'__:1,2d',
					'_e:1,2d',
					'_x:1,2c,3d',
					'esc_html__:1,2d',
					'esc_html_e:1,2d',
					'esc_html_x:1,2c,3d',
					'esc_attr__:1,2d',
					'esc_attr_e:1,2d',
					'esc_attr_x:1,2c,3d',
					'_ex:1,2c,3d',
					'_n:1,2,4d',
					'_nx:1,2,4c,5d',
					'_n_noop:1,2,3d',
					'_nx_noop:1,2,3c,4d'
				]
			},
			files: {
				src:  [
					'**/*.php',
					'!bower_components/**',
					'!deploy/**',
					'!examples/**',
					'!node_modules/**'
				],
				expand: true
			}
		},

		// Make POT
		makepot: {
			target: {
				options: {
					domainPath: 'languages',
					type: 'wp-plugin',
					updatePoFiles: true,
					updateTimestamp: false,
					exclude: [
						'bower_components/.*',
						'deploy/.*',
						'examples/.*',
						'node_modules/.*',
						'src/.*'
					]
				}
			}
		},

		// Copy
		copy: {
			build: {
				files: [
					{ // Theme JS
						expand: true,
						cwd: 'src/js/',
						src: [ '**' ],
						dest: 'js'
					}
				]
			},
			assets: {
				files: [
					{ // Google Maps MarkerManager - https://github.com/aquamme/google-maps-markermanager
						expand: true,
						cwd: 'bower_components/google-maps-markermanager/',
						src: [ 'markermanager.js' ],
						dest: 'assets/google-maps-marker-manager'
					},
					{ // Google Maps MarkerClustererPlus - https://github.com/mahnunchik/markerclustererplus
						expand: true,
						cwd: 'bower_components/markerclustererplus/src/',
						src: [ 'markerclusterer.js' ],
						dest: 'assets/markerclustererplus'
					},
					{ // Google Maps Overlapping Marker Spiderfier - https://github.com/jawj/OverlappingMarkerSpiderfier
						expand: true,
						cwd: 'src/assets/google-maps-overlapping-marker-spiderfier/',
						src: [ 'oms.min.js' ],
						dest: 'assets/google-maps-overlapping-marker-spiderfier'
					}
				]
			},
			deploy: {
				src: [
					'**',
					'!.*',
					'!.*/**',
					'!bower.json',
					'!CHANGELOG.md',
					'!Gruntfile.js',
					'!package.json',
					'!phpcs.ruleset.xml',
					'!README.md',
					'!bower_components/**',
					'!examples/**',
					'!node_modules/**',
					'!src/**'
				],
				dest: 'deploy/latest',
				expand: true,
				dot: true
			}
		},

		// Uglify
		uglify: {
			build: {
				files: {
					'js/site.min.js': 'js/site.js',
					'js/admin.min.js': 'js/admin.js'
				}
			},
			assets: {
				files: {
					'assets/google-maps-marker-manager/markermanager.min.js': 'assets/google-maps-marker-manager/markermanager.js',
					'assets/markerclustererplus/markerclusterer.min.js': 'assets/markerclustererplus/markerclusterer.js'
				}
			}
		},

		// Clean
		clean: {
			deploy: {
				src: [ 'deploy/latest' ]
			}
		},

		// Compress
		compress: {
			deploy: {
				options: {
					archive: 'deploy/archives/<%= pkg.name %>.<%= pkg.version %>.zip'
				},
				expand: true,
				cwd: 'deploy/latest',
				src: ['**/*'],
				dest: '<%= pkg.name %>/'
			}
		},

		// Shell
		shell: {
			// Generate readme.txt
			readme_txt: {
				command: 'php src/readme-txt/readme.php > readme.txt'
			},

			// Generate README.md
			readme_md: {
				command: 'php src/readme-md/README.php > README.md'	
			},

			// Generate CHANGELOG.md
			changelog_md: {
				command: 'php src/changelog-md/CHANGELOG.php > CHANGELOG.md'	
			}
		},

		// Git checkout
		gitcheckout: {
			tag: {
				options: {
					branch: 'tags/<%= pkg.version %>'
				}
			},
			develop: {
				options: {
					branch: 'develop'
				}
			}
		},

		// S3
		aws_s3: {
			options: {
				region: 'eu-central-1'
			},
			deploy: {
				options: {
					bucket: 'downloads.pronamic.eu',
					differential: true
				},
				files: [
					{
						expand: true,
						cwd: 'deploy/archives/',
						src: '<%= pkg.name %>.<%= pkg.version %>.zip',
						dest: 'plugins/<%= pkg.name %>/'
					}
				]
			}
		},

		// WordPress deploy
		rt_wp_deploy: {
			app: {
				options: {
					svnUrl: 'http://plugins.svn.wordpress.org/<%= pkg.name %>/',
					svnDir: 'deploy/wp-svn',
					svnUsername: 'pronamic',
					deployDir: 'deploy/latest',
					version: '<%= pkg.version %>'
				}
			}
		}
	} );

	// Default task(s).
	grunt.registerTask( 'default', [ 'jshint', 'phplint', 'phpcs', 'checkwpversion' ] );
	grunt.registerTask( 'pot', [ 'checktextdomain', 'makepot' ] );

	grunt.registerTask( 'build', [
		'shell',
		'default',
		'copy',
		'uglify',
		'pot'
	] );

	grunt.registerTask( 'deploy', [
		'checkwpversion',
		'clean:deploy',
		'copy:deploy',
		'compress:deploy'
	] );

	grunt.registerTask( 'wp-deploy', [
		'gitcheckout:tag',
		'deploy',
		'rt_wp_deploy',
		'gitcheckout:develop'
	] );
	
	grunt.registerTask( 's3-deploy', [
		'gitcheckout:tag',
		'deploy',
		'aws_s3:deploy',
		'gitcheckout:develop'
	] );
};
