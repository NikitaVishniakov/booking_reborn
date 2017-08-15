'use strict';

var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function () {
    gulp.src('templates/sass/style.scss')
        .pipe(sass().on('error', sass.logError))
        .pipe(sass({outputStyle: 'compressed'}))
        .pipe(gulp.dest('templates/style'));
});

gulp.task('watch', function () {
    gulp.watch('templates/sass/**/*.scss', ['sass']);
});
