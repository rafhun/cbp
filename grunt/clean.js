module.exports = {
  hashes: ['<%= destFolder %>{style.min.*.css,script.min.*.js}'],
  hashedCss: ['<%= destFolder %>style.min.*.css'],
  hashedJs: ['<%= destFolder %>script.min.*.js'],
  html: ['<%= destFolder %>*.html'],
  images: ['<%= destFolder %><%= config.buildFolders.img %>'],
  dest: ['<%= destFolder %>'],
  contrexx: ['wwwroot/images/**/*.{jpg,jpeg,gif,png,thumb,pdf,ico,db,html}', 'wwwroot/themes/skeleton_3_0'],
  editorStyles: ['<%= destFolder %>style-ck.css'],
  editorConfig: ['<%= config.buildFolders.editorConfig %>ckeditor.config.js.php'],
  customizing: ['<%= config.buildFolders.customizing %>'],
  minSvg: ['<%= config.srcFolders.iconsMin %>**/*.svg'],
  favicon: ['<%= config.srcFolders.jade %>favicons.html']
}
