<?php
//uses('Sanitize');

class WildEventsController extends AppController {

	public $helpers = array('Cache', 
	    'List', 
	    'Rss', 
	    'Textile', 
	    'Time',
	    'Paginator',
		'Html', 
		'Form', 
		'Calendar');
	public $pageTitle = 'Events';
	public $uses = array('WildEvent','WildAsset');
	
	/**
	* the idea is that the calendar helper itself is purely a shell
	* the calendar will just display whatever is sent to it
	* anything you want to do to it is put togthere here in the controller or in a component when I get around to writing it
	*
	*	@param $year string
	* @param $month string
	*
	**/

	function wf_index($year = null, $month = null) {
	
		$this->WildEvent->recursive = 0;
		
		$month_list = array('january', 'febuary', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december');
		$day_list = array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
		$base_url = $this->webroot . 'events/calendar'; // NOT not used in the current helper version but used in the data array
		$view_base_url = $this->webroot. 'events';

		$data = null;
		
		if(!$year || !$month)
			{
				$year = date('Y');
				$month = date('M');
				$month_num = date('n');
				$item = null;
			}
			
		$flag = 0;
				
		for($i = 0; $i < 12; $i++) { // check the month is valid if set
				if(strtolower($month) == $month_list[$i])
					{
						if(intval($year) != 0)
							{
								$flag = 1;
								$month_num = $i + 1;
								$month_name = $month_list[$i];
								break;
							}
					}
			}
					
		if($flag == 0) { // if no date set, then use the default values
				$year = date('Y');
				$month = date('M');
				$month_name = date('F');
				$month_num = date('m');
		}
		
		$fields = array('id', 'title', 'DAY(evtdate) AS event_day');
		
		$var = $this->WildEvent->findAll('MONTH(WildEvent.evtdate) = ' . $month_num . ' AND YEAR(WildEvent.evtdate) = ' . $year, $fields, 'WildEvent.evtdate ASC');
		
		/**
		* loop through the returned data and build an array of 'events' that is passes to the view
		* array key is the day of month 
		*
		*/
		
		foreach($var as $event) {
			if(isset($event[0]['event_day'])) {
				$day = $event[0]['event_day'];
				$data[$day][] = $event['WildEvent'];
				
			}
		}
		
		$this->set('year', $year);
		$this->set('month', $month);
		$this->set('base_url', $base_url);
		$this->set('data', $data);
		
	}
	/**
     * Create a new event 
     *
     * Returns the updated category list as JSON.
     */
	function wf_update() {
		if (!empty($this->data)) {
			
			// Publish?
	        if (isset($this->data['__save']['publish'])) {
	            $this->data[$this->modelClass]['draft'] = 0;
	        }
	        unset($this->data['__save']);
			if (isset($this->data[$this->modelClass]['location'])) {
				$this->data[$this->modelClass]['location'] = serialize($this->data[$this->modelClass]['location']);
			}
			
			if (isset($this->data[$this->modelClass]['slug'])) {
	            $this->data[$this->modelClass]['slug'] = AppHelper::slug($this->data[$this->modelClass]['slug']);
	        }
			
			$this->{$this->modelClass}->create($this->data);
			if ($this->{$this->modelClass}->save()) {
				$message = __('Event has been saved.', true);
				$msgClass = 'message';
			} else {
				$message = __('An error occured while saving your event.' , true);
				$msgClass = 'error';
			}
			
			$this->Session->setFlash($message, 'default', array('class' => $msgClass));
		
			$this->redirect(array('action' => 'edit', $this->{$this->modelClass}->id));
		}
		
	}
	
     /**
     * Create a post and redirect to it's edit screen
     *
     */
    function wf_create() {
        $defaultParams = array(
            'draft' => 1,
			'evtdate' => date('Y-m-d H:i:s')
        );
        $this->data[$this->modelClass] = am($this->data[$this->modelClass], $defaultParams);
        $this->{$this->modelClass}->create($this->data);
        $this->{$this->modelClass}->save();
		$this->redirect(array('action' => 'edit', $this->{$this->modelClass}->id));
    }
	

    /**
     * Edit an event
     * 
     * @param int $id
     */
    function wf_edit($id = null, $revisionNumber = null) {
    	$this->data = $this->WildEvent->findById($id);
        if (empty($this->data)) return $this->cakeError('object_not_found');
		//var_dump($this->data);
        
        // If viewing a revision, merge with revision content
        if ($revisionNumber) {
            $this->data = $this->WildEvent->getRevision($id, $revisionNumber);
            
            $this->set(array('revisionId' => $revisionNumber, 'revisionCreated' => $this->data['WildRevision']['created']));
        }
        
        // View
        $isDraft = ($this->data[$this->modelClass]['draft'] == 1) ? true : false;
        $isRevision = !is_null($revisionNumber);
		$this->data[$this->modelClass]['location'] = unserialize($this->data[$this->modelClass]['location']);
		    	
		$this->set(compact('isRevision', 'isDraft'));
        $this->pageTitle = $this->data[$this->modelClass]['title'];
    }
    
	/**
	 * Add an event thumbnail
	 * 
	 * @param int $id
	 */
	function wf_thumb($id = null) {
        //$this->WildEvent->contain(array('WildUser', 'WildCategory'));
        $this->data = $this->WildEvent->findById($id);
        
        if (empty($this->data)) return $this->cakeError('object_not_found');
   
        $isDraft = ($this->data[$this->modelClass]['draft'] == 1) ? true : false;
		//$this->paginate['limit'] = 10;
		$this->paginate['conditions'] = "WildAsset.mime LIKE 'image%'";
		$this->paginate['order'] = array('WildAsset.created' => 'desc');
		$images = $this->paginate('WildAsset');
        $this->set(compact('isDraft','images'));
        
        $this->pageTitle = $this->data[$this->modelClass]['title'];
    }
	
	/**
	 * Set event option such as friendly url
	 *
	 * @param int $id
	 */
	function wf_options($id = null) {
        $this->data = $this->WildEvent->findById($id);
        
        if (empty($this->data)) return $this->cakeError('object_not_found');
   
        $isDraft = ($this->data[$this->modelClass]['draft'] == 1) ? true : false;
        $this->set(compact('isDraft'));
        
        $this->pageTitle = $this->data[$this->modelClass]['title'];
    }
	
	/**
     * Event index
     * 
     */
    function index() {
        $this->cacheAction = true;
        
        $this->pageTitle = 'Events';
        
        $this->paginate = array(
            'limit' => 4,
            'order' => array('WildEvent.created' => 'desc'),
            'conditions' => 'WildEvent.draft = 0'
        );
        $events = $this->paginate($this->modelClass);
        
        if (isset($this->params['requested'])) {
            return $events;
        }
		        
        $this->set(compact('events'));
    }
    
    /**
     * View an event and it's info
     *
     * @param string $lug
     */
	function view() {
		if (Configure::read('AppSettings.cache') == 'on') {
            $this->cacheAction = 60 * 60 * 24 * 3; // Cache for 3 days
        }

        $slug = $this->params['slug'];

        $event = $this->WildEvent->findBySlugAndDraft($slug, 0);

		if (empty($event)) {
			return $this->do404();
		}
        
        // Post title
        $this->pageTitle = $event[$this->modelClass]['title'];
        
        if (isset($this->params['requested'])) {
            return $event;
        }

        $this->set(array('event' => $event));
	}
	
	function wf_delete($id = null) {
		if (!$id) {
			$message = __('Invalid Event', true);
		}
		
		if($this->WildEvent->delete($id)) {
			$message = __('Event has been Deleted', true);
			$msgClass = "message";
		} else {
			$message = __('Unable to delete Event', true);
			$msgClass = "error";
		}
		$this->Session->setFlash($message, 'default', array('class' => $msgClass));
		return $this->redirect(array('action' => 'index', 'controller' => 'wild_events'));
	}
	
	 
    
}
