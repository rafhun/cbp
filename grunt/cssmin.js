module.exports = {
  combine: {
    files: {
      '<%= pkg.build-folders.theme %>style.min.css': ['<%= pkg.source-folders.css %>style-prefixed.css']
    }
  }
}
