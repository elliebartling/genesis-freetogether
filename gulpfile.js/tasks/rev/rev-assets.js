var config    = require('../../config')
var gulp      = require('gulp')
var path      = require('path')
var rev       = require('gulp-rev')
var revNapkin = require('gulp-rev-napkin');

// 1) Add md5 hashes to assets referenced by CSS and JS files
gulp.task('rev-assets', function() {
  // Ignore files that may reference assets. We'll rev them next.
  var ignoreThese = '!' + path.join(config.root.dest,'/**/*+(css|js|json|html)')
  var ignoreSpecific = '!' + path.join(config.root.dest,'/images/form-*.png')

  return gulp.src([path.join(config.root.dest,'/**/*'), ignoreThese, ignoreSpecific])
    .pipe(rev())
    .pipe(gulp.dest(config.root.dest))
    .pipe(revNapkin({verbose: true}))
    .pipe(rev.manifest(path.join(config.root.dest, 'rev-manifest.json'), {merge: true}))
    .pipe(gulp.dest(''))
})
