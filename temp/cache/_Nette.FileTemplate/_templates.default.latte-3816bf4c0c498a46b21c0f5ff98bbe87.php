<?php //netteCache[01]000409a:2:{s:4:"time";s:21:"0.28661200 1364763078";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:87:"C:\Users\Daniel\Documents\GitHub\drifting\_admin\adminframework\templates\default.latte";i:2;i:1364761198;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"0ce871c released on 2012-11-28";}}}?><?php

// source file: C:\Users\Daniel\Documents\GitHub\drifting\_admin\adminframework\templates\default.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '210l9lz2s3')
;
// prolog Nette\Latte\Macros\UIMacros
//
// block content
//
if (!function_exists($_l->blocks['content'][] = '_lbb0a01a3e07_content')) { function _lbb0a01a3e07_content($_l, $_args) { extract($_args)
?><h2><?php echo Nette\Templating\Helpers::escapeHtml($headline, ENT_NOQUOTES) ?></h2>
    <?php echo Nette\Templating\Helpers::escapeHtml($control["admin"]->getComponent('dataGrid')->render(), ENT_NOQUOTES) ;
}}

//
// end of blocks
//

// template extending and snippets support

$_l->extends = empty($template->_extended) && isset($_control) && $_control instanceof Nette\Application\UI\Presenter ? $_control->findLayoutTemplateFile() : NULL; $template->_extended = $_extended = TRUE;


if ($_l->extends) {
	ob_start();

} elseif (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
?>

<?php if ($_l->extends) { ob_end_clean(); return Nette\Latte\Macros\CoreMacros::includeTemplate($_l->extends, get_defined_vars(), $template)->render(); }
call_user_func(reset($_l->blocks['content']), $_l, get_defined_vars()) ; 