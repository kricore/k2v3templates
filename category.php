<?php
/**
 * @version		3.0.0
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2014 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die; ?>

<section id="k2Container" class="categoryView<?php if($this->params->get('pageclass_sfx')) echo ' '.$this->params->get('pageclass_sfx'); ?>">

	<?php if($this->params->get('show_page_heading')): ?>
	<!-- Page heading -->
	<h1>
		<?php echo $this->escape($this->params->get('page_heading')); ?>
	</h1>
	<?php endif; ?>
	
	<?php if($this->params->get('catFeedIcon')): ?>
	<!-- RSS feed icon -->
	<div class="k2FeedIcon">
		<a href="<?php echo $this->feedLink; ?>" title="<?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?>">
			<span><?php echo JText::_('K2_SUBSCRIBE_TO_THIS_RSS_FEED'); ?></span>
		</a>
		<div class="clr"></div>
	</div>
	<?php endif; ?>
	
	<?php if(isset($this->category) || ( $this->params->get('subCategories') && count($this->category->children) )): ?>
	<!-- Blocks for current category and subcategories -->
	<div class="itemListCategoriesBlock">

		<?php if(isset($this->category) && ( $this->params->get('catImage') || $this->params->get('catTitle') || $this->params->get('catDescription') || $this->category->events->K2CategoryDisplay )): ?>
		<!-- Category block -->
		<header class="itemListCategory">

			<?php if($this->category->canAdd): ?>
			<!-- Item add link -->
			<span class="catItemAddLink">
				<a href="<?php echo $this->category->addLink; ?>">
					<?php echo JText::_('K2_ADD_A_NEW_ITEM_IN_THIS_CATEGORY'); ?>
				</a>
			</span>
			<?php endif; ?>

			<?php if($this->params->get('catImage') && $this->category->image): ?>
			<!-- Category image -->
			<img alt="<?php echo htmlspecialchars($this->category->image->alt, ENT_QUOTES, 'UTF-8'); ?>" src="<?php echo $this->category->image->src; ?>" style="width:<?php echo $this->params->get('catImageWidth'); ?>px; height:auto;" />
			<?php endif; ?>

			<?php if($this->params->get('catTitle')): ?>
			<!-- Category title -->
			<h2><?php echo $this->category->title; ?><?php if($this->params->get('catTitleItemCounter')) echo ' ('.$this->pagination->total.')'; ?></h2>
			<?php endif; ?>

			<?php if($this->params->get('catDescription')): ?>
			<!-- Category description -->
			<p><?php echo $this->category->description; ?></p>
			<?php endif; ?>
			
			<?php if($this->params->get('catExtraFields') && count($this->category->extraFieldsGroups)): ?>
			<!-- Category extra fields -->
			<div class="catExtraFields">
				<h3><?php echo JText::_('K2_ADDITIONAL_INFO'); ?></h3>
				<?php foreach ($this->category->extraFieldsGroups as $extraFieldGroup): ?>
				<h4><?php echo $extraFieldGroup->name; ?></h4>
				<ul>
				<?php foreach ($extraFieldGroup->fields as $key=>$extraField): ?>
				<?php if($extraField->output): ?>
					<li class="<?php echo ($key%2) ? "odd" : "even"; ?> type<?php echo ucfirst($extraField->type); ?> group<?php echo $extraField->group; ?>">
						<span class="catExtraFieldsLabel"><?php echo $extraField->name; ?>:</span>
						<span class="catExtraFieldsValue"><?php echo $extraField->output; ?></span>
					</li>
				<?php endif; ?>
				<?php endforeach; ?>
				</ul>
				<?php endforeach; ?>
				<div class="clr"></div>
			</div>
			<?php endif; ?>

			<!-- K2 Plugins: K2CategoryDisplay -->
			<?php echo $this->category->events->K2CategoryDisplay; ?>

			<div class="clr"></div>
		</header>
		<?php endif; ?>

		<?php if($this->params->get('subCategories') && count($this->category->children)): ?>
		<!-- Subcategories -->
		<div class="itemListSubCategories">
			<h3><?php echo JText::_('K2_CHILDREN_CATEGORIES'); ?></h3>

			<?php $counter = 0; foreach($this->category->children as $child): ?>

			<?php
			// Define a CSS class for the last container on each row
			if( (($counter+1)%($this->params->get('subCatColumns'))==0))
				$lastContainer= ' subCategoryContainerLast';
			else
				$lastContainer='';
			?>

			<div class="subCategoryContainer<?php echo $lastContainer; ?>"<?php echo (count($this->category->children)==1) ? '' : ' style="width:'.number_format(100/$this->params->get('subCatColumns'), 1).'%;"'; ?>>
				<div class="subCategory">
					<?php if($this->params->get('subCatImage') && $child->image): ?>
					<!-- Subcategory image -->
					<a class="subCategoryImage" href="<?php echo $child->link; ?>">
						<img alt="<?php echo htmlspecialchars($child->image->alt, ENT_QUOTES, 'UTF-8'); ?>" src="<?php echo $child->image->src; ?>" />
					</a>
					<?php endif; ?>

					<?php if($this->params->get('subCatTitle')): ?>
					<!-- Subcategory title -->
					<h2>
						<a href="<?php echo $child->link; ?>">
							<?php echo $child->title; ?><?php if($this->params->get('subCatTitleItemCounter')) echo ' ('.$child->numOfItems.')'; ?>
						</a>
					</h2>
					<?php endif; ?>

					<?php if($this->params->get('subCatDescription')): ?>
					<!-- Subcategory description -->
					<p><?php echo $child->description; ?></p>
					<?php endif; ?>

					<!-- Subcategory more... -->
					<a class="subCategoryMore" href="<?php echo $child->link; ?>">
						<?php echo JText::_('K2_VIEW_ITEMS'); ?>
					</a>

					<div class="clr"></div>
				</div>
			</div>
			<?php if(($counter+1)%($this->params->get('subCatColumns'))==0): ?>
			<div class="clr"></div>
			<?php endif; ?>
			<?php $counter++; endforeach; ?>

			<div class="clr"></div>
		</div>
		<?php endif; ?>

	</div>
	<?php endif; ?>
	
	
	<?php if(count($this->items)): ?>
	<div class="itemList">
		<?php foreach($this->items as $item): ?>
			<?php $this->item = $item; echo $this->loadItemlistLayout(); ?>
		<?php endforeach; ?>
	</div>
	<?php endif; ?>	
	
	<?php if($this->pagination->get('pages.total') > 1): ?>
	<!-- Pagination -->
	<div class="k2Pagination pagination">
		<?php if($this->params->get('catPagination')) echo $this->pagination->getPagesLinks(); ?>
		<div class="clr"></div>
		<?php if($this->params->get('catPaginationResults')) echo $this->pagination->getPagesCounter(); ?>
	</div>
	<?php endif; ?>

</section>