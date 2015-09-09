# Contrexx Development Framework
Version: 1.1.7

This framework uses advanced methodologies to ensure efficient and clean development of Contrexx websites and especially their themes. It relies on modern technologies such as Grunt to run tasks, libsass to compile scss, susy for grid computation and several more great tools.

## TL;DR
1. Initialize
  * Set up repo
  * `npm install`
  * Get Contrexx and install it
  * Add information to `secrets.json`
  * `grunt setup`
  * `grunt`
2. Image Folders
  * Where to put which images and where they are put in the web root.
    * Content images: `src/images/content` -> `/images/content/`
    * Theme images: `src/images/theme` -> `/themes/{themeName}/images/`
    * SVG icons: `src/images/icons` -> `/themes/{themeName}/icons/`
  * Folder structure given within content images and theme images folders will be kept on the server, so bring some structure to your images.

## Prerequisites

### Framework

Make sure that you have `node` and `ruby` installed on your system. Also if this is your first time using Grunt make sure its command line interface is installed globally by running

```
npm install -g grunt-cli
```

For Mac OS X users the use of Homebrew is recommended to set up your Node and Ruby environments cleanly.

### CMS / Server
Contrexx runs on PHP with a MySQL database storing its data. Make sure to have a webserver ready that can serve up these files. However for development this is not necessarily needed. The generated styleguide is a simple HTML webpage you should be able to view directly.

The pre-built customizings are optimized for use with Contrexx version 4.0. Coming with version 5.0 some breaking changes are to be excpected.

## Initialize a New Private Project

### Set Up the Repo

If you have access to Github Pro just fork the project to your account, then clone it to your machine.

Here is the way to set it up with Bitbucket. Clone this repo to your local machine:

```
git clone https://github.com/rafhun/cbp.git {project-name}
```

By default this adds the github remote as `origin`. We want to change this as we only keep the reference to the boilerplate. This can be done by running the following command from inside the repo you created with the clone (so do not forget to `cd` into it after cloning):

```
git remote rename origin boilerplate
```

