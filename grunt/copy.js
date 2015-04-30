module.exports = {
  fonts: {
    files: [
      {
        expand: true,
        cwd: '<%= pkg.srcFolders.fonts %>',
        src: ['*'],
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
  },
  editorStyles: {
    files: [{
      src: '<%= pkg.srcFolders.css %>editor-styles.css',
      dest: '<%= destFolder %>editor-styles.css'
    }]
  },
  customizing: {
    files: [{
      expand: true,
      cwd: '<%= pkg.srcFolders.customizing %>',
      src: ['**'],
      dest: '<%= pkg.buildFolders.customizing %>'
    }]
  },
  editorCustomizing: {
    files: [{
      expand: true,
      cwd: '<%= pkg.srcFolders.customizing %>lib/ckeditor/',
      src: '**/*.js',
      dest: '<%= pkg.buildFolders.root%>lib/ckeditor/'
    }]
  }
}
