module.exports = {
  compile: {
    options: {
      data: {
        debug: false
      }
    },
    files: [{
      expand: true,
      cwd: '<%= config.srcFolders.jade %>',
      src: ['*.jade'],
      dest: '<%= destFolder %>',
      ext: '.html'
    }]
  }
}
