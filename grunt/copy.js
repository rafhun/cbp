module.exports = {
  fonts: {
    files: [
      {
        expand: true,
        src: ['<%= pkg.srcFolders.fonts %>*'],
        dest: '<%= destFolder %><%= pkg.buildFolders.fonts %>',
        filter: 'isFile'
      }
    ]
  },
  editorConfig: {
    files: [{
      src: '<%= pkg.srcFolders.config %>ckeditor.config.js.php',
      dest: '<%= pkg.buildFolders.editorConfig %>ckeditor.config.js.php'
    }]
  }
}
