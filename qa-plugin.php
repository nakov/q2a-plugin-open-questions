<?php

/*
	Plugin Name: Open Questions
	Plugin URI: http://www.nakov.com/blog/2012/04/30/open-questions-plugin-for-q2a-questions2answer-display-unanswered-non-closed-questions/
	Plugin Description: Displays in a page all "open" questions (without answer and not closed)
	Plugin Version: 1.0
	Plugin Date: 2012-29-04
	Plugin Author: Svetlin Nakov
	Plugin Author URI: http://www.nakov.com
	Plugin License: GPLv2
	Plugin Minimum Question2Answer Version: 1.5
	
	
	File: qa-plugin/open-questions/qa-plugin.php
	Version: 1.0
	Description: Initializes the "Open Questions" plugin


	This program is free software; you can redistribute it and/or
	modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation; either version 2
	of the License, or (at your option) any later version.
	
	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	More about this license: http://www.question2answer.org/license.php
*/

	if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
		header('Location: ../../');
		exit;
	}

	qa_register_plugin_module('page', 'qa-open-questions.php', 'qa_open_qustions', 'Open Questions');
	qa_register_plugin_phrases('qa-open-questions-lang-*.php', 'open_questions');	

/*
	Omit PHP closing tag to help avoid accidental output
*/