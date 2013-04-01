<?php //netteCache[01]000412a:2:{s:4:"time";s:21:"0.13467200 1364774666";s:9:"callbacks";a:2:{i:0;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:9:"checkFile";}i:1;s:90:"C:\Users\Daniel\Documents\GitHub\drifting\mylibs\contentcomponents\Articles\articles.latte";i:2;i:1364749636;}i:1;a:3:{i:0;a:2:{i:0;s:19:"Nette\Caching\Cache";i:1;s:10:"checkConst";}i:1;s:25:"Nette\Framework::REVISION";i:2;s:30:"0ce871c released on 2012-11-28";}}}?><?php

// source file: C:\Users\Daniel\Documents\GitHub\drifting\mylibs\contentcomponents\Articles\articles.latte

?><?php
// prolog Nette\Latte\Macros\CoreMacros
list($_l, $_g) = Nette\Latte\Macros\CoreMacros::initRuntime($template, '5lgdp4bieq')
;
// prolog Nette\Latte\Macros\UIMacros

// snippets support
if (!empty($_control->snippetMode)) {
	return Nette\Latte\Macros\UIMacros::renderSnippets($_control, $_l, get_defined_vars());
}

//
// main template
//
if ($isAdmin): $_ctrl = $_control->getComponent("grid"); if ($_ctrl instanceof Nette\Application\UI\IRenderable) $_ctrl->validateControl(); $_ctrl->render() ?>

<?php elseif ($isHome): $iterations = 0; foreach ($articles as $id =>$article): ?>
    <div class="articlePreview">
	<div class="top">
	    <div class="in clearfix">
		<h4><a href="<?php echo htmlSpecialChars($_presenter->link(":Front:Article:one", array($id))) ?>
"> <?php echo Nette\Templating\Helpers::escapeHtml($article->headline, ENT_NOQUOTES) ?>
</a></h4><div class="info"><?php echo Nette\Templating\Helpers::escapeHtml($template->date($article->created, "j.n.y"), ENT_NOQUOTES) ?>
 | <td><?php echo Nette\Templating\Helpers::escapeHtml($article->user->name, ENT_NOQUOTES) ?></td></div>
	    </div>	    
	</div>
<?php if ($article->image_url): ?>	<div class="articleImage">
	    <img src="" />
	</div>
<?php endif ?>
	<div class="body">
	    
	    <?php echo $template->truncate($article->perex, 250) ?>

	</div>
    </div>
<?php $iterations++; endforeach ;else: ?>
    <table class="admin-list">
	<tr>
	    <th>Název Článku</th>
	    <th>Autor</th>
	    <th>Poslední změna</th>
	    <th>Vytvořeno</th>

	</tr>
<?php $iterations = 0; foreach ($articles as $article): ?>
	    <tr>
		<td><?php echo Nette\Templating\Helpers::escapeHtml($article->headline, ENT_NOQUOTES) ?></td>
		<td><?php echo Nette\Templating\Helpers::escapeHtml($article->user->name, ENT_NOQUOTES) ?></td>
		<td><?php echo Nette\Templating\Helpers::escapeHtml($template->date($article->updated, "j.n.y"), ENT_NOQUOTES) ?></td>
		<td><?php echo Nette\Templating\Helpers::escapeHtml($template->date($article->created, "j.n.y"), ENT_NOQUOTES) ?></td>
		
		<td ><a href="<?php echo htmlSpecialChars($_presenter->link(":Admin:ArticleManager:Edit", array($article->id))) ?>">Upravit</a></td>
		<td ><a href="<?php echo htmlSpecialChars($_presenter->link(":Admin:ArticleManager:Delete", array($article->id))) ?>">Smazat</a></td>
	    </tr>
<?php $iterations++; endforeach ?>
    </table>
<?php endif ;