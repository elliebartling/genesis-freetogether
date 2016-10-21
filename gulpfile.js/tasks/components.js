var config       = require('../config')
if(!config.tasks.components) return

var gulp         = require('gulp')
var gulpif       = require('gulp-if')
var browserSync  = require('browser-sync')

var filter       = require('gulp-filter')
var concat       = require('gulp-concat')
var sass         = require('gulp-sass')
var less         = require('gulp-less')
var uglify       = require('gulp-uglify')
var bowerfiles   = require('main-bower-files')
var cssnano      = require('gulp-cssnano')
var autoprefixer = require('gulp-autoprefixer')

var util         = require('gulp-util')
var sourcemaps   = require('gulp-sourcemaps')
var handleErrors = require('../lib/handleErrors')
var path         = require('path')

var paths = {
  src: path.join(config.tasks.components.src),
  // ext: {
  //   js: path.join(config.root.src, config.tasks.components.src, '/**/*.js'),
  //   css: path.join(config.root.src, config.tasks.components.src, '/**/*.css')
  // },
  dest: path.join(config.root.dest)
}

var jsComponentsTask = function () {
  return gulp.src(bowerfiles({'debugging': false, 'filter':'**/*.{js,coffee}', 'overrides': config.tasks.components.overrides}), { base: paths.src })
    .pipe(gulpif(!global.production, sourcemaps.init()))
    .pipe(filter(['**/*.js']))
    .on('error', handleErrors)
    .pipe(gulpif(/[.]js$/, concat('vendor.js')))
    .pipe(gulpif(!global.production, sourcemaps.write()))
    .pipe(gulp.dest(paths.dest + "/js"))
    .pipe(browserSync.stream())
}

var cssComponentsTask = function () {
  return gulp.src(bowerfiles({'debugging': false, filter:'**/*.{css,scss,less,sass}', 'overrides': config.tasks.components.overrides}), { base: paths.src })
    .pipe(gulpif(!global.production, sourcemaps.init()))
    .pipe(filter(['**/*.{css,less,scss,sass}']))
    .on('error', handleErrors)
    .pipe(gulpif(/[.]less$/, less()))
    .pipe(gulpif(/[.]scss$/, sass()))
    .pipe(concat('vendor.css'))
    .pipe(autoprefixer(config.tasks.css.autoprefixer))
    .pipe(gulpif(global.production, cssnano({autoprefixer: false})))
    .pipe(gulpif(!global.production, sourcemaps.write()))
    .pipe(gulp.dest(paths.dest + "/css"))
    .pipe(browserSync.stream())
}

gulp.task('css-components', cssComponentsTask)
module.exports = cssComponentsTask

gulp.task('js-components', jsComponentsTask)
module.exports = jsComponentsTask

gulp.task('components', ['css-components']);
