var config  = require('../config')
var changed = require('gulp-changed')
var gulp    = require('gulp')
var path    = require('path')
var browserSync  = require('browser-sync')
var inject    = require('gulp-inject')
var gulpif    = require('gulp-if')
var debug    = require('gulp-debug')

var paths = {
  src: [
    path.join(config.root.src, config.tasks.static.src, '**/*.php'),
    path.join('!' + config.root.src, config.tasks.static.src, '/README.md')
  ],
  dest: path.join(config.root.dest, config.tasks.static.dest)
}

var staticTask = function() {
  // var sources = gulp.src(['css/*.css','js/*.js','js/geekswithheart.js'])
  return gulp.src(paths.src)
    .pipe(changed(paths.dest)) // Ignore unchanged files
    // .pipe(gulpif('layouts/default.html', inject((sources), {
    //     transform: function (filepath) {
    //       if (filepath.slice(-4) === '.css') {
    //         return '<link rel="stylesheet" href="{{ theme:asset src="' + filepath + '"}}">'
    //       }
    //       return '<script src="{{ theme:asset src="' + filepath + '"}}"></script>'
    //     }
    //   })))
    .pipe(debug())
    .pipe(gulp.dest(paths.dest))
    .pipe(browserSync.stream())
}

var injectAssets = function() {
  var sources = gulp.src(['css/*.css','js/*.js','js/geekswithheart.js'])
  return gulp.src('layouts/default.html')
    .pipe(inject((sources), {
        transform: function (filepath) {
          if (filepath.slice(-4) === '.css') {
            return '<link rel="stylesheet" href="{{ theme:asset src="' + filepath + '"}}">'
          }
          return '<script src="{{ theme:asset src="' + filepath + '"}}"></script>'
        }
      }))
      .pipe(debug())
    .pipe(gulp.dest('layouts'))
    .pipe(browserSync.stream())
}

gulp.task('static', staticTask)
gulp.task('inject', injectAssets)
module.exports = staticTask
