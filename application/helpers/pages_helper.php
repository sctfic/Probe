<?php

/*
@description: fetch common page data (title, description, author, etc.)
@return: functionReturn
*/
function pageFetchConfig($page) { //
    $data['page'] = $page;
    $data['title'] = _($page.':title');
    $data['description'] = _($page.':description');
    $data['author'] = _($page.':author');

  return $data;
}
