var config  = require('../config')
var gulp = require('gulp');
var bump = require('gulp-bump');
var git  = require('gulp-git');
var gutil = require('gulp-util');
var filter = require('gulp-filter');
var exec = require('child_process').exec;
var argv = require('yargs')
    .option('type', {
        alias: 't',
        choices: ['patch', 'minor', 'major']
    })
    .alias('m', 'message')
    .alias('n', 'name')
    // .demand('m')
    .describe('m', 'Write a message for git')
    .describe('m', 'Write a message for git')
    .argv;
var tag = require('gulp-tag-version');
var push = require('gulp-git-push');

/**
 *  Bumping and tagging version, and pushing changes to repository.
 *
 *  You can use the following commands:
 *      gulp release --type=patch   # makes: v1.0.0 → v1.0.1
 *      gulp release --type=minor   # makes: v1.0.0 → v1.1.0
 *      gulp release --type=major   # makes: v1.0.0 → v2.0.0
 *
 *  Please read http://semver.org/ to understand which type to use.
 *
 *  The 'gulp release' task is an example of a release task for a NPM package.
 *  This task will run 'publish' as a dependent and 'bump'.
 **/

// gulp.task('bump', function() {
//   return gulp.src(['./package.json'])
//         // bump package.json and bowser.json version
//         .pipe(bump({
//             type: argv.type || 'patch'
//         }))
//         // save the bumped files into filesystem
//         .pipe(gulp.dest('./'))
//         // // commit the changed files
//         // .pipe(git.commit('bump version'))
//         // // filter one file
//         // .pipe(filter('package.json'))
//         // // create tag based on the filtered file
//         // // .pipe(tag())
//         // // push changes into repository
//         // .pipe(push({
//         //     repository: 'origin',
//         //     refspec: 'HEAD'
//         // }))
// });
//
// gulp.task('git-add', ['bump'], function() {
//   var message = argv.message + " -- TYPE: " + argv.type;
//
//   return gulp.src(config.tasks.deployment.src)
//     .pipe(git.add())
//     .pipe(git.commit(message))
// });
//
// gulp.task('git-push', function() {
//   git.push('origin',config.tasks.deployment.src);
// });
//
// gulp.task('new-branch'), function() {
//   var branch_name = argv.type + "/" + argv.name
//   git.pull('origin', branch_name, function(err) {
//     if (err) {
//       gutil.log("There appears to have been an error.");
//     }
//   });
// });
//
// gulp.task('publish', ['bump'], function (done) {
//     // run npm publish terminal command
//     exec('npm publish',
//         function (error, stdout, stderr) {
//             if (stderr) {
//                 gutil.log(gutil.colors.red(stderr));
//             } else if (stdout) {
//                 gutil.log(gutil.colors.green(stdout));
//             }
//             // execute callback when its done
//             if (done) {
//                 done();
//             }
//         }
//     );
// });
//
// gulp.task('release', ['publish'], function () {});
