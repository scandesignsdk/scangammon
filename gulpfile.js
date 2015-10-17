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
    dev = false
;

gulp.task('setdev', function() {
    dev = true;
    gulp.start('default');
});

gulp.task('less', function() {
    var options = {
        compress: true,
        sourceMap: false
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

gulp.task('bower', function() {
    var files = bowerFiles({filter: ['**/*.js'], debug: false});
    files.push(paths.app + '/js/**/*.js');

    var src = gulp.src(files);
    if (dev) {
        src.pipe(sourcemaps.init());
    }

    src.pipe(uglify({
        preserveComments: true,
        mangle: true
    })
        .on('error', function (e) { console.log('uglify', e); }))
    ;

    if (dev) {
        src.pipe(sourcemaps.write());
    }

    return src
        .pipe(concat('app.js'))
        .pipe(gulp.dest(paths.dest))
    ;

});

gulp.task('default', ['less', 'bower']);
gulp.task('dev', ['setdev']);
