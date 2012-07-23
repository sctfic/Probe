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
    $data['title'] = _($page.':title');
    $data['description'] = _($page.':description');
    $data['author'] = _($page.':author');

//     var_dump($data);
  return $data;
}

function getPage($data = null) {
}