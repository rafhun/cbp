module.exports = {
  favicon: {
    options: {
      removeComments: true,
      collapseWhitespace: true
    },
    files: {
      '<%= pkg.srcFolders.jade %>favicons.html' : '<%= pkg.srcFolders.jade %>favicons.html'
    }
  }
}
