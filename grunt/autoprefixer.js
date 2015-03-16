module.exports = {
  options: {
    browsers: ['last 2 versions']
  },
  single_files: {
    src: '<%= sass.dist.dest %>',
    dest: '<%= destFolder %>style.css'
  },
  ckstyles: {
    src: '<%=sass.ckstyles.dest %>',
    dest: '<%= destFolder %>styles-ck.css'
  }
}
