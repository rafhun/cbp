module.exports = {
  dist: {
    src: [
      '<%= bower_concat.all.dest %>',
      '<%= pkg.srcFolders.js %>plugins.js',
      '<%= pkg.srcFolders.componentsJs %>**/*.js',
      '<%= pkg.srcFolders.js %>script.js'
    ],
    dest: '<%= destFolder %>script.js'
  }
}
