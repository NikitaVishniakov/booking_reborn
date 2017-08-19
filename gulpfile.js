'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');
var prefix = require('gulp-autoprefixer');

gulp.task('sass', function () {
    gulp.src('templates/sass/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(prefix('last 2 versions'))
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(gulp.dest('templates/style'));
});
gulp.task('watch', function () {
    gulp.watch('templates/sass/**/*.scss', ['sass']);
});
