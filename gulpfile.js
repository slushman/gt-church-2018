/**
 * WordPress Theme-specific Gulp file.
 *
 * Instructions
 *
 * In command line, cd into the project directory and run the following two commands:
 * npm init
 * npm install
 * 
 * npm install --save-dev gulp gulp-util gulp-load-plugins browser-sync fs path event-stream gulp-plumber
 * npm install --save-dev gulp-sourcemaps gulp-autoprefixer gulp-filter gulp-clean-css gulp-concat gulp-uglify-es gulp-notify gulp-imagemin gulp-rename gulp-wp-pot gulp-sort gulp-parker gulp-svgmin gulp-size
 * npm install --save-dev gulp-sass
 *
 * Implements:
 * 		1. Live reloads browser with BrowserSync.
 * 		2. CSS: Sass to CSS conversion, error catching, Autoprixing, Sourcemaps,
 * 			 CSS minification, and Merge Media Queries.
 * 		3. JS: Concatenates & uglifies JS files in sub-directories to respective files.
 * 		4. Images: Minifies PNG, JPEG, GIF and SVG images.
 * 		5. Watches files for changes in CSS or JS.
 * 		6. Watches files for changes in PHP.
 * 		7. Corrects the line endings.
 *      8. InjectCSS instead of browser page reload.
 *      9. Generates .pot file for i18n and l10n.
 *
 * @since 1.0.0
 * @author Chris Wilcoxson (@slushman)
 */

var project = {
	'url': 'gt.test',
	'i18n': {
		'domain': 'gt',
		'destFile': 'gt-church-2018.pot',
		'package': 'GTChurch2018',
		'bugReport': 'https://github.com/slushman/gt-church-2018/issues',
		'translator': 'Chris Wilcoxson <chris@slushman.com>',
		'lastTranslator': 'Chris Wilcoxson <chris@slushman.com>',
		'path': './assets/languages',
	}
};

var watch = {
	'php': './*.php',
	'scripts': {
		'path': './src/js/',
		'source': './src/js/**/*.js',
	},
	'styles': './src/scss/**/*.scss',
}

/**
 * Browsers you care about for autoprefixing.
 */
const AUTOPREFIXER_BROWSERS = [
	'last 2 version',
	'> 1%',
	'ie >= 9',
	'ie_mob >= 10',
	'ff >= 30',
	'chrome >= 34',
	'safari >= 7',
	'opera >= 23',
	'ios >= 7',
	'android >= 4',
	'bb >= 10'
];

/**
 * Load gulp plugins and assign them semantic names.
 */
var gulp = require('gulp');
var plugins = require('gulp-load-plugins')();
var browserSync = require('browser-sync').create();
var reload = browserSync.reload;
var fs = require('fs');
var path = require('path');
var es = require('event-stream');
var uglify = require('gulp-uglify-es').default;

var onError = function (err) { console.log(err); }

/**
 * Creates style files and put them in the root folder.
 */
gulp.task('styles', function () {
	gulp.src(watch.styles)
		.pipe(plugins.plumber({ errorHandler: onError }))
		.pipe(plugins.sourcemaps.init())
		.pipe(plugins.sass({
			errLogToConsole: true,
			includePaths: ['./scss'],
			outputStyle: 'compact',
			precision: 10
		}))
		.pipe(plugins.autoprefixer(AUTOPREFIXER_BROWSERS))
		.pipe(plugins.filter('**/*.css')) // Filtering stream to only css files
		.pipe(plugins.cleanCss({
			debug: true
		},
			(details) => {
				console.log(`${details.name} original size: ${details.stats.originalSize}`);
				console.log(`${details.name} minified size: ${details.stats.minifiedSize}`);
			}
		))
		.pipe(plugins.sourcemaps.write('./', { includeContent: false }))
		.pipe(gulp.dest('./'))

		.pipe(plugins.filter('**/*.css')) // Filtering stream to only css files
		.pipe(browserSync.stream()) // Reloads style.css if that is enqueued.
		.pipe(plugins.parker({
			file: false,
			title: 'Parker Results',
			metrics: [
				'TotalStylesheetSize',
				'MediaQueries',
				'SelectorsPerRule',
				'IdentifiersPerSelector',
				'SpecificityPerSelector',
				'TopSelectorSpecificity',
				'TopSelectorSpecificitySelector',
			]
		}))
		.pipe(plugins.notify({ message: 'TASK: "styles" Completed! 💯', onLast: true }))
});

/**
 * Returns all the folders in a directory.
 *
 * @see 	https://gist.github.com/jamescrowley/9058433
 */
function getFolders(dir) {
	return fs.readdirSync(dir)
		.filter(function (file) {
			return fs.statSync(path.join(dir, file)).isDirectory();
		});
}

/**
 * Creates a minified javascript file for each folder in the source directory.
 */
gulp.task('scripts', function () {
	var folders = getFolders(watch.scripts.path);

	var tasks = folders.map(function (folder) {

		return gulp.src(path.join(watch.scripts.path, folder, '/*.js'))
			.pipe(plugins.plumber({ errorHandler: onError }))
			.pipe(plugins.sourcemaps.init())
			.pipe(plugins.concat(folder + '.js'))
			.pipe(gulp.dest('./assets/js'))
			.pipe(uglify())
			.pipe(plugins.rename(folder + '.min.js'))
			.pipe(plugins.sourcemaps.write('maps'))
			.pipe(gulp.dest('./assets/js'));
	});

	return es.concat.apply(null, tasks)
		.pipe(plugins.notify({ message: 'TASK: "scripts" Completed! 💯', onLast: true }));
});

/**
 * Live Reloads, CSS injections, Localhost tunneling.
 *
 * @link	https://browsersync.io/docs/options/
 */
gulp.task('browser-sync', function () {
	browserSync.init({
		proxy: project.url,
		host: project.url,
		open: 'external',
		injectChanges: true,
		browser: "google chrome"
	});
});

/**
 * Minifies PNG, JPEG, GIF and SVG images.
 */
gulp.task('images', function () {
	gulp.src('./src/images/*.{png,jpg,gif,svg}', { nodir: true })
		.pipe(plugins.plumber({ errorHandler: onError }))
		.pipe(plugins.imagemin({
			progressive: true,
			optimizationLevel: 3, // 0-7 low-high
			interlaced: true,
			svgoPlugins: [{ removeViewBox: false }]
		}))
		.pipe(gulp.dest('./assets/images/'))
		.pipe(plugins.notify({ message: 'TASK: "images" Completed! 💯', onLast: true }));
});

/**
 * WP POT Translation File Generator.
 */
gulp.task('translate', function () {
	return gulp.src(watch.php)
		.pipe(plugins.plumber({ errorHandler: onError }))
		.pipe(plugins.sort())
		.pipe(plugins.wpPot(project.i18n))
		.pipe(gulp.dest(project.i18n.path))
		.pipe(plugins.notify({ message: 'TASK: "translate" Completed! 💯', onLast: true }));
});

/**
* Watches for file changes and runs specific tasks.
*/
gulp.task('default', ['styles', 'scripts', 'images', 'translate', 'browser-sync'], function () {
	gulp.watch(watch.php, reload); // Reload on PHP file changes.
	gulp.watch(watch.styles, ['styles', reload]); // Reload on SCSS file changes.
	gulp.watch(watch.scripts.source, ['scripts', reload]); // Reload on publicJS file changes.
});
