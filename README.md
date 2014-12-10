noCaptcha
=========

MODx FormIt hook for the new noCaptcha reCaptcha from Google<br/>
For the reCaptcha service see: https://www.google.com/recaptcha/intro/index.html<br/>
For more information about MODx see: http://modx.com<br/>
For more information about FormIt see: http://rtfm.modx.com/extras/revo/formit<br/>

Example usage:<br/>
[[!FormIt? &hooks=`noCaptcha` &preHooks=`preNoCaptcha` &ncTheme=`light|dark` &ncName=`other name for placeholder` &ncType=`image|audio` ]]

See simple_example.html for an simple example. :)

To Install
- create the categorie noCaptcha for the following snippets and chunk
- create the snippet named noCaptcha with the contents of noCaptcha.php
- create the snippet named preNoCaptcha with the contents of preNoCaptcha.php
- create the chunk nocaptcha_tpl with the contents of nocaptcha_tpl.html
- Take a look at simple_example.html for usage

Roadmap
- support multiple instances on one page
