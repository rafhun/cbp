module.exports = {
  contentImg: {
    files: [{
      expand: true,
      cwd: '<%=pkg.src-folders.contentImg%>',
      src: ['**/*.{png,jpg,gif,svg}', '!**/pixel.gif'],
      dest: '<%= pkg.buildFolders.contentImg %>'
    }]
  },
  themeImg: {
    files: [{
      expand: true,
      cwd: '<%=pkg.src-folders.themeImg %>',
      src: ['**/*.{png,jpg,gif,svg}'],
      dest: '<%= destFolder %><%= pkg.buildFolders.img %>'
    }]
  }
}
