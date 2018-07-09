<?php
/**
 * @author d.ivaschenko
 */

return [
    '' => 'UrlController@index',
    'create' => 'UrlController@create',
    '{regex}[A-Za-z0-9]{5}' => 'UrlController@redirect',
];