module.exports = {
  dev: {
    bsFiles: {
      src: '<%= destFolder %>*.css'
    },
    options: {
      watchTask: true,
      proxy: '<%= config.devUrl %>',
      startPath: 'styleguide/index.html'
    }
  }
}
