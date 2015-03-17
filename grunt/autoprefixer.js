module.exports = {
  options: {
    browsers: ['last 2 versions']
  },
  single_files: {
    src: '<%= sass.dist.dest %>',
    dest: '<%= destFolder %>style.css'
  },
  editorStyles: {
    src: '<%=sass.ckstyles.dest %>',
    dest: '<%= destFolder %>editor-styles.css'
  }
}
