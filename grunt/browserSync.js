module.exports = {
  dev: {
    bsFiles: {
      src: '<%= destFolder %>*.{css,html,js}'
    },
    options: {
      watchTask: true,
      proxy: '<%= config.devUrl %>',
      startPath: 'styleguide/index.html'
    }
  }
}
