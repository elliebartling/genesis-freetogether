var config       = require('../config')
if(!config.tasks.css) return

var gulp         = require('gulp')
var gulpif       = require('gulp-if')
var browserSync  = require('browser-sync')
var sass         = require('gulp-sass')
var sourcemaps   = require('gulp-sourcemaps')
var handleErrors = require('../lib/handleErrors')
var autoprefixer = require('gulp-autoprefixer')
var path         = require('path')
var cssnano      = require('gulp-cssnano')
var concat       = require('gulp-concat-css');
var order        = require('gulp-order');
var debug        = require('gulp-debug');
var uncss        = require('gulp-uncss');

var paths = {
  src: path.join(config.root.src, config.tasks.css.src),
  dest: path.join(config.root.dest, config.tasks.css.dest)
}

var cssTask = function () {
  return gulp.src([paths.src + '/main.sass'])
    .pipe(gulpif(!global.production, sourcemaps.init()))
    // .pipe(order([
    //   "stylesheets/main.sass",
    //   "stylesheets/geekswithheart.scss",
    //   // "stylesheets/**/*.{scss,sass}"
    // ]))
    .pipe(gulpif('*.{scss,sass}', sass(config.tasks.css.sass)))
    .on('error', handleErrors)
    .pipe(debug())
    .pipe(concat('main.css'))
    // .pipe(gulpif(global.production, uncss({
    //   html: ['./layouts/*.html',
    //          './templates/*.html',
    //          './partials/*.html',
    //          'http://emergentorder.dev',
    //          'http://emergentorder.dev/work',
    //          'http://emergentorder.dev/work/end-the-hall-tax',
    //          'http://emergentorder.dev/careers',
    //          'http://emergentorder.dev/capabilities',
    //          'http://emergentorder.dev/about',
    //          'http://emergentorder.dev/contact'
    //        ],
    //   ignore: [
    //     /green/,
    //     '.hide',
    //     '.loaded',
    //     '.lazy',
    //     '.collapse',
    //     '.rotating',
    //     /is-active/,
    //     /modal/,
    //     /icon/,
    //     /fv-form-bootstrap/,
    //     /fa/,
    //     /featherlight/,
    //     '.bg-primary'
    //   ],
    //   // ignoreSheets: ['stylesheets/components/nav.sass']
    // })))
    .pipe(autoprefixer(config.tasks.css.autoprefixer))
    .pipe(gulpif(global.production, cssnano({autoprefixer: false})))
    .pipe(gulpif(!global.production, sourcemaps.write()))
    .pipe(gulp.dest(paths.dest))
    .pipe(browserSync.stream())
}

gulp.task('css', cssTask)
module.exports = cssTask
