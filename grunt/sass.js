module.exports = {
  dist: {
    options: {
      style: 'expanded',
      require: 'susy'
    },
    src: '<%= pkg.srcFolders.scss %>main.scss',
    dest: '<%= pkg.srcFolders.css %>style.css',
  }
}
