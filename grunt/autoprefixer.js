module.exports = {
  options: {
    browsers: ['last 2 version']
  },
  multiple_files: {
    expand: true,
    flatten: true,
    src: '<%= pkg.source-folders.css %>style.css',
    dest: '<%= pkg.source-folders.css %>style-prefixed.css'
  }
}
