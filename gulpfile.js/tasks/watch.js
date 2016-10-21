var config = require('../config')
var gulp   = require('gulp')
var path   = require('path')
var watch  = require('gulp-watch')
var gutil  = require('gulp-util')

var watchTask = function() {
  var watchableTasks = ['fonts', 'iconFont', 'images', 'svgSprite','html', 'css', 'static','scripts']

  watchableTasks.forEach(function(taskName) {
    var task = config.tasks[taskName]
    if(task) {
      var glob = path.join(config.root.src, task.src, '**/*.{' + task.extensions.join(',') + '}')
      watch(glob, function() {
       require('./' + taskName)()
      })
      gutil.log("Watching: " + gutil.colors.cyan(taskName) + "[" + gutil.colors.red(glob) + "]")
    }
  })
}

gulp.task('watch', ['browserSync'], watchTask)
gulp.task('watch-production', ['clean','production','browserSync','watch'])
module.exports = watchTask
