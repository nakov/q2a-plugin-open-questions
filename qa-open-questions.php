<?php

/*
	"Open Questions" plugin for Question2Answer
	(c) Svetlin Nakov - http://www.nakov.com

	
	File: qa-plugin/open-questions/qa-open-questions.php
	Version: 1.0
	Description: Displays in a page all "open" questions (without
	answer and not closed). Works like the "Unanswered" page but
	excludes all closed questions. This plugin shows the questions
	that need to be answered by someone - unanswered and not closed.


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

require_once QA_INCLUDE_DIR.'qa-app-q-list.php';


class qa_open_qustions {
	
	function suggest_requests() // for display in admin interface
	{	
		return array(
			array(
				'title' => 'Open Questions',
				'request' => 'open-questions',
				'nav' => 'M', // 'M'=main, 'F'=footer, 'B'=before main, 'O'=opposite main, null=none
			),
		);
	}

	
	function match_request($request)
	{
		if ($request=='open-questions')
			return true;

		return false;
	}

	
	function process_request($request)
	{
		//	Get list of unanswered open questions
		
		$userid=qa_get_logged_in_userid();
		$start=qa_get_start();
		$questions_selectspec=$this->qa_db_open_qs_selectspec($userid, $start);
		$questions=qa_db_select_with_pending($questions_selectspec);
		
		//	Prepare and return the content for the theme
		
		$questions_found_title=qa_lang_html('open_questions/questions_found_title');
		$no_questions_title=qa_lang_html('open_questions/no_questions_title');
		$count=qa_opt('cache_unaqcount');
		
		$qa_content=qa_q_list_page_content(
			$questions, // questions
			qa_opt('page_size_una_qs'), // questions per page
			$start, // start offset
			@$count, // total count
			$questions_found_title, // title if some questions are found
			$no_questions_title, // title if no questions are found
			null, // categories for navigation (null since not shown on this page)
			null, // selected category id (null since not relevant)
			false, // show question counts in category navigation (null since not relevant)
			null, // prefix for links in category navigation (null since no navigation)
			null, // prefix for RSS feed paths (null to hide)
			qa_html_suggest_qs_tags(qa_using_tags()), // suggest tags
			null, // extra parameters for page links
			null // category nav params (null since not relevant)
		);	
		
		return $qa_content;
	}
	
	
	function qa_db_open_qs_selectspec($voteuserid, $start)
	{
		$pagesize=qa_opt_if_loaded('page_size_una_qs');		
		$where_clause_question_open='acount=0 AND closedbyid IS NULL';		
		$type='Q';	// question (not hidden)
		$selectspec=qa_db_posts_basic_selectspec($voteuserid, false);
		$selectspec['source'].=
			" JOIN (SELECT postid FROM ^posts WHERE ".
			"type=$ AND ".$where_clause_question_open.
			" ORDER BY ^posts.created DESC LIMIT #,#)".
			" y ON ^posts.postid=y.postid";
		array_push($selectspec['arguments'], $type, $start, $pagesize);
		$selectspec['sortdesc']='created';
		return $selectspec;
	}

}


/*
	Omit PHP closing tag to help avoid accidental output
*/