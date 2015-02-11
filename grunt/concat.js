module.exports = {
  dist: {
    src: [
      '<%= pkg.source-folders.bower %>**/jquery.min.js',
      '<%= pkg.source-folders.js %>*.js'
    ],
    dest: '<%=pkg.source-folders.jsBuild %>script.js'
  }
}
