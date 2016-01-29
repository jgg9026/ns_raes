<?php 
function block_ns_raes_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array()) {
	// Check the contextlevel is as expected - if your plugin is a block, this becomes CONTEXT_BLOCK, etc.
		$fs = get_file_storage();
		$fullpath = "/{$context->id}/block_nscoursefields/$filearea/$args[0]/$args[1]";
		if (!$file = $fs->get_file_by_hash(sha1($fullpath)) or $file->is_directory()) {
			return false;
		}
		// finally send the file
		send_stored_file($file, 86400, 0, true, $options); // download MUST be forced - security!
	}
?>