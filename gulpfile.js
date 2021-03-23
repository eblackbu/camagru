const gulp = require('gulp');
const sass = require('gulp-sass');
const browserSync = require('browser-sync');

function style() {
    return gulp.src('./src/style/scss/**/*.scss')
        .pipe(sass())
        .pipe(gulp.dest('./src/style/css'))
        .pipe(browserSync.stream())
}

function watch() {
    browserSync.init({
        server: {
            baseDir: './'
        }
    });
    gulp.watch('./src/style/scss/**/*.scss', style);
    gulp.watch('./*.html').on('change', browserSync.reload);
}

exports.style = style;
exports.watch = watch;