module.exports = {
  dev: {
    bsFiles: {
      src: '<%= destFolder %>*.{css,html}'
    },
    options: {
      watchTask: true,
      proxy: '<%= pkg.devUrl %>',
      startPath: '/styleguide/index.html'
    }
  }
}
