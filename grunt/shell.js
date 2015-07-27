module.exports = {
  bundler: {
    command: 'bundle'
  },
  bower: {
    command: 'bower install'
  },
  bundlerUpdate: {
    command: 'bundle update'
  },
  bowerUpdate: {
    command: 'bower update'
  },
  addChangelog: {
    command: 'git add CHANGELOG.md && git commit --amend --no-edit && git tag v<%= pkg.version %> -m "Version <%= pkg.version %> && git push'
  }
}
