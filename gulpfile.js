// variables

var gulp = require ('gulp'),
	watch = require ('gulp-watch'),
	autoprefix = require ('gulp-autoprefixer'),
	browserSync = require ('browser-sync'),
	sass = require ('gulp-ruby-sass');

// starts browsersync and a server

gulp.task('server', function () {
	browserSync.init({
		// watch the following files; changes will be injected (css & images) or cause browser to refresh
    files: [
    	'controllers/*.php', 
    	'views/**/*',
      'assets/**/*', 
    	'models/*.php',
    	'index.php'
    ],

    // informs browser-sync to proxy our expressjs app which would run at the following location
    proxy: 'http://localhost:8888/dsa-civilwar/',

    // informs browser-sync to use the following port for the proxied app
    // notice that the default port is 3000, which would clash with our expressjs
    port: 9000,

    // open the proxied app in chrome
    browser: ['google chrome']
	});
});

// prefix waits for sass
gulp.task('sass', function () {
	return gulp.src('src/scss/*.scss')
		.pipe(sass())
		.pipe(gulp.dest('src/css'));
});

gulp.task('prefix', ['sass'], function () {
	return gulp.src('./assets/css/*.css')
		.pipe(autoprefix({
			browsers: ['last 2 versions'],
			cascade: true,
			remove: false
		}))
		.pipe(gulp.dest('./assets/css/'));
});

// starts the watch task

gulp.task('default', ['server', 'prefix']);