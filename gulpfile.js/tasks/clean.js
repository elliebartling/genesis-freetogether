var gulp   = require('gulp')
var del    = require('del')
var config = require('../config')

var cleanTask = function (cb) {
  var ignore = gulp.src([config.root.dest, '!components','!node_modules','!gulpfile.js'])
  del(['./js','./css','./layouts','./templates','./img','./partials','./fonts','./rev-manifest.json'])
    .then(paths => {
      console.log('Files and folders that would be deleted:\n', paths.join('\n'));
      cb()
    })
}

gulp.task('clean', cleanTask)
module.exports = cleanTask
