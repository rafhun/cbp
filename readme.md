# Contrexx Development Framework
This framework uses advanced methodologies to ensure efficient and clean development of Contrexx websites and especially their themes.

## Initialize a New Project
To initialize a new project you need to fork this repo and then clone it to your work station. Change the root folder name according to your current project then `cd` into it and run `npm install`. This will install all node modules the framework needs.
After this you will be able to run `grunt setup`. This command will install all gems and bower dependencies needed for your project and concatenate all js files pulled in through bower to the `bower.js` file in the source javascript folder. With this you are ready to start development.

## Folder Structure
The basic folder structure is defined respectively mirrored within `package.json` file. All paths needed in grunt are defined therein to make it easy for you to adapt the structure to your needs. Folder paths within grunt configuration files are all given by referencing these variables so make sure you follow the given folder structure or change your `package.json`.
To change your themes name change `themeName` in `package.json`. This automatically names your theme folder and adjusts your grunt paths.

## Grunt Tasks
Here a quick overview is given over important grunt tasks and their usage. Not everything is described and most of these tasks have been assigned to other tasks and are being run automatically. They are more or less described in the order that you would need them or how they are used within the build tasks.

### Default and Shipping Task
There are two basic tasks set up which allow you to build a development version or a production version. The default task is set up as development build while `grunt ship` creates the production build. The main differences between the two tasks are:
* The copied `configuration.php` file (development variables vs. production variables)
* The JSHint rules: for production the `devel` option is set to `false` to prevent commands typically used for development (such as `alert()`) from being shipped to the server. During development however these tasks can be of great use when debugging your scripts and are therefore allowed.

### Update Dependencies
To update gem and bower dependencies run `grunt setup`.

### Replace
Takes all your configuration data from the `secrets.json` file in your root and builds a valid Contrexx `configuration.php` file. You have the possibility to define a local and a server environment. The task is also part of the respective build tasks so you automatically get the correct configuration for the chosen environment.
* `grunt replace:local` fills in the credentials for your local environment.
* `grunt replace:server` is used to create the server environment configuration.

### Clean
This task is responsible for wiping out the whole build folder before a new build starts. To keep the filesystem clean while in development several subtasks have been defined which are called by the watch task:
* `grunt hashes` is used to delete the previously hashed script and stylesheet files. Since hashres always hashes both files they can both be deleted.
* `grunt html` deletes all `.html` files in the build folder. This task can be used to completely rebuild your jade templates. It is not integrated to another grunt task and as such can only be run on its own.
* `grunt images` cleans only the `images` folder in the theme folder. Use it to clean up previously compressed images (i.e. if you get an error or wrong minification). As such this task is not part of any defined grunt tasks.
* `grunt dest` wipes out the whole build folder. Use this if you want to completely rebuild all your resources.
* `grunt unhashed` cleans up your unhashed styles and javascript in the build folder. Use this before deploying to the server if you do not wish for your unhashed files to be available there.

### Imagemin
Used to compress images to their minimum file size. Since there are two different image locations in the CMS there are two tasks:
* `grunt imagemin:contentImg`
* `grunt imagemin:themeImg`

### Hashres
The hashres task is used for cache busting your assets. It automatically adds an 8 charachter long hash from the file contents to your styles and script file. This means that the hash only changes if the file contents actually changed, perfect for cache busting.
The task furthermore changes the links in the `index.html` to include the generated hash. To keep your build folder clean the hashed files are wiped out automatically before the task is run however the unhashed files will not be replaced.
Before deployment or when running the `grunt ship` task, the source files are wiped after the hashes are created to keep the files on your server clean.

## Important File Names
A list to give you a quick overview over the filenames being used:
* Styles: style.css -> style-prefixed.css -> style.min.css
* Scripts: script.js -> script.min.js

## Processing Flow
The processing flow for the most important file types is described below.
### Jade and HTML Files
@TODO: check whether jade handles html comments correctly as they are needed to build for example the navigation list. Otherwise these files would have to be written in plain html with a seperate minification task that does not remove comments.

The `index.jade` file imports the `favicons.html` file generated by the favicons task. This file includes all links to the generated favicons. To reduce filesize our goal is to minimize all html we can. Because jade does not minify imported html the htmlmin task is run over `favicons.html` before the jade task compiles its files. Therefore the imported html is already minified and thus we reach optimal whitespace reduction. Make sure to set up the tasks correctly meaning htmlmin should always run before jade.

## Contrexx Configuration
1. Set up your local (and remote) database through phpmyadmin. Set up a new MySQL database for your Contrexx installation and create a new user for the database. The recommended way of doing this is by creating a new user and check the "Create database with same name and assign all rights" box. Make sure to put down the credentials somewhere.
2. Clone the repo into your local/remote webserver. The recommended setup is to prepare a virtual host, which uses the repo name as its domain and the `wwwroot` folder in the repo as web root. A good tutorial on setting this up on OS X can be found [here](http://mallinson.ca/osx-web-development/). Following this example you would clone the repo into your `/www/sites/` folder.
3. Open the chosen server in your browser and follow the Contrexx installation wizard. Provide your credentials when asked for them. This step sets up the correct configuration file and creates the database structure. Should you run into access rights problems in your **local** environment try running the following command on your root folder: `sudo chmod -R a+w /path/to/webroot` (be careful, only use this command on your local machine and if you can trust everyone with access to it!). Alternatively you could run `sudo chown -R _www /path/to/webroot` which assigns ownership to the `_www` apache user, however this can make working with the files cumbersome as you will have to authenticate as admin more often.
4. After successfully installing Contrexx create a `secrets.json` file in the root directory and open it. Enter all credentials you just created and installed. In the basic installation you have the ability to provide credentials for two servers (one for development, one for production). However it is possible to add further servers in valid JSON (just follow the example) if you adjust the replace task (`grunt/replace.js`) for those.
5. Make sure not to put the `configuration.php` or `secrets.json` file into any public repo as this could compromise your credentials.
6. Run `grunt replace:local` which copies your local credentials into the configuration file and `grunt replace:server` to change them to the ones for the server. These tasks are also part of the basic build tasks to create a complete local resp. server build. Also run this task after you changed something in your `secrets.json` file to update the configuration with the latest credentials.
