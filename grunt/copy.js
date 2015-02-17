module.exports = {
  fonts: [
    {
      expand: true,
      src: ['<%= pkg.srcFolders.fonts %>*'],
      dest: '<%= destFolder %><%= pkg.buildFolders.fonts %>',
      filter: 'isFile'
    }
  ]
}
