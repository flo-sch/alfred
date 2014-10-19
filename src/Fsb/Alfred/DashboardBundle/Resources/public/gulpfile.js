// Gulp and utils
var gulp       = require('gulp'),
  gutil        = require('gulp-util'),
  size         = require('gulp-size'),
  rename       = require('gulp-rename'),
  clean        = require('gulp-clean'),
  watch        = require('gulp-watch'),
  notify       = require('gulp-notify'),
  connect      = require('gulp-connect'),
  livereload   = require('gulp-livereload'),
  lr           = require('tiny-lr'),
  server       = lr(),
  // Styles [sass, css]
  sass         = require('gulp-ruby-sass'),
  minifycss    = require('gulp-minify-css'),
  autoprefixer = require('gulp-autoprefixer'),
  // Scripts [coffee, js]
  // coffee       = require('gulp-coffee'),
  // coffeelint   = require('gulp-coffeelint'),
  // uglify       = require('gulp-uglify'),
  // concat       = require('gulp-concat'),
  // Images
  imagemin     = require('gulp-imagemin'),
  // Variables
  __ports = {
    server: 1355,
    livereload: 35749
  },
  __folders = {
    source: {
      scripts: 'coffee',
      styles: 'sass',
      images: 'images',
      fonts: 'fonts'
    },
    dest: {
      scripts: 'js',
      styles: 'css',
      images: 'images',
      fonts: 'fonts'
    }
  };

// Styles
gulp.task('styles', function () {
  return gulp.src([
      __folders.source.styles + '/{,*/}*.{scss,sass}',
      '!' + __folders.source.styles + '/_{,*/}*.{scss,sass}',
      '!' + __folders.source.styles + '/bourbon/*.{scss,sass}'
    ])
    .pipe(sass({
      style: 'expanded',
      quiet: true,
      trace: true
    }))
    .on('error', gutil.log)
    .pipe(gulp.dest(__folders.dest.styles))
    .pipe(autoprefixer('last 2 version', 'ie 8', 'ie 9'))
    .on('error', gutil.log)
    .pipe(size())
    .pipe(minifycss())
    .pipe(size())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest(__folders.dest.styles))
    .pipe(livereload(server))
    .pipe(notify({
      message: 'Styles task completed @ <%= options.date %>',
      templateOptions: {
        date: new Date()
      }
    }));
});

// Scripts
// gulp.task('scripts', function () {
//   return gulp.src([
//       __folders.source.scripts + '/{,*/}*.coffee',
//       '!' + __folders.source.scripts + '/_{,*/}*.coffee'
//     ])
//     .pipe(coffee({
//       bare: true
//     }))
//     .on('error', gutil.log)
//     .pipe(coffeelint())
//     .on('error', gutil.log)
//     .pipe(coffeelint.reporter())
//     .on('error', gutil.log)
//     .pipe(size())
//     .on('error', gutil.log)
//     .pipe(gulp.dest(__folders.dest.scripts))
//     .pipe(uglify())
//     .on('error', gutil.log)
//     .pipe(rename({
//         suffix: '.min'
//     }))
//     .pipe(size())
//     .on('error', gutil.log)
//     .pipe(gulp.dest(__folders.dest.scripts))
//     .pipe(livereload(server))
//     .pipe(notify({
//       message: 'Scripts task completed @ <%= options.date %>',
//       templateOptions: {
//         date: new Date()
//       }
//     }));
// });

// Images
gulp.task('images', function () {
    return gulp.src(__folders.source.images + '/{,*/}*.{jpg,gif,png}')
      .pipe(imagemin({
        optimizationLevel: 3,
        progressive: true,
        interlaced: true
      }))
      .on('error', gutil.log)
      .pipe(size())
      .pipe(gulp.dest(__folders.source.images))
      .pipe(livereload(server))
      .pipe(notify({
        message: 'Images task completed @ <%= options.date %>',
        templateOptions: {
          date: new Date()
        }
      }));
});

gulp.task('fonts', function () {
  return gulp.src([
      'bower_components/font-awesome/fonts/{,*/}*.*',
      'bower_components/bootstrap/fonts/{,*/}*.*'
    ])
    .pipe(size())
    .pipe(gulp.dest(__folders.dest.fonts))
    .pipe(notify({
      message: 'Fonts task completed @ <%= options.date %>',
      templateOptions: {
        date: new Date()
      }
    }));
});

// Connect & livereload
gulp.task('connect', function () {
  connect.server({
    root: __dirname + '/../',
    port: __ports.server,
    livereload: true,
    open: {
      browser: 'Google Chrome'
    }
  });
});

// Watch
gulp.task('watch', function () {
  // Listen on port 35730
  server.listen(__ports.livereload, function (error) {
    if (error) {
      return console.error(error);
    }

    // Watch .scss files
    gulp.watch(__folders.source.styles + '/{,*/}*.{scss,sass}', ['styles']);

    // Watch .coffee files
    // gulp.watch(__folders.source.scripts + '/{,*/}*.coffee', ['scripts']);
  });
});

// gulp.task('assets', ['styles', 'scripts', 'images', 'fonts']);
gulp.task('assets', ['styles', 'images', 'fonts']);

// Serve
gulp.task('serve', ['assets'], function () {
  gulp.start('watch');
});

// Default task
gulp.task('default', ['serve']);
