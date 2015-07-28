module.exports = {
  contrexx: ['wwwroot/images/**/*.{jpg,jpeg,gif,png,thumb,pdf,ico,db,html}', 'wwwroot/themes/skeleton_3_0', 'wwwroot/installer'],
  customizing: ['<%= config.buildFolders.customizing %>'],
  dest: ['<%= destFolder %>'],
  editorConfig: ['<%= config.buildFolders.editorConfig %>ckeditor.config.js.php'],
  editorStyles: ['<%= destFolder %>style-ck.css'],
  favicon: ['<%= config.srcFolders.jade %>favicons.html'],
  hashes: ['<%= destFolder %>{style.min.*.css,script.min.*.js}'],
  hashedCss: ['<%= destFolder %>style.min.*.css'],
  hashedJs: ['<%= destFolder %>script.min.*.js'],
  htaccess: ['<%= config.buildFolders.root %>.htaccess'],
  html: ['<%= destFolder %>*.html'],
  images: ['<%= destFolder %><%= config.buildFolders.img %>'],
  minSvg: ['<%= config.srcFolders.iconsMin %>**/*.svg']
}
