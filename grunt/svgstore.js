module.exports = {
  options: {
    prefix: 'shape-',
    cleanup: false,
    svg: {
      style: 'display: none;'
    }
  },
  default: {
    files: {
      '<%= pkg.src-folders.images %>shapes.svg' : ['<%= pkg.src-folders.svg %>*.svg']
    }
  }
}
