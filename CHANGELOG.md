<a name="1.1.6"></a>
## [1.1.6](https://github.com/rafhun/cbp/compare/v1.1.5...v1.1.6) (2015-08-15)


### Bug Fixes

* **grunt:** reorder tasks more logically ([43f2f12](https://github.com/rafhun/cbp/commit/43f2f12))
* **js:** relax jshint to allow unused ([24b18de](https://github.com/rafhun/cbp/commit/24b18de))



<a name="1.1.5"></a>
## 1.1.5 (2015-07-31)


### Features

* **grunt:** add releaseCount option for changelog ([276bef7](https://github.com/rafhun/cbp/commit/276bef7))
* **grunt:** more files for BrowserSync ([731f472](https://github.com/rafhun/cbp/commit/731f472))



<a name="1.1.4"></a>
## 1.1.4 (2015-07-28)


### Bug Fixes

* **git:** ignore minimized svg ([8a76d2e](https://github.com/rafhun/cbp/commit/8a76d2e))
* **grunt:** watch task now references sassdown instead of hologram ([56cce43](https://github.com/rafhun/cbp/commit/56cce43))
* **scss:** fix reference to headings-font-family ([fc2c119](https://github.com/rafhun/cbp/commit/fc2c119))

### Features

* **grunt:** add installer folder to contrexx:clean ([1157d29](https://github.com/rafhun/cbp/commit/1157d29))



<a name="1.1.3"></a>
## 1.1.3 (2015-07-28)


### Bug Fixes

* **contrexx:** add correct timezone to config template ([e0346ae](https://github.com/rafhun/cbp/commit/e0346ae))



<a name="1.1.2"></a>
## 1.1.2 (2015-07-27)


### Bug Fixes

* **build:** fix jshint molecules path ([7c3b086](https://github.com/rafhun/cbp/commit/7c3b086))
* **build:** fix sassdown config ([be4c974](https://github.com/rafhun/cbp/commit/be4c974))
* **git:** add editorConfig to gitignore ([570c356](https://github.com/rafhun/cbp/commit/570c356))



<a name="1.1.1"></a>
## 1.1.1 (2015-07-27)


### Bug Fixes

* **build:** exclude normalize-scss from bower-concat ([e2f5456](https://github.com/rafhun/cbp/commit/e2f5456))



<a name="1.1.0"></a>
# 1.1.0 (2015-07-27)


### Features

* **cms:** add .htaccess template ([9bbe8d9](https://github.com/rafhun/cbp/commit/9bbe8d9))



<a name="1.0.5"></a>
## 1.0.5 (2015-07-27)


### Bug Fixes

* **build:** add changelog file ([3c0e3c5](https://github.com/rafhun/cbp/commit/3c0e3c5))



<a name="1.0.4"></a>
## 1.0.4 (2015-07-27)


### Bug Fixes

* **build:** also push tags after bump ([f3621d0](https://github.com/rafhun/cbp/commit/f3621d0))



<a name="1.0.3"></a>
## 1.0.3 (2015-07-27)


### Bug Fixes

* **build:** add changelog task options ([f4306f0](https://github.com/rafhun/cbp/commit/f4306f0))
* **build:** add closing } at the end ([39f0356](https://github.com/rafhun/cbp/commit/39f0356))
* **build:** correctly generate changelog ([203afa8](https://github.com/rafhun/cbp/commit/203afa8))
* **build:** fix shell:addChangelog ([01e6dc0](https://github.com/rafhun/cbp/commit/01e6dc0))
* **build:** remove auto push from bump task ([7d59bab](https://github.com/rafhun/cbp/commit/7d59bab))
* **styles:** add icons to editor styles ([36ceaad](https://github.com/rafhun/cbp/commit/36ceaad))

### Features

* **build:** add deploy tasks ([3103771](https://github.com/rafhun/cbp/commit/3103771))
* **build:** easier changelog and bump set up ([625b20b](https://github.com/rafhun/cbp/commit/625b20b))
* **build:** optimize grunt config ([b09766d](https://github.com/rafhun/cbp/commit/b09766d))
* **build:** optimize grunt config ([a807059](https://github.com/rafhun/cbp/commit/a807059))
* **cms:** add media archive customizations ([471c848](https://github.com/rafhun/cbp/commit/471c848))
* **cms:** remove thumb calls for news module ([d5598ef](https://github.com/rafhun/cbp/commit/d5598ef))
* **js:** add molecule specific script folder ([84f5e21](https://github.com/rafhun/cbp/commit/84f5e21))
* **scss:** prepare for use with styles-library ([5863ffa](https://github.com/rafhun/cbp/commit/5863ffa))
* **server:** add server config template ([ee458bd](https://github.com/rafhun/cbp/commit/ee458bd))
* **styleguide:** move to sassdown ([a592f21](https://github.com/rafhun/cbp/commit/a592f21))


### BREAKING CHANGES

* S: This introduces another rename that differs from previous
versions and thus might lead to some things breaking. However the rename
has been enforced throughout the Grunt configuration and therefore
is expected to be easily adapted.

* S: Since a lot of folders are renamed now and also the name of our
main sass file changes this introduces a breaking change for one in the grunt sass
task (different main file). Also it cannot be guaranteed that molecules/components
imported from older projects will still work in this environment (however everything
coming over from the styles-library will work).

* S: Sassdown requires a slightly different documentation
syntax for your Scss styles and therefore is not compatible with the
old hologram version. To move over old code remove the hologram frontmatter
and instead just set a markdown title like # Title. For further details
please refer to the official sassdown documentation.



<a name="0.5.0"></a>
# 0.5.0 (2015-06-16)


### Bug Fixes

* **build:** fix local task ([dc0c675](https://github.com/rafhun/cbp/commit/dc0c675))
* **deploy:** fix rsync staging task ([331ba93](https://github.com/rafhun/cbp/commit/331ba93))

### Features

* **build:** add deploy tasks ([d305a7f](https://github.com/rafhun/cbp/commit/d305a7f))
* **build:** add rsync push tasks ([498089d](https://github.com/rafhun/cbp/commit/498089d))



<a name="0.4.1"></a>
## 0.4.1 (2015-06-04)


### Bug Fixes

* **grunt:** fix the changelog task options ([61a0552](https://github.com/rafhun/cbp/commit/61a0552))



<a name="0.4.0"></a>
# 0.4.0 (2015-06-04)




<a name="0.3.1"></a>
## 0.3.1 (2015-06-04)




<a name="0.3.0"></a>
# 0.3.0 (2015-06-04)




