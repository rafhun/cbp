module.exports = {
  build: {
    src: '<%= concat.dist.dest',
    dest: '<%= pkg.build-folders.theme %>script.min.js'
  }
}
