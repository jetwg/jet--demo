<?php

return array(
    'a' => array(
        'path' => 'a.js',
        'deps' => array('b', 'c')
    ),
    'b' => array(
        'path' => 'b.js',
        'deps' => array('d')
    ),
    'c' => array(
        'path' => 'c.js',
        'deps' => array('d')
    ),
    'd' => array(
        'path' => 'd.js',
        'deps' => array('e'),
        'asyncDeps' => array('f')
    ),
    'e' => array(
        'path' => 'd.js',
        'deps' => array()
    ),
    'f' => array(
        'path' => 'f.js',
        'deps' => array('e', 'h')
    ),
    'h' => array(
        'path' => 'h.js',
        'deps' => array()
    )
);

?>
