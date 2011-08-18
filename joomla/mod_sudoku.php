<?php
/**
mod_sudoku for Joomla! 1.6 and 1.7
Author : Le Sudoku
Website : http://www.le-sudoku.fr
Date    : 02 August 2011
Licence : GPL-2
Copyright Le Sudoku
Based on script provided by http://www.le-sudoku.fr
*/

// no direct access
defined('_JEXEC') or die('Restricted access');

$size = ($params->get( 'size' )!='') ? $params->get( 'size' ) : '500';
$level = ($params->get( 'level' )!='') ? $params->get( 'level' ) : '1';
$width = ($params->get( 'width' )!='') ? $params->get( 'width' ) : '9';
$background = ($params->get( 'background' )!='') ? $params->get( 'background' ) : 'FFFFFF'; 
$language = ($params->get( 'language' )!='') ? $params->get( 'language' ) : 'fr'; 
if($language == 'en') {
	$output  = '<iframe src="http://www.live-sudoku.com/perso?size='.$size.'&level='.$level.'&width='.$width.'&background='.$background.'" frameborder="0" width="'.$width.'" height="'.$width.'" scrolling="no">';
	$output .= '</iframe><noscript>You must accept javascript to play <a href="http://www.live-sudoku.com" target="_blank">sudoku</a>.</noscript>';
} else {
	$output  = '<iframe src="http://www.le-sudoku.fr/perso?size='.$size.'&level='.$level.'&width='.$width.'&background='.$background.'" frameborder="0" width="'.$width.'" height="'.$width.'" scrolling="no">';
	$output .= '</iframe><noscript>Vous devez accepter le javascript pour jouer au <a href="http://www.le-sudoku.fr" target="_blank">sudoku</a>.</noscript>';
}
echo $output;
?>