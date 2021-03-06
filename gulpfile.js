var paths = {
    app: 'app/Resources',
    src: 'web/assets',
    dest: 'web/vendor'
};

var gulp = require('gulp'),
    bower = require('gulp-bower'),
    bowerFiles = require('main-bower-files'),
    less = require('gulp-less-sourcemap'),
    sourcemaps = require('gulp-sourcemaps'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    flatten = require('gulp-flatten'),
    dev = false
;

gulp.task('setdev', function() {
    dev = true;
    gulp.start('default');
});

gulp.task('startsymfonyserver', function() {
    var exec = require('child_process').exec;
    exec('php bin/console server:start', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
    });
});

gulp.task('stopsymfonyserver', function() {
    var exec = require('child_process').exec;
    exec('php bin/console server:stop', function (err, stdout, stderr) {
        console.log(stdout);
        console.log(stderr);
    });
});

gulp.task('less', function() {
    var options = {
        compress: true
    };

    if (dev) {
        options = {
            compress: true,
            sourceMap: {
                sourceMapRootpath: ''
            }
        };
    }

    return gulp.src(paths.app + '/less/app.less').pipe(less(options))
        .on('error', function (e) { console.log('less', e) })
        .pipe(gulp.dest(paths.dest))
    ;

});

gulp.task('js', function() {
    var src = gulp.src(paths.app + '/js/**/*.js');
    if (dev) {
        src.pipe(sourcemaps.init());
    }

    if (!dev) {
        src.pipe(uglify({
            preserveComments: true,
            mangle: true
        }).on('error', function (e) {
            console.log('uglify', e);
        }));
    }

    if (dev) {
        src.pipe(sourcemaps.write());
    }

    return src
        .pipe(concat('app.js'))
        .pipe(gulp.dest(paths.dest))
    ;
});

gulp.task('font', function() {
    return gulp.src(paths.src + '/**/*.{ttf,woff,eof,svg}')
        .pipe(flatten())
        .pipe(gulp.dest(paths.dest))
    ;
});

gulp.task('bower', function() {
    var files = bowerFiles({filter: ['**/*.js'], debug: false});

    var src = gulp.src(files);
    if (dev) {
        src.pipe(sourcemaps.init());
    }

    if (! dev) {
        src.pipe(uglify({
            preserveComments: true,
            mangle: true
        }).on('error', function (e) {
            console.log('uglify', e);
        }));
    }

    if (dev) {
        src.pipe(sourcemaps.write());
    }

    return src
        .pipe(concat('vendor.js'))
        .pipe(gulp.dest(paths.dest))
    ;

});

gulp.task('default', ['less', 'bower', 'js', 'font']);

gulp.task('dev', ['startsymfonyserver', 'setdev'], function() {
    gulp.watch(paths.app + '/less/**/*.less', ['less']);
    gulp.watch(paths.app + '/js/**/*.js', ['js']);
});

gulp.task('stop', ['stopsymfonyserver']);
