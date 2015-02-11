module.exports = {
  compile: {
    options: {
      data: {
        debug: false
      }
    },
    files: [{
      expand: true,
      cwd: '<%= pkg.src-folders.jade %>',
      src: ['*.jade'],
      dest: '<%= pkg.build-folders.theme%>',
      ext: '.html'
    }]
  }
}
