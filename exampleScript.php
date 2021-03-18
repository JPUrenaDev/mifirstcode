<?php
function getPage($start, $page, $from = null) {
		// From: Load posts starting with a certain ID


	// Disable the per_page limit if $from is set
    if(is_numeric($from)) {
        $this->per_page = 9999;
		$from = 'AND `messages`.`id` > \''.$this->db->real_escape_string($from).'\'';
    } 
        else {
		     $from = '';
	    }
	
	// If the $start value is 0, empty the query;
	if($start == 0) {
	    $start = '';
	
	}  
	    else {
			// Else, build up the query
			$start = 'AND `messages`.`id` < \''.$this->db->real_escape_string($start).'\'';
		}
		    // The query to select the subscribed users
		    $query = sprintf("SELECT * FROM `messages`, `users` WHERE `page` = '%s' AND `users`.`suspended` = 0 AND `messages`.`public` = 1 AND `messages`.`uid` = `users`.`idu` %s %s ORDER BY `messages`.`id` DESC LIMIT %s", $page, $start, $from, ($this->per_page + 1));
		    return $this->getMessages($query, 'loadPage', $page);
}

function groupPermission($group, $user, $type = null) {
// Type 1: Check if the user can post
	// Type 0: Check if the user can view the group's messages
	if($type == 1) {
	// If the user is in group

		if($user['status'] == 1) {

			// If the group settings allow only admins to post
			if($group['posts']) {
		// Check if the user is an administrator
		        if(in_array($user['permissions'], array(1, 2))) {
	                return 1;

					} 
						else {
				
	                     return false;

		                }
		    }

		    return 1;
	    }


		} else {
	// If the group is public
			if($group['privacy'] == 0) {
	            return 1;
			}
	// If the group is private
            if($group['privacy'] == 1) {
	// If the user is in group
	            if($user['status'] == 1) {
	                return 1;
	
	            }           
            }
		}
	return false;
}
//resultado final ..
?>
