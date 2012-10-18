<?php

/*
@description:
	fetch common page data (title, description, author, etc.)
	this allow to use i18n string for the page date.
@return: functionReturn
*/
function pageFetchConfig($page) { //
	$data = array();
    $data['page'] = $page;
    $data['title'] = i18n($page.':title', true);
    $data['description'] = i18n($page.':description', true);
    $data['author'] = i18n($page.':author', true);

//     var_dump($data);
  return $data;
}

function getPage($data = null) {
}