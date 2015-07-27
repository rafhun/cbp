module.exports = {
  options: {
    changelogOpts: {
      // conventional-changelog options go here
      preset: 'angular'
    },
    context: {
      // context goes here
    },
    gitRawCommitsOpts: {
      // git-raw-commits options go here
    },
    parserOpts: {
      // conventional-commits-parser options go here
    },
    writerOpts: {
      // conventional-changelog-writer options go here
    }
  },
  release: {
    src: 'CHANGELOG.md'
  }
}
