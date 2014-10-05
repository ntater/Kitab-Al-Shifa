<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		Kitab Al-Shifa: <?php echo $title_for_layout; ?>
	</title>
	<?php
//		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
    		<h1><?php echo $this->Html->link('Kitab Al Shifa', array('controller' => 'shifts', 'action' => 'home')); ?></h1>
		<nav> <!-- HTML5 navigation tag -->
    		<ul>
    			<li>
    				<?php
					$isLive = '';
					$currentPage = 	$_SERVER['REQUEST_URI'];
					if ($currentPage == Router::url('/shifts/wizard')) {
						$isLive = array('class' => 'menu-current');
					}
    				echo $this->Html->link('Schedules', array('controller' => 'shifts', 'action' => 'wizard'), $isLive); ?>
    			</li>
    			<li><?php 
	    			$isLive = '';
	    			if ($currentPage == Router::url('/trades/index') || $currentPage == Router::url('/trades') || $currentPage == Router::url('/trades/compare') || $currentPage == Router::url('/trades/history')) {
	    				$isLive = array('class' => 'menu-current');
	    			}
    				echo $this->Html->link('Shift trading', array('controller' => 'trades', 'action' => 'index'), $isLive); ?>
    			</li>
				<?php
					if ($admin) { ?>
		   				<li><?php 
			   				$isLive = '';
							if ($currentPage == Router::url('/pages/admin')) {
								$isLive = array('class' => 'menu-current');
							}
			   				echo $this->Html->link('Administration', array('controller' => 'pages', 'action' => 'admin'), $isLive); ?>
		   				</li>
				<?php } ?>
    		</ul>
				<?php if($logged_in) { ?>
		    		<ul style="float:right">
						<li><?php echo $this->Html->link($users_username .' (Logout)', array('controller' => ' users', 'action' => 'logout'));
				} ?>
				</li>
			</ul>
    		<div class="clear"></div>
    	</nav>
		<nav id="secondary-menu" <?php if ($currentPage != Router::url('/trades/index') && $currentPage != Router::url('/trades') && $currentPage != Router::url('/trades/compare') && $currentPage != Router::url('/trades/history')) {echo 'style="display: none;"';}?>>
		<ul>
			<li><?php
				$isLive = '';
					if ($currentPage == Router::url('/trades/index') || $currentPage == Router::url('/trades')) {
					$isLive = array('class' => 'menu-current');
				}
				echo $this->Html->link('Make a trade', array('controller' => 'trades', 'action' => 'index'), $isLive) ?>
			</li>
			<li><?php 
				$isLive = '';
				if ($currentPage == Router::url('/trades/compare')) {
					$isLive = array('class' => 'menu-current');
				}
				echo $this->Html->link('Compare schedules', array('controller' => 'trades', 'action' => 'compare'), $isLive) ?>
			</li>
			<li><?php
				$isLive = '';
				if ($currentPage == Router::url('/trades/history')) {
					$isLive = array('class' => 'menu-current');
				}
				echo $this->Html->link('Trading history', array('controller' => 'trades', 'action' => 'history'), $isLive) ?>
			</li>
			</ul>
		<div class="clear"></div>
		</nav>
		</div>
    	<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>
		</div>
		<footer>
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> __('CakePHP: the rapid development php framework'), 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</footer>
	</div>
</body>
</html>