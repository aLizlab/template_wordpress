const gulp = require("gulp");
const sass = require("gulp-sass");
const plumber = require("gulp-plumber");
const pug = require("gulp-pug");
const rename = require("gulp-rename");
const autoprefixer = require("gulp-autoprefixer");
const babel = require("gulp-babel");

// 画像の圧縮関係
const imagemin = require('gulp-imagemin');
const imageminJpg = require('imagemin-jpeg-recompress');
const imageminPng = require('imagemin-pngquant');
const imageminGif = require('imagemin-gifsicle');
const svgmin = require('gulp-svgmin');

const browserSync = require("browser-sync").create();;
const notifier = require("node-notifier");

var onError = function(error) {
  notifier.notify(
    {
      message: "しっぱいしたワン",
      title: "パグ"
    },
    function() {
      console.log(error.message);
    }
  );
};

gulp.task("default", ["sass", "js", "watch", "browser-sync"]);

// WordPressでの書き出し用
gulp.task("build", ["sass", "js", "image-min"], cb => {
  // CSS, JS をコピー
  gulp
    .src(["./assets/**/*.css", "./assets/**/*.js", "!./assets/imgs/**/*"], {
      base: './assets/'
    })
    .pipe(gulp.dest("./dist/assets/"));

  // WordPress Template に必要なファイルをコピー
  gulp
    .src(["./**/*.php", "./style.css", "./screenshot.png"], {
      base: './'
    })
    .pipe(gulp.dest("./dist/"));

  cb();
});

// 画像の圧縮タスク
gulp.task('image-min', ["svg-min"], cb => {
  gulp.src("./assets/imgs/**/*.+(jpg|jpeg|png|gif)")
    .pipe(imagemin([
        imageminPng(),
        imageminJpg(),
        imageminGif({
          interlaced: false,
          optimizationLevel: 3,
          colors:180
        })
      ]
    ))
    .pipe(gulp.dest("./dist/assets/imgs/"));
  cb();
});

// svg画像の圧縮タスク
gulp.task('svg-min', cb => {
  gulp.src("./assets/imgs/**/*.+(svg)")
    .pipe(svgmin())
    .pipe(gulp.dest("./dist/assets/imgs/"));
  cb();
});

gulp.task("browser-sync", cb => {
  browserSync.init({
    files: ['./**/*.php'],
    proxy: 'http://localhost/wordpress/',
    port: 3100
  });
  cb();
});

gulp.task("watch", cb => {
  gulp.watch("./src/sass/**/*.scss", () => {
    console.log("sass");
    gulp.start(["sass"]);
    gulp.start(["reload"]);
  });

  gulp.watch("./src/js/**/*.js", () => {
    console.log("js");
    gulp.start(["js"]);
    gulp.start(["reload"]);
  });

  gulp.watch("./**/*.php", () => {
    console.log("php");
    gulp.start(["reload"]);
  });
  cb();
});

gulp.task("reload", cb => {
  browserSync.reload();
  cb();
});

gulp.task("sass", cb => {
  gulp
    .src(["./src/sass/**/*.scss", "!./src/sass/**/_*.scss", "!./src/sass/app.scss"])
    .pipe(
      plumber({
        errorHandler: onError
      })
    )
    .pipe(
      sass({
        outputStyle: "expanded"
      })
    )
    .pipe(
      autoprefixer({
        browsers: ["last 2 versions", "ie >= 11", "Android >= 4"],
        cascade: false
      })
    )
    .pipe(gulp.dest("./assets/css/"))
    .pipe(browserSync.stream());
  cb();
});

gulp.task("js", cb => {
  gulp
    .src("./src/js/**/*.js")
    .pipe(plumber())
    .pipe(babel())
    .pipe(gulp.dest("./assets/js/"))
    .pipe(browserSync.stream());
  cb();
});
