# Contrexx Development Framework
Version: 1.1.0

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
As a first step that otherwise might easily be forgotten open your `package.json` file and adjust the value for `devUrl` to your development URL (I recommend `projectname.dev`, but depends on your setup).

Once your repo is ready you can run

```
npm install
```

which pulls down all the dependencies needed to run the project. It might take a while as quite a few plugins are loaded for the grunt workflow. Make sure that no errors show up.

### Contrexx / CMS
Since Contrexx does not offer a fixed link to its latest version available you have to download it yourself. Go to [their website](https://www.cloudrexx.com/de/Software?category=8), pull down the latest version and copy the CMS files to the `wwwroot/` folder. Now call up your local server and go through the installation procedure.

### Secrets
When asked for database details enter them in the installer and also in the `secrets-template.json` file under the local object. Save that file as `secrets.json`. This step is important, if Grunt cannot find a `secrets.json` file it will not be able to run. Add all other data the `secrets-template.json` asks for as well (as far as is known). If you already know the setup for your staging and live server you may fill them in as well.

Important: This file (`secrets.json`) is ignored by git so your confidential data is not pushed to a server.

After you have finished the installation of Contrexx you can start with the actual development of your own theme. Run

```
grunt clean:contrexx
```

to wipe out all unnecessary files created by or brought the standard Contrexx installation. This ensures a clean codebase containing only files that are actually needed.

### Theme Development Dependencies
After successfully setting everything up you are now ready to start development. As the framework is based on Susy, offers jQuery support and the styleguide is created by Hologram with the Cortana theme we need to install some more dependencies. This can be done by running

```
grunt setup
```

With this step you are done with setup and can start developing your theme. Just run

```
grunt
```

and everything will be set up for you.

## Folder Structure
The basic folder structure is defined respectively mirrored within `package.json` file. All paths needed in grunt are defined therein to make it easy for you to adapt the structure to your needs. Folder paths within grunt configuration files are all given by referencing these variables so make sure you follow the given folder structure or change your `package.json`.
To change your themes name change `themeName` in `package.json`. This automatically names your theme folder and adjusts your grunt paths.

## Grunt Tasks
Here a quick overview is given over important grunt tasks and their usage. Not everything is described and most of these tasks have been assigned to other tasks and are being run automatically. They are more or less described in the order that you would need them or how they are used within the build tasks.

### Default Task
The default task will be the one you are going to use most of the time. In a first step it completely wipes out your whole theme folder and all other files that will be generated by grunt (this includes customizings, editor configuration, images, the configuration, …).

Then your whole theme is built freshly from the `src/` directory. In the default tasks the configuration is automatically built to reflect the local settings given in `secrets.json`. Then all your assets are run through the various tasks (take a look at the `grunt/aliases.yaml` file to find out more), a styleguide is generated and BrowserSync as well as a watch task are initialized. As soon as your browser opens a new tab showing your styleguide you are ready to develop. Whenever you change a file in the `src/` directory the necessary tasks will automatically run to update your site which livereloads whenever a change is detected.

### Local, Staging and Production Task
To just compile your assests but not run any watch tasks you can use

```
grunt local
grunt staging
grunt production
```

These tasks mainly differ in the choice of secrets that are replaced into the configuration. Also stricter Javascript hinting is used for code that will be going on a server.

@TODO: use staging and production tasks with rsync by default only skip that one if it is not available or create two more tasks which explicitly does not use rsync.

### Dependencies
Two tasks to handle dependencies are set up. The one you already used `grunt setup` which just pulls in everything you need and concatenates the JS and

```
grunt setupUpdate
```

which goes through your dependencies and pulls in updates where available.

To update gem and bower dependencies run `grunt setupUpdate`. Make sure you are in a safe testing environment (i. e. a new testing branch or similar) so you can easily revert should something break because of an update. Thoroughly test your installation after running this update task. Should everything work fine put it into production otherwise go back to the previously used versions.

### Replace
Takes all your configuration data from the `secrets.json` file in your root and builds a valid Contrexx `configuration.php` file. You have the possibility to define one local and two server environments (staging and production). The task is also part of the respective build tasks so you automatically get the correct configuration for the chosen environment.
* `grunt replace:local` fills in the credentials for your local environment.
* `grunt replace:staging` is used to create the staging server environment configuration.
* `grunt replace:production` creates the production server configuration.

### Clean
This task is responsible for wiping out the whole build folder before a new build starts. To keep the filesystem clean while in development several subtasks have been defined which are called by the watch task:
* Immediately after installing Contrexx you have the opportunity to run `grunt clean:contrexx` which will remove all content Contrexx puts into the `images/` folder, while keeping its folder structure intact since it is needed this way by Contrexx, as well as the standard skeleton theme which will not be needed. Still this allows you to upload a clean folder containing only files you put there yourself (in the best case only minified/compressed images).
* `grunt clean:html` deletes all `.html` files in the build folder. This task can be used to completely rebuild your jade templates. It is not integrated to another grunt task and as such can only be run on its own.
* `grunt clean:images` cleans only the `images` folder in the theme folder. Use it to clean up previously compressed images (i.e. if you get an error or wrong minification). As such this task is not part of any defined grunt tasks.
* `grunt clean:dest` wipes out the whole build folder. Use this if you want to completely rebuild all your resources.
* There are several more clean tasks defined which mostly are run as part of certain watch tasks. You can find all tasks in the `grunt/clean.js` file.

### Imagemin
Used to losslessly compress images to their minimum file size. Since there are two different image locations in the CMS there are two tasks:
* `grunt imagemin:contentImg` is used for images with no direct connection to your theme. It is run on the `src/images/content` folder which should only contain images that are part of the content.
* All images that are part of the theme should be put into the `src/images/theme` folder and are compressed by the `grunt imagemin:themeImg` task. Put all images referenced from your CSS in here.

### grunticon
Grunticon takes your SVG images and turns them into icon stylesheets. Find out more about it [on their website](http://grunticon.com/). The task offers several configuration options you should make use of. Make sure to check out the documentation. Most notably used are the `customselector` and `colors` options, which is also why these two have been built into the configuration file as eamples. You can find the file in `grunt/grunticon.js`.

Grunticon converts all files that are put into the `src/images/icons` folder into the stylesheets.

### Hashres
The hashres task is used for cache busting your assets. It automatically adds an 8 charachter long hash of the file contents to your styles and script file. This means that the hash only changes if the file contents actually changed, perfect for cache busting.

The task furthermore changes the links in the `index.html` to include the generated hash. To keep your build folder clean the hashed files are wiped out automatically before the task is run.

### BrowserSync
For BrowserSync to work correctly it is crucial that you adjust the `devUrl` key in your `package.json` file to reflect your develpoment url. As Contrexx is based on PHP and MySQL we have to use BrowserSync with the proxy option to lead it to the right server. Do not make it a habit to use BrowserSync on its own. It is part of the default task and watches for changes in any CSS, JS and HTML files within your theme folder.

BrowserSync is part of the default task so just run `grunt` and BrowserSync is automatically initialized before the watch task.

Should you want to run just the BrowserSync and Watch task run `grunt bsWatch`, which will initialize BrowserSync and then start the watch task. You can use this task i. e. if you know all resources are up to date already and you just want to adjust output of files you change. However the use of the default grunt task is recommended.

## Processing Flow
The processing flow for the most important file types is described below.
### Jade and HTML Files
The `index.jade` file imports the `favicons.html` file generated by the favicons task. This file includes all links to the generated favicons. To reduce filesize our goal is to minimize all html we can. Because jade does not minify imported html the htmlmin task is run over `favicons.html` before the jade task compiles its files. Therefore the imported html is already minified and thus we reach optimal whitespace reduction.

## Styleguide
Make sure to document your styles extensively inline as from these comments a styleguide is created automatically. Your default task is set up to open the styleguide index page from which you can navigate to the existing pages. Styleguide driven development is heavily encouraged.

As this boilerplate project will also become an archive of previously created components that are containing documentation use those as an example.

At the time of this writing hologram with the Cortana theme is being used as a styleguide generator. However we are looking for a good node styleguide generator that will probably replace the Hologram one (since it is Ruby) once we reach version 1.0.

## Contrexx Configuration
1. Set up your local (and remote) database through phpmyadmin. Set up a new MySQL database for your Contrexx installation and create a new user for the database. The recommended way of doing this is by creating a new user and check the "Create database with same name and assign all rights" box. Make sure to put down the credentials somewhere.
2. Clone the repo into your local/remote webserver. The recommended setup is to prepare a virtual host, which uses the repo name as its domain and the `wwwroot` folder in the repo as web root. A good tutorial on setting this up on OS X can be found [here](http://mallinson.ca/osx-web-development/). Following this example you would clone the repo into your `/www/sites/` folder.
3. Download the latest version of Contrexx from [here](https://www.cloudrexx.com/de/Software). Unzip the download and copy the contents of `CMS_FILES` to the `wwwroot` folder of this repo.
4. Open the chosen server in your browser and follow the Contrexx installation wizard. Provide your credentials when asked for them. This step sets up the correct configuration file and creates the database structure. Should you run into access rights problems in your **local** environment try running the following command on your root folder: `sudo chmod -R a+w /path/to/webroot` (be careful, only use this command on your local machine and if you can trust everyone with access to it!). Alternatively you could run `sudo chown -R _www /path/to/webroot` which assigns ownership to the `_www` apache user, however this can make working with the files cumbersome as you will have to authenticate as admin more often.
5. After successfully installing Contrexx open the `secrets-template.json` file and edit it with the credentials you have just created. In the basic installation you have the ability to provide credentials for three environments (local, staging and production). However it is possible to add further servers in valid JSON (just follow the example) if you adjust the replace task (`grunt/replace.js`) for those. Then save the file as `secrets.json`. Do not worry, this file is ignored by git by default so your credentials will not end up in your repo.
6. Make sure not to put the `configuration.php` or `secrets.json` file into any public repo as this could compromise your credentials.
7. By running the respective build tasks your configuration is automatically updated to reflect the chosen environment.
8. Use `grunt clean:contrexx` to get rid of all standard contrexx files you will not need for your theme.
9. Pull in dependencies by running `grunt:setup`.
10. Adjust the local URL in `package.json` to ensure BrowserSync runs correctly.
11. Commit your project after this step then you will be ready to start working on the theme.
12. Run `grunt` and start developing your theme.
13. To see your theme on Contrexx make sure to log into the backend (`devUrl/admin`) add the new theme folder and set up Contrexx to use the new theme. After running `grunt clean:contrexx` the standard theme will break as the necessary files cannot be found so the frontend cannot be viewed before changing the settings in the backend.

## Continuing Work on an Installed Repo
If you have just cloned a repo that contains a Contrexx that has already be installed, make sure that you find a `db/backup-TIMESTAMP.sql` file in it. Set up your database with your own `secrets.json` file or use the same one as the person who previously installed Contrexx (it does not really matter). After you have prepared the database take the latest MySQL dump from the `db/` folder and import it either through the console or with phpmyadmin. Once this is done you have a Contrexx installation that is ready to roll and contains all pages, options, ... that have already been setup.

Maybe in the future a standard dump will be prepared containing the most usually used contents, so everybody can be working on the same base install.

As it stands now only one person at a time should be entering content into the CMS. When that person is finished he should dump the database and commit the new dump. Before starting to work on content one should always pull in the latest database dump and import it to one's developer database so contents are always up to date. Be very careful not to lose any content!

This system could also be optimized by using a central db on a server for development to which everybody has access.

# Default Contrexx Customizations
The boilerplate comes with a few ready-made customizations to the standard Contrexx code. These can simply be removed or edited by working on the respective files in the `src/customizing` folder. The included customizations are explained below. Customizings within files are usually marked by `// customizing` so they can easily be found for further insight or edits.

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
