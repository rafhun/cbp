module.exports = {
  fonts: {
    files: [
      {
        expand: true,
        cwd: '<%= config.srcFolders.fonts %>',
        src: ['*'],
        dest: '<%= destFolder %><%= config.buildFolders.fonts %>',
        filter: 'isFile'
      }
    ]
  },
  editorConfig: {
    files: [{
      src: '<%= config.srcFolders.config %>ckeditor.config.js.php',
      dest: '<%= config.buildFolders.editorConfig %>ckeditor.config.js.php'
    }]
  },
  editorStyles: {
    files: [{
      src: '<%= config.srcFolders.css %>editor-styles.css',
      dest: '<%= destFolder %>editor-styles.css'
    }]
  },
  customizing: {
    files: [{
      expand: true,
      cwd: '<%= config.srcFolders.customizing %>',
      src: ['**'],
      dest: '<%= config.buildFolders.customizing %>'
    }]
  },
  editorCustomizing: {
    files: [{
      expand: true,
      cwd: '<%= config.srcFolders.customizing %>lib/ckeditor/',
      src: '**/*.js',
      dest: '<%= config.buildFolders.root%>lib/ckeditor/'
    }]
  }
}
