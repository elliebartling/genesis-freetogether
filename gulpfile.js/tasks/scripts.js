var config       = require('../config')
if(!config.tasks.scripts) return

var gulp         = require('gulp')
var gulpif       = require('gulp-if')
var browserSync  = require('browser-sync')
var sourcemaps   = require('gulp-sourcemaps')
var handleErrors = require('../lib/handleErrors')
var path         = require('path')
var concat       = require('gulp-concat')
var order        = require('gulp-order')
var debug        = require('gulp-debug')
var jshint       = require("gulp-jshint")
var coffeelint   = require("gulp-coffeelint")
var coffee       = require("gulp-coffee")
var uglify       = require("gulp-uglify")
var babel        = require("gulp-babel")
var stylish      = require('jshint-stylish')
var source       = require('vinyl-source-stream')
var buffer       = require('vinyl-buffer')
var merge        = require('merge-stream')



var gulpWebpack        = require('webpack-stream')
var webpack            = require('webpack')

var rollup       = require('rollup-stream')

var rollupIncludePaths  = require('rollup-plugin-includepaths')
var coffeescript        = require('rollup-plugin-coffee-script')
var resolve             = require('rollup-plugin-node-resolve')
var bowerResolve        = require('rollup-plugin-bower-resolve')
var commonjs            = require('rollup-plugin-commonjs')

const includePathsOptions = {
  include: {},
  paths: ['src/javascripts','node_modules'],
  extensions: ['.js']
}

var paths = {
  src: path.join(config.root.src, config.tasks.scripts.src),
  dest: path.join(config.root.dest, config.tasks.scripts.dest)
}

var entries = path.resolve(paths.src, "geekswithheart.js")

var jsTask = function() {
  return gulp.src([
    'src/javascripts/geekswithheart.js',
    'src/javascripts/filtering.js'
  ])
    .pipe(gulpWebpack(require('../../webpack.config.js')))
    .on('error', handleErrors)
    .pipe(gulpif(global.production, uglify()))
    .pipe(gulp.dest('js/'))
    .pipe(browserSync.stream())
}

gulp.task('scripts', jsTask)
module.exports = jsTask












//   path.resolve(paths.src, "filtering.js"),
// ]

// var jsTask = function() {
//   return rollup({
//       entry: entries,
//       sourceMap: true,
//       sourceMapFile: 'js/geekswithheart.js',
//       format: 'iife',
//       globals: {
//         jQuery: 'jQuery',
//         window: 'window',
//       },
//       plugins: [
//         rollupIncludePaths(includePathsOptions),
//         bowerResolve({
//           // if there's something your bundle requires that you DON'T
//           // want to include, add it to 'skip'
//           // skip: [ 'jquery' ],  // Default: []
//
//           // Override path to main file (relative to the module directory).
//           override: {
//             'shortcode.js': 'src/Shortcode.js'
//           }
//         }),
//         resolve({
//           jsnext: true,
//           main: true,
//           browser: true,
//         }),
//         coffeescript(),
//         babel({
//           exclude: 'node_modules/**',
//           presets: 'es2015'
//         }),
//         commonjs({
//           namedExports: {
//                 'components/jquery/dist/jquery.min.js': [ 'jquery' ],
//                 // 'components/bootstrap/dist/js/bootstrap.min.js' : ['bootstrap'],
//                 // 'components/shortcode/src/Shortcode.js' : ['shortcode.js'],
//               }
//         })
//       ]
//     })
//     // .pipe(debug())
//     .on('error', handleErrors)
//     .pipe(source('geekswithheart.js'))
//     .pipe(buffer())
//     .pipe(sourcemaps.init({loadMaps: true}))
//     .pipe(sourcemaps.write('.'))
//     .pipe(gulp.dest(paths.dest))
//     .pipe(browserSync.stream())
//     // .pipe(gulpif(!global.production, sourcemaps.init()))
//     // .pipe(gulpif(["*.js"], jshint(stylish)))
//     // .pipe(gulpif(["*.js"], babel({ presets: ['es2015'] })))
//     // .pipe(gulpif(["*.coffee"], coffeelint()))
//     // .pipe(gulpif(["*.coffee"], coffee()))
//     // .pipe(jshint.reporter())
//     // .pipe(coffeelint.reporter())
//     // .pipe(gulpif(global.production, uglify()))
//     // .pipe(sourcemaps.write('../maps'))
//     // .pipe(gulp.dest(paths.dest))
// }