Then create a new repo on [Bitbucket](http://bitbucket.org/). Once done you can follow the instructions given on Bitbucket itself. Choose that you already have data and copy the commands given there. After this you should be set up to push and pull from the new origin remote that points to the Bitbucket repo.

## Initialize a New Project

### Grunt Environment
As a first step that otherwise might easily be forgotten open your `Gruntconfig.yml` file and adjust the value for `devUrl` to your development URL (I recommend `projectname.dev`, but depends on your setup).

Once your repo is ready you can run

```
npm install
```

which pulls down all the dependencies needed to run the project. It might take a while as quite a few plugins are loaded for the grunt workflow. Make sure that no errors show up.

### Contrexx / CMS
Cloudrexx now offers a few direct links to the latest version released of its software. They offer their download packages with a few different preset options and themes. Click the link below to get the version you prefer. We recommend the use of the minimal setup since we will be writing a new theme anyway:

* [Latest Version Full](https://www.cloudrexx.com/latest_release_full)
* [Latest Version Minimal](https://www.cloudrexx.com/latest_release_minimal)

After you pull down the latest version and copy the CMS files to the `wwwroot/` folder you are able call up your local server and go through the installation procedure.

@TODO: create a shell task that automatically pulls down Cloudrexx, extracts it and puts it into the server root folder.

### Secrets
When asked for database details enter them in the installer and also in the `secrets-template.json` file in the local object. Save that file as `secrets.json`. This step is important, if Grunt cannot find a `secrets.json` file it will not be able to run. Add all other data the `secrets-template.json` asks for as well (as far as is known). There is no need to fill in FTP details for your local environment as Contrexx can write to your filesystem directly if your local webserver is properly configured. If you already know the setup for your staging and live server you may fill them in as well.

Important: This file (`secrets.json`) is ignored by git so your confidential data is not pushed to a server.

After you have finished the installation of Contrexx you can start with the actual development of your own theme. Run

```
grunt clean:contrexx
```

to wipe out all unnecessary files created by the standard Contrexx installation. This ensures a clean codebase containing only files that are actually needed.

### Theme Development Dependencies
After successfully setting everything up you are now ready to start development. As the framework is based on Susy and offers jQuery support we need to install some more dependencies. This can be done by running

```
grunt setup
```

To find out which dependencies are being pulled in check out the `bower.json` file. With the move to Sassdown and Libsass this project is now completely independent of Ruby. You are now ready to start developing your theme. Just run

```
grunt
```

and everything will be set up for you. Should you wish to customize your theme's name or the basic folder setup you can edit the `Gruntconfig.yml` (see also the paragraph Folder Structure below).

## Folder Structure
The basic folder structure is defined respectively mirrored within `Gruntconfig.yml` file. All paths needed in grunt are defined therein to make it easy for you to adapt the structure to your needs. Folder paths within grunt configuration files are all given by referencing these variables so make sure you follow the given folder structure or change your `Gruntconfig.yml`.

To change your themes name change `themeName` in `Gruntconfig.yml`. This automatically names your theme folder and adjusts your grunt paths. However make sure to define your final theme name before starting development as otherwise some absolute file paths in i. e. your CSS or HTML files might break, should they include the theme's name.

## Grunt Plugins and Tasks
Here a quick overview is given over important grunt tasks and their usage. Not everything is described and most of these tasks have been assigned to other tasks and are being run automatically. They are more or less described in the order that you would need them or how they are used within the build tasks.

### setup & setupUpdate
These two tasks are responsible for pulling in your dependencies and when necessary concatenate their javascript files. First the task runs `bower install` (resp. `bower update` for the setupUpdate task) followed by `bower_concat`. This second task goes through all Bower files that have just been downloaded, extracts their scripts and puts them together into one file (`src/js/bower.js`). Since we also include some Scss only files we have to exclude them from inclusion manually in the configuration of this task (which is in `grunt/bower_concat.js`).

### jshint
Your javascript code will be linted using the jshint library. There are different configurations for the linter depending on the environment. A less restricitve ruleset is being applied for the local task while some more restricitve rules are used to check code that goes to the staging or production environment (the most significant difference is that development functions like `alert` are allowed locally but not on the servers).

### Clean
This task is responsible for wiping out the whole build folder before a new build starts. To keep the filesystem clean while in development several subtasks have been defined:

* Immediately after installing Contrexx you have the opportunity to run `grunt clean:contrexx` which will remove all content Contrexx puts into the `images/` folder, while keeping its folder structure intact since it is needed this way by Contrexx, as well as the standard skeleton theme which will not be needed. This allows you to upload a clean folder containing only files you put there yourself (in the best case only minified/compressed images).
* There are several more clean tasks defined which mostly are run by Grunt automatically when needed. You can find all tasks in the `grunt/clean.js` file. This tasks assure that new files are created whenever Grunt is run (especially the hashres task sometimes does not update references or files if no new files are created).

### Copy
As is implied by the name the copy task creates 1:1 copies of files in the source folder to the production folder. This is used for things such as customizings, font files or similar files that do not need any processing before being moved to the build folder.

### Replace
Takes all your configuration data from the `secrets.json` file in your root and builds a valid Contrexx `configuration.php` file. You have the possibility to define one local and two server environments (staging and production). The task is also part of the respective build tasks so you automatically get the correct configuration for the chosen environment.

Should the configuration file structure ever change you can find the template for it in the `src/config/configuration.php` file.

* `grunt replace:local` fills in the credentials for your local environment.
* `grunt replace:staging` is used to create the staging server environment configuration.
* `grunt replace:production` creates the production server configuration.

### Concat & Uglify
These two tasks pull together all of your javascript source files into one file that then gets minified. The concat task uses the following sort order when including files:

1. `src/js/bower.js`: all javascript coming from bower files (compiled by the bower_concat task).
2. `src/js/plugins.js`: vendor code for external plugins you include into your website. This file is also excluded from the linter so you can put minimized code in here as well. Make sure to document your code so you remember which part is which plugin and what versions were used. Try to make use of Bower where possible.
3. `src/js/molecules/**/*.js`: This imports molecule specific scripts (i. e. the accordion clicking logic for the accordion molecule).
4. `src/js/script.js`: This is your main script file where you add all scripts that are not part of a specific molecule and are therefore probably applied to most pages of your website.

### Sass, Autoprefixer & Cssmin
All of your Scss is compiled, prefixed and minified by this task. The resulting files are saved to their appropriate locations automatically by each task. Since we need both the unminified and minified stylesheets in the build folder we already move there after the autoprefixing is done.

### Imagemin
Used to losslessly compress images to their minimum file size. Since there are two different image locations in the CMS there are two tasks:

* `grunt imagemin:contentImg` is used for images with no direct connection to your theme that belong to the content. It is run on the `src/images/content` folder which should only contain images that are part of the content.
* All images that are part of the theme should be put into the `src/images/theme` folder and are compressed by the `grunt imagemin:themeImg` task. Put all images referenced from your CSS in here.

### svgmin
SVG's exported from vector graphics applications often contain redundant code that should be removed to save on file size. This task automates the svg optimization and is always run straight before icons are processed through grunticon (see below).

### grunticon
Grunticon takes your SVG images and turns them into icon stylesheets. Find out more about it [on their website](http://grunticon.com/). The task offers several configuration options you should make use of. Make sure to check out the documentation. Most notably used are the `customselector` and `colors` options, which is also why these two have been built into the configuration file as examples. You can find the file in `grunt/grunticon.js`.

Grunticon converts all files that are put into the `src/images/icons` folder into the stylesheets.

### Favicons
Almost every browser and operating system, especially on mobile devices demand another format of the favicon. This task takes one source image and turns it into all the favicon images you need. It also creates the html that can be used to import and display them properly. This generated HTML file is then imported into the index template through jade (see below).

### Jade
Instead of writing pure HTML templates we can do them with jade. This allows us to put minified HTML on our page (at least anything that does not come straight from the CMS itself). Also we can easily include the earlier generated favicon HTML. Everything you put into your `src/jade` folder will be copied to your theme root folder.

### Hashres
The hashres task is used for cache busting your assets. It automatically adds an 8 charachter long hash of the file contents to your styles and script file. This means that the hash only changes if the file contents actually changed, perfect for cache busting.

The task furthermore changes the links in the `index.html` to include the generated hash. To keep your build folder clean the hashed files are wiped out automatically before the task is run.

### Sassdown
An automatic styleguide based on comments in your source Scss files can be generated by this task. Its resulting HTML is usually put into the `styleguide/` folder of your server root and thus can be called up by going to `your-domain.com/styleguide`. Should you want to change this link, make sure to adjust the `.htaccess file` to reflect the same name as otherwise Contrexx redirects you when trying to access the site through the link.

The task prints a warning for any source file that does not contain a valid comment for Sassdown. However it does run smoothly and just will not produce any output for those files so they also do not show up in the navigation. Therefore we can decide excactly what parts should be in our styleguide.

### BrowserSync
For BrowserSync to work correctly it is crucial that you adjust the `devUrl` key in your `Gruntfile.yml` file to reflect your develpoment url. As Contrexx is based on PHP and MySQL we have to use BrowserSync with the proxy option to lead it to the right server. Do not make it a habit to use BrowserSync on its own. It is part of the default task and watches for changes in any CSS, JS and HTML files within your theme folder.

BrowserSync is part of the default task so just run `grunt` and BrowserSync is automatically initialized before the watch task.

Should you want to run just the BrowserSync and Watch task run `grunt bsWatch`, which will initialize BrowserSync and then start the watch task. You can use this task i. e. if you know all resources are up to date already and you just want to adjust output of files you change. However the use of the default grunt task is recommended.

### Watch
This task is set up to watch for file changes and then run appropriate tasks to rebuild the theme with the new information. Check the configuration file (in `grunt/watch.js`) for further details as to which tasks are run upon which file changes.

### Default Task
The default task will be the one you are going to use most of the time. In a first step your javascript files are linted to make sure you have valid code. Then it completely wipes out your whole theme folder and all other files that will be generated by grunt (this includes customizings, editor configuration, images, the configuration, …).

Now your whole theme is built anew from the `src/` directory. In the default tasks the configuration is automatically built to reflect the local settings given in `secrets.json`. Then all your assets are run through the various tasks (take a look at the `grunt/aliases.yaml` file to find out more), a styleguide is generated and BrowserSync as well as the watch task are initialized. As soon as your browser opens a new tab showing your styleguide you are ready to develop. Whenever you change a file in the `src/` directory the necessary tasks will automatically run to update your site which livereloads whenever a change is detected.

### Local, Staging and Production Task
To just compile your assests but not run any watch tasks you can use

```
grunt local
grunt staging
grunt production
```

These tasks mainly differ in the choice of secrets that are replaced into the configuration. Also stricter Javascript hinting is used for code that will be going on a server.

### Deploy Tasks
If you have SSH access to your server you have the opportunity to use rsync to push your assets to the server. Again there are two tasks set up for the staging and production environment which compile your assets for the respective servers before pushing them using rsync. The following tasks are ready for usage:

```
grunt pushStaging
grunt pushProduction
```

Rsync is setup to use the checksum as a compare mode which ensures that only files that truly do differ from the ones on the server are pushed. This makes the upload process quick and comfortable.

For production use or after the website has been given over to the customer you might want to change the rsync settings to not automatically delete files from the server that do not exist locally since it is possible that the customer has uploaded new files. Also you might wanna change the rsync options to only do a dry run. This has the main benefit of showing you excactly which files are to be deleted from the server and thus might have been uploaded by the customer.

### Editor Styles
For some styles applied to the frontend the need for different styling within the editor might arise. This is especially important for molecules like accordions or similar UI components that might hide content in under certain conditions. For this the Scss styles have been prepared with a `$EDITOR-STYLES` variable which can be used to indicate differing editor styles. Check the `src/scss/styles.scss` file for further instructions about the usage of the variable. Once you set it to true you can create the editor stylesheet by running

```
grunt editorStyles
```

This creates and copies the styles to the root folder. They are also saved in the `src/css` folder and thus preserved whenever the theme is rebuilt. It is therefore not necessary to recompile the editor stylesheet everytime the theme is renewed. Just do not forget to recompile it manually after adding new editor styles.

### Versioning
A few task for automatically document your versions and changes coming with them are available to you. With these versions a changelog is generated based on your commit history as well. However for this changelog to be generated correctly it is of importance for you to follow the [angular.js commit conventions](https://github.com/ajoslin/conventional-changelog/blob/master/conventions/angular.md).

When you want to bump your version try to consider the [semantic versioning principles](http://semver.org). The following tasks can be run to create the respective version bump:

```
grunt patchBump
grunt minorBump
grunt majorBump
```

## Processing Flow
The processing flow for the most important file types is described below.

### Jade and HTML Files
The `index.jade` file imports the `favicons.html` file generated by the favicons task. This file includes all links to the generated favicons. To reduce filesize our goal is to minimize all html we can. Because jade does not minify imported html the htmlmin task is run over `favicons.html` before the jade task compiles its files. Therefore the imported html is already minified and thus we reach optimal whitespace reduction.

## Styleguide
Make sure to document your styles extensively inline as from these comments a styleguide is created automatically. Your default task is set up to open the styleguide index page from which you can navigate to the existing pages. Styleguide driven development is heavily encouraged.

UI components that you import or copy from the [styles-library](https://github.com/rafhun/styles-library) already contain the correct documentation style for Sassdown processing. Follow its example or find further instructions [on the Sassdown github page](https://github.com/nopr/sassdown#markdown).

## Contrexx Configuration
1. Configure your local (and remote) database through phpmyadmin. Set up a new MySQL database for your Contrexx installation and create a new user for the database. The recommended way of doing this is by creating a new user and check the "Create database with same name and assign all rights" box. Make sure to put down the credentials somewhere or even better immediately put them into your `secrets.json` file.
2. Clone the repo into your local/remote webserver. The recommended setup is to prepare a virtual host, which uses the repo name as its domain and the `wwwroot` folder in the repo as web root. If you are on Mac OS X you can set up your system exactly like mine by following [this blogpost](http://codepen.io/rafhun/blog/setting-up-a-devenv-on-a-mac). Following this example you would clone the repo into your `/www/sites/` folder.
3. Get the latest version of Contrexx and put it into your server root.
4. Open the chosen server in your browser and follow the Contrexx installation wizard. Provide your credentials when asked for them. This step sets up the correct configuration file and creates the database structure. By following the setup of the blogpost referenced above you will not run into any permission issues. Should you use your own system make sure the user the server runs as has the correct rights assigned to it.
5. After successfully installing Contrexx open the `secrets-template.json` file and edit it with the credentials you have just created. In the basic installation you have the ability to provide credentials for three environments (local, staging and production). However it is possible to add further servers in valid JSON (just follow the example) if you adjust the replace task (`grunt/replace.js`) for those. Then save the file as `secrets.json`. Do not worry, this file is ignored by git by default so your credentials will not end up in your repo.
6. Make sure not to put the `configuration.php` or `secrets.json` file into any public repo as this could compromise your credentials.
7. By running the respective build tasks your configuration is automatically updated to reflect the chosen environment.
8. Use `grunt clean:contrexx` to get rid of all standard contrexx files you will not need for your theme.
9. Pull in dependencies by running `grunt:setup`.
10. Adjust the local URL in `Gruntconfig.yml` to ensure BrowserSync runs correctly.
11. If you want to keep your reference to the boilerplate repository the recommended step is to now rename the existing remote to boilerplate by running: `git remote rename origin boilerplate`. Should you want to start afresh just delete the `.git` folder and change the version references in `package.json`, `bower.json` and `readme.md` to `0.1.0`. Then initialize a new git repository by running `git init`, add everything and make the initial commit. Now you can add your private bitbucket repository as origin remote and push your Contrexx installation.
12. Run `grunt` and start developing your theme.
13. To see your theme on Contrexx make sure to log into the backend (`devUrl/admin`) add the new theme folder and set up Contrexx to use the new theme. After running `grunt clean:contrexx` the standard theme will break as the necessary files cannot be found so the frontend cannot be viewed before changing the settings in the backend.

## Continuing Work on an Installed Repo
If you have just cloned a repo that contains a Contrexx that has already be installed, make sure that you find a `db/backup-TIMESTAMP.sql` file in it. Set up your database with your own `secrets.json` file or use the same one as the person who previously installed Contrexx (it does not really matter). After you have prepared the database take the latest MySQL dump from the `db/` folder and import it either through the console or with phpmyadmin. Once this is done you have a Contrexx installation that is ready to roll and contains all pages, options, ... that have already been setup.

Maybe in the future a standard dump will be prepared containing the most usually used contents, so everybody can be working on the same base install.

As it stands now only one person at a time should be entering content into the CMS. When that person is finished he should dump the database and commit the new dump. Before starting to work on content one should always pull in the latest database dump and import it to one's developer database so contents are always up to date. Be very careful not to lose any content!

This system could also be optimized by using a central db on a server for development to which everybody has access.

**A Word of Caution:** Never put a database dump into a public repository as it contains your encrypted access data. If there is a db dump in a public repository make sure to not use the same passwords and access credentials for your production environment. Even though the data is encrypted an attacker could potentially read out your credentials and abuse them.

# Default Contrexx Customizations
The boilerplate comes with a few ready-made customizations to the standard Contrexx code. These can simply be removed or edited by working on the respective files in the `src/customizing` folder. The included customizations are explained below. Customizings within files are usually marked by a `// customizing` comment so they can easily be found for further insight or edits.

## Core Modules

### Frontend Editing
Frontend Editing is deactivated for page titles by default. Because of the editor configuration of setting `<p>` elements by default these are automatically put around page titles when Frontend Editing is activated. This usually does not interfere with styles but makes no sense semantically.

@TODO: Maybe find a way to include the title in Frontend Editing through a usual text input field instead of the editor instance. This would prevent the `<p>` tags and reflect the situation in the backend.

### Media (Media Archive)
The standard media archive is vastly improved through this customizing. Especially to grant an improved user experience the following changes are applied:

* `_` in file or folder names are automatically replaced by spaces. Since Contrexx and its internal file uploader have trouble with spaces in file or folder names this makes it possible for users to get the full and readable name while granting a working upload experience for the administrators.

* The use of a sorting prefix in the form of `01-` is made available. When giving out file and folder names Contrexx now automatically recognizes this pattern and hides it from the user. This makes manual sorting easy while keeping the prefixes out of sight of the user. Should no sorting be needed in certain folders it can just be left out, so one is not forced to use the prefix throughout the installation and the customizing can be applied no matter which file naming system is used.

* An improved sorting algorithm is being applied so we get `1, 2, 3, ..., 10, 11, ...` instead of `1, 10, 11, 2, 3, ...` which makes much more sense. This is done by adding the `SORT_NATURAL` flag to the `array_multisort()` function that is used for sorting.

All text changes (points 1 and 2 above) are applied to the `MEDIA_TREE_NAV_DIR` (name given out in the media navigation bar) and the `MEDIA_FILE_NAME` (name given to the folder or file in the actual file list) placeholders. This ensures that the correct paths are given while the readable name is output.

### News
The news module is changed to completely ignore automatically generated thumbnails. Since we usually optimize news images as thumbs from the start we do not need this uncontrolled resized image. Since auto thumbs might still be needed in other modules or the core we just change the behavior within the news module. To achieve this the `parseImageThumbnail` function has been adapted to ignore all calls to the thumb source. Also one more manual change had to be made for the teasers class, since for some reason there the above mentioned function is not called.

## Lib

### ckeditor
Two crucial improvments to the backend editor are configured here. For efficient and easy content editing especially for the end user styles as well as templates are configured here. Since these parts are heavily dependent on the actual template and options given therein only basic outlines are given in the boilerplate.

#### Styles
To enable the user to easily add things such as a link icon or make an link open in an lightbox styles can be configured. For these to work the menu has to be enabled in the editor configuration (which is saved under `config/ckeditor.config.js.php` and has the styles enabled by default). Follow the given, commented out examples to add your own custom styles. Make sure to document them for the end user in the styleguide.

#### Templates
Some UI parts can require complex markup which can be saved in these templates. This makes it easy for the end user to add things like complete image galleries or accordions. To add your own templates based on your UI components also follow the given commented out examples. As with styles do not forget to add documentation for your user in the styleguide.
