module.exports = {
  favicon: {
    options: {
      removeComments: true,
      collapseWhitespace: true
    },
    files: {
      '<%= config.srcFolders.jade %>favicons.html' : '<%= config.srcFolders.jade %>favicons.html'
    }
  }
}
