Note from Dave (2009-03-12):
----------------------------

I've put all scriptaculous submodules into scriptaculous.js and 
disabled the require() function. The rationale for this is that
the loading takes quite a lot of time that can be avoided.
Firefox for example loads and evaluates each script as soon as
scriptaculous require()s it, and only then continues with 
loading the next script.

