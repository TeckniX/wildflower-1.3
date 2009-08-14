<div id="event_main">
	<div id="event_img"><img src="<?= $this->webroot;?>wildflower/thumbnail/<?= end(explode('/',$event['WildEvent']['thumbnail']))?>/750/1000" /></div>
	<div id="event_info">
		<div id="blue_arrow_back"><?php echo $html->link('back to events',  '/'.Configure::read('Wildflower.eventsParent')); ?></div>
	  <h1><?php echo $time->niceShort($event['WildEvent']['evtdate']) ?></h1>
	  <h3><?php echo $event['WildEvent']['title'] ?></h3>
	  <h4><?php echo $event['WildEvent']['subtitle'] ?></h4>
		<?php echo $wild->processWidgets($event['WildEvent']['content']); ?>
	  </div>
	<?php 
	        echo $navigation->create(array(
	            $html->image('facebook.png',array('title'=>'Share on Facebook', 'alt'=>'Share on Facebook')) => 'http://www.facebook.com',
	            $html->image('myspace.png',array('title'=>'Share on MySpace', 'alt'=>'Share on MySpace')) => 'http://www.myspace.com',
	            $html->image('twitter.png',array('title'=>'Share on Twitter', 'alt'=>'Share on Twitter')) => 'http://www.twitter.com',
				$html->image('delicious.png',array('title'=>'Share on Delicious', 'alt'=>'Share on Delicious')) => 'http://www.delicious.com',
				'Share an Event' => null
	        ), array('class' => 'share_events','style'=>'margin-top:10px; padding:0;'));
	    ?>
	</div><!--event_info end-->     	 
</div><!--event_main end-->  

<div class="clear"></div>

