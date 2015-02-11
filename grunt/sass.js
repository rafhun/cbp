module.exports = {
  dist: {
    options: {
      style: 'expanded',
      require: 'susy'
    },
    files: {
      '<%= pkg.src-folders.css %>main.css': '<%= pkg.src-folders.scss %>main.scss'
    }
  }
}
