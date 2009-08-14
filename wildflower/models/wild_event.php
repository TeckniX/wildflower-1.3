<?php
class WildEvent extends AppModel {
	
	public $actsAs = array(
	   'Containable',
	   'Slug' => array('separator' => '-', 'overwrite' => false, 'label' => 'title'), 
	   'Tree',
	   'Versionable' => array('title', 'content', 'evtdate')
    );
	
	public $validate = array(
		'title' => array(
				'rule' => array('minLength', 2),
				'message' => 'Title must be at least 2 characters long',
				'required' => true 
			)
		/*,
		'content' => array(
			'rule' => array('minLength', 2),
			'message' => 'Please add some info about this event',
			'required' => true 
		)*/
	);
	
	public static $statusOptions = array(
       '0' => 'Published',
       '1' => 'Draft'
    );
	
	/**
     * Mark an event as a draft
     *
     * @param int $id
     */
    function draft($id) {
        $id = intval($id);
        return $this->query("UPDATE {$this->useTable} SET draft = 1 WHERE id = $id");
    }
	
	/**
     * Publish an event (unmark draft status)
     *
     * @param int $id
     */
    function publish($id) {
        $id = intval($id);
        return $this->query("UPDATE {$this->useTable} SET draft = 0 WHERE id = $id");
    }

	function getStatusOptions() {
        return self::$statusOptions;
    }

}
