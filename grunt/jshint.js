module.exports = {
  options: {
    jshintrc: true,
  },
  grunt: ['Gruntfile.js', 'grunt/*.js'],
  src: [
    '<%= config.srcFolders.componentsJs %>**',
    '<%= config.srcFolders.js %>script.js'
    ],
  shipping: {
    options: {
      jshintrc: '.jshintrc-dist',
    },
    files: {
      src: ['<%= config.srcFolders.js %>script.js'],
    }
  }
}
