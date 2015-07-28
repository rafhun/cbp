module.exports = {
  bower: {
    command: 'bower install'
  },
  bowerUpdate: {
    command: 'bower update'
  },
  addChangelog: {
    command: 'git add CHANGELOG.md && git commit --amend --no-edit && git tag v<%= pkg.version %> -m "Version <%= pkg.version %>" && git push && git push --tags'
  }
}
