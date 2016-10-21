var config  = require('../config')
if(!config.tasks.deploy) return

var ghPages = require('gulp-gh-pages')
var gulp    = require('gulp')
var open    = require('open')
var os      = require('os')
var package = require('../../package.json')
var path    = require('path')
var filter  = require('gulp-filter')

var sftp    = require('gulp-sftp')
var changed = require('gulp-changed')

var settings = {
  url: config.tasks.deploy.host,
  src: path.join(config.root.dest, '/**/*')
}

// var deployTask = function() {
//   return gulp.src(settings.src)
//     .pipe(ghPages(settings.ghPages))
//     .on('end', function(){
//       open(settings.url)
//     })
// }



var deployTask = function() {
  // Get everything except config files
  const noConfig = filter(['**/*', '!*public/perch/config']);
  const noResources = filter(['**/*', '!*public/perch/resources']);
  const noAddons = filter(['**/*', '!*public/perch/addons']);
  const noCore = filter(['**/*', '!*public/perch/core']);
  const noFonts = filter(['**/*', '!*public/fonts']);

  return gulp.src(settings.src, settings.filter)
  .pipe(changed(config.tasks.deploy.src))
  .pipe(filter(['**/*', '!public/fonts/**']))
  .pipe(filter(['**/*', '!public/perch/config/**']))
  .pipe(filter(['**/*', '!public/perch/resources/**']))
  .pipe(filter(['**/*', '!public/perch/core/**']))
  .pipe(filter(['**/*', '!public/perch/addons/**']))
  .pipe(sftp({
    host: config.tasks.deploy.host,
    user: config.tasks.deploy.keyMain.user,
    pass: config.tasks.deploy.keyMain.passphrase,
    remotePath: config.tasks.deploy.remotePath,
  }));
}

// gulp.task('deploy', deployTask)
gulp.task('deploy', ['production'], deployTask)
module.exports = deployTask
