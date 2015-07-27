module.exports = {
  dist: {
    src: [
      '<%= bower_concat.all.dest %>',
      '<%= config.srcFolders.js %>plugins.js',
      '<%= config.srcFolders.moleculesJs %>**/*.js',
      '<%= config.srcFolders.js %>script.js'
    ],
    dest: '<%= destFolder %>script.js'
  }
}
