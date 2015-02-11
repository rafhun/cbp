module.exports = {
  favicon: {
    options: {
      removeComments: true,
      collapseWhitespace: true
    },
    files: {
      '<%= pkg.src-folders.jade %>favicons.hmtl' : '<%= pkg.src-folders.jade %>favicons.hmtl'
    }
  }
}
