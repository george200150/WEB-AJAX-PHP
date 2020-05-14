<?php
if (isset($_GET['path'])) { // get the root directory for the tree view
    $files = scandir($_GET['path']); // scan root directory
    $array_files = array();

    foreach ($files as $file) {
        if ($file != '.' && $file != '..') { // avoid showing current directory and parent directory
            if (is_dir($_GET['path'] . "/" . $file)) { // if the file is a directory, then insert the name into "$array_files"
                array_push($array_files, array("file" => $file, "dir" => true, "content" => "", "opened" => false));
			}
            else { // the file is not a directory (-> it is a text file) => display its content on screen
                $content = file_get_contents($_GET['path'] . '/' . $file); // get the text content
                $content = base64_encode(htmlentities($content));
				// convert text to readable HTML entities
				// then encode data in base 64, in order to survive transport (through layers that are not 8-bit clean - mail)
                array_push($array_files, array("file" => $file, "dir" => false, "content" => $content));
            }
		}
	}
    echo json_encode($array_files); // encode (.json) the files discovered
}
?>