module.exports = {
  options: {
    renameFiles: true,
    fileNameFormat: '${name}.${hash}.${ext}'
  },
  prod: {
    src: [
      '<%= pkg.build-folders.theme %>style.min.css',
      '<%= pkg.build-folders.theme %>script.min.js'
    ],
    dest: '<%=pgk.build-folders.theme %>index.html'
  }
}
