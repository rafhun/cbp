module.exports = {
  dist: {
    src: [
      '<%= pkg.srcFolders.bower %>**/jquery.min.js',
      '<%= pkg.srcFolders.js %>plugins.js',
      '<%= pkg.srcFolders.js %>script.js'
    ],
    dest: '<%=pkg.srcFolders.jsBuild %>script.js'
  }
}
