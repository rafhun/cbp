
-------------------------------------------------------------------------
Google API Access for PHP
- A PHP class library to access the Google API via SOAP using WSDL.
-------------------------------------------------------------------------


OVERVIEW:
---------

This README file describes the Google API Access for PHP class 
library. 

This class library is designed to make accessing the Google API using 
PHP via SOAP, a lot easier. This is a Java-style class library, which 
uses getter and setter functions to set parameters for search queries, 
and to access individual result components. 


HOW TO USE:
-----------

Step 1: Register with Google to receive an authentication key. You can 
register online at http://www.google.com/apis/.

Step 2: Get the NuSOAP library (http://dietrich.ganx4.com/nusoap), and 
place the file nusoap.php somewhere on the include path, or change the 
'require_once' directive in this file to point to the correct location 
of the nusoap.php file on your computer. 

Step 3: That's it! you can start writing your own code, using this 
library, to access the Google API. Please go through the example code 
to get started. 


PACKAGE CONTENTS:
-----------------

1. GoogleSearch.php 
	- PHP class library to access the Google API.

2. README.txt 
	- This file. 

3. example1.php
	- Example to use this library for Google spelling suggestion. 

4. example2.php
	- Example to use this library to access Google cached pages. 

5. example3.php
	- Example to use this library to perform a Google search.  



COMPATIBILITY NOTE: 
-------------------

At the moment, this library is experimental and designed to work only 
with PHP4 and above. 


CONTACTING THE AUTHOR:
----------------------

Please send your suggestions, bug reports and general feedback to my 
email, immanuel_vijay@vsnl.net. You can also contact me through my 
website, http://vijay.staghosting.com. 

I'd be glad to hear your feedback. Please feel free to send a word, if 
you find this program interesting or useful. I'd really love to know 
how people implement this library. 


LICENSE:
----------

This source file is released under LGPL license, available through the 
world wide web at, http://www.gnu.org/copyleft/lesser.html. This 
library is distributed WITHOUT ANY WARRANTY. Please see the LGPL for 
more details.

This library requires the "NuSOAP - Web Services Toolkit for PHP", 
available for free at, http://dietrich.ganx4.com/nusoap under the LGPL 
license.



-------------------------------------------------------------------------
Author: Vijay Immanuel <immanuel_vijay@vsnl.net>
	  http://vijay.staghosting.com
-------------------------------------------------------------------------
