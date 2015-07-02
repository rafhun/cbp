module.exports = {
  contentImg: {
    files: [{
      expand: true,
      cwd: '<%=config.srcFolders.contentImg%>',
      src: ['**/*.{png,jpg,gif,svg}', '!**/pixel.gif'],
      dest: '<%= config.buildFolders.contentImg %>'
    }]
  },
  themeImg: {
    files: [{
      expand: true,
      cwd: '<%=config.srcFolders.themeImg %>',
      src: ['**/*.{png,jpg,gif,svg}'],
      dest: '<%= destFolder %><%= config.buildFolders.img %>'
    }]
  }
}
