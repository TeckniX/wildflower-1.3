<?php
    $cssClasses = array('featured_info');
    if (isset($this->params['ChangeIndicator'])) {
        $changedId = $this->params['ChangeIndicator']['id'];
        if ($changedId == $event['WildEvent']['id']) {
            array_push($cssClasses, 'changed');
            unset($this->params['ChangeIndicator']);
        }
    }
?>

<div id="featured_main">
  	<div class="featured_left_content">
  		<?php if(!empty($events)): foreach ($events as $event) { ?>
		<div class="featured_flyer"><?php echo $html->link($html->image('/wildflower/thumbnail/'.end(explode('/',$event['WildEvent']['thumbnail'])).'/300/1000'),  '/'.Configure::read('Wildflower.eventsParent').'/'.$event['WildEvent']['slug'],array('escape'=>false)); ?></div>
		<div class="<?php echo join(' ', $cssClasses) ?>" id="event-<?php echo $event['WildEvent']['id'] ?>">
			<h1><?php echo $time->niceShort($event['WildEvent']['evtdate']) ?></h1>
			<h3><?php echo $html->link($event['WildEvent']['title'],  '/'.Configure::read('Wildflower.eventsParent').'/'.$event['WildEvent']['slug']); ?></h3>
			<h4><?php echo $event['WildEvent']['subtitle'] ?></h4>
			<h5><?php echo str_replace('-','&bull;',$event['WildEvent']['evtdj']) ?></h5>
			<?php if($event['WildEvent']['location'] != 'N;' || $event['WildEvent']['location']!='s:0:"";'){ ?>
			<p><span class="blue_text">Location:</span> <?php echo  implode(', ',unserialize($event['WildEvent']['location'])) ?></p>
			<?php } ?>
		  	<p><span class="blue_text">Featuring:</span>
			<?php echo $wild->processWidgets($event['WildEvent']['content']); ?>
			<?php echo $this->element('edit_this', array('id' => $event['WildEvent']['id'])); ?>
			</p>        
	        <div class="read_more"><a href="#">Buy Tickets</a></div>
			<?php 
		        echo $navigation->create(array(
		            $html->image('facebook.png',array('title'=>'Share on Facebook', 'alt'=>'Share on Facebook')) => 'http://www.facebook.com',
		            $html->image('myspace.png',array('title'=>'Share on MySpace', 'alt'=>'Share on MySpace')) => 'http://www.myspace.com',
		            $html->image('twitter.png',array('title'=>'Share on Twitter', 'alt'=>'Share on Twitter')) => 'http://www.twitter.com',
					$html->image('delicious.png',array('title'=>'Share on Delicious', 'alt'=>'Share on Delicious')) => 'http://www.delicious.com',
					'Share an Event' => null
		        ), array('class' => 'share_events'));
		    ?>
	      </div><!--featured info 1 end-->
	      <div class="clear"></div>
	      <div class="blue_gradient_bar_580"></div>
		<?php }
		else:
		echo "No events have been found!";
		endif; ?>
	  <?php echo $this->element('wf_pagination') ?>
    </div><!--featured_left_content end-->
    
    <div class="featured_right_content">
    	<div id="calendar_month"><img src="<?= $this->webroot ?>img/blue_arrow_back.png" /> JUNE <img src="<?= $this->webroot ?>img/blue_arrow.png" /></div>
      <div class="blue_gradient_bar_300"></div>
      <div id="calendar_date">
      	<table id="calendar_table">
         	<tr>
          	<td class="white_font_big">S</td>
            <td class="white_font_big">M</td>
            <td class="white_font_big">T</td>
            <td class="white_font_big">W</td>
            <td class="white_font_big">T</td>
            <td class="white_font_big">F</td>
            <td class="white_font_big">S</td>
          </tr>
          <tr>
          	<td></td>
            <td>1</td>
            <td>2</td>
            <td>3</td>
            <td>4</td>
            <td>5</td>
            <td class="blue_bold">6</td>
          </tr>
          <tr>
          	<td>7</td>
            <td>8</td>
            <td>9</td>
            <td>10</td>
            <td>11</td>
            <td>12</td>
            <td class="blue_bold">13</td>
          </tr>
          <tr>
          	<td>14</td>
            <td>15</td>
            <td>16</td>
            <td>17</td>
            <td>18</td>
            <td>19</td>
            <td class="blue_bold">20</td>
          </tr>
          <tr>
          	<td>21</td>
            <td>22</td>
            <td>23</td>
            <td>24</td>
            <td>25</td>
            <td>26</td>
            <td class="blue_bold">27</td>
          </tr>
          <tr>
          	<td>28</td>
            <td>29</td>
            <td>30</td>
            <td></td>
            <td></td>
            <td></td>
            <td class="blue_bold"></td>
          </tr>
        </table>
      </div><!--calendar_date end-->
      <div class="blue_gradient_bar_300"></div>
      <div id="calendar_bottom">
      	<div id="schedule"><h4>Club Space Schedule</h4>
        	<div style="float:left; padding-top: 3px;"><img src="app-img/twenty_one.png" /></div>
          <div style="float: left; vertical-align: top; padding-left: 10px; color: #ffffff;">Subscribe to the<br /> iPhone Calendar</div>
        </div>
        <div class="clear"></div>
        <div id="scheduled_events"><h5>Saturday June 20th, 2009</h5> 
      				<h1>Summer Kick Off Party</h1>
              <h5>Saturday June 27, 2009</h5>
              <h1>Kickin' it</h1>
              <h5>Saturday July 4, 2009</h5>
              <h1>IndepenDance Party</h1>
              <h5>Saturday July 4, 2009</h5>
              <h1>IndepenDance AfterParty</h1>
              <h5>Saturday July 11, 2009</h5>
              <h1>Oscar M</h1>
              <h5>Saturday July 18, 2009</h5>
              <h1>Techno Loft</h1>
              <h5>Saturday July 25, 2009</h5>
              <h1>Patrick M Release Party</h1>
              <h5>Saturday July 25, 2009</h5>
              <h1>Kickin' it</h1>
      		</div> 
      </div><!--calendar_bottom end-->
    </div><!--featured_right_content end-->
  	 
  </div><!--featured_main end-->  
  
  <div class="clear"></div>

