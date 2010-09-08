e107 0.7.23 Update
==================
To install, expand the downloaded file and copy the complete file structure over your existing e107 site (taking care to ensure your FTP client is set to always overwrite existing files).

Run File Inspector to verify the integrity of the copy.

A key feature of this release is a stringent new data filter to greatly reduce the possibility of posting malicious code which carries out XSS attacks. (Typically this can be done by posting links which appear at first glance to be references to off-site media.) This filter can be disabled for a specific user class.

There is no database update for this release.


New BBCode
----------
There is a new bbcode, [youtube] which allows users to integrate youtube movies in a safe manner (as safe as we can make it, anyway).
Its usage is as follows:
[youtube=tiny|small|medium|big|huge or width,height|norel&border&privacy&nofull]ID[/youtube]

where ID is the (currently 11-character) reference of the movie.

You can also paste the complete 'embed' link from youtube instead of the ID, in which case the parameters will be extracted to create the correct bbcode.
If you specify parameters in the actual bbcode, they will override any pasted from the link.

Examples:
[youtube small|norel&border&privacy]MnA8mfBn00s[/youtube]
[youtube 480,385]MnA8mfBn00s[/youtube]
[youtube 480,385|border]MnA8mfBn00s[/youtube]
[youtube norel]MnA8mfBn00s[/youtube]



If your web site currently allows a class of users to post HTML code (e.g. to reference Youtube movies), there are some additional steps you need to carry out:


A) BACK UP YOUR DATABASE!!!!

B) If users post links to youtube movies:

	1. Log into your site as admin.

	2. Browse to yoursite/e107_files/resetcore/fixyoutube.php

This will convert all references to youtube movies to the new bbcode, in the following areas:
	- news
	- submitted news
	- forum
	- content

*********** Note that this conversion may not be 100% successful, but should convert the bulk of the references *************

(It is reasonably straightforward to add additional areas if appropriate - examine the code towards the end of the file).


C) There is a new preference under 'Text Rendering' - 'Class of users who can post '<script>' and similar tags. This defaults to 'nobody'. If necessary, change as appropriate.