<?php
class JobsController extends AppController{
	public $name ='Jobs';
	
	/*
	 * Index method	
	 */
	 public function index(){
		$options = array(
				'order' => array('Category.name' => 'asc')
		);
		
		//Categories
		$categories = $this->Job->Category->find('all', $options);
		
		$this->set('categories', $categories);
		
		//Query Options
		$options = array(
			'order' => array('Job.created' => 'DESC'),
			'limit' => 10
		);
		
		//Job Info
		$jobs = $this->Job->find('all', $options);
		
		//Title
		$this->set('title_for_layout', 'JobFinds | Welcome');
		
		$this->set('jobs', $jobs);
	 }
	 
	 /*
	 * Browse 	
	 */
	 public function browse($category = null){
		$conditions = array(); 
		
		//Check Keyword Filter
		if($this->request->is('post')){
			if(!empty($this->request->data('keywords'))){
				$conditions[] =  array('OR' => array(
					'Job.title LIKE' => "%" . $this->request->data('keywords') . "%",
					'Job.description LIKE' => "%" . $this->request->data('keywords') . "%"
				));
			}
		}
		
		//State Filter
		if(!empty($this->request->data('state')) && $this->request->data('state') != 'Select State'){
			$conditions[] =  array(
					'Job.state LIKE' => "%" . $this->request->data('state') . "%"
			);
		}
		
		//Category Filter
		if(!empty($this->request->data('category')) && $this->request->data('category') != 'Select Category'){
			$conditions[] =  array(
					'Job.category_id LIKE' => "%" . $this->request->data('category') . "%"
			);
		}
		
		//Category Query Options
		$options = array(
				'order' => array('Category.name' => 'asc')
		);
		
		//Categories
		$categories = $this->Job->Category->find('all', $options);
		
		//Categories
		$this->set('categories', $categories);	
		
		if($category != null){
			$conditions[] =  array(
					'Job.category_id LIKE' => "%" . $category . "%"
			);
		}
		
		//Query Options
		$options = array(
				'order' => array('Job.created' => 'desc'),
				'conditions' => $conditions,
				'limit' => 8
		);
		
		$jobs = $this->Job->find('all', $options);
		
		$this->set('title_for_layout', 'JobFinds | Browse For A Job');
		
		$this->set('jobs', $jobs);
	 }
	 
	 /*
	  * Single jobs
	  */
	  public function view($id){
		if(!$id){
			throw new NotFoundException(__('Invalid job listing'));
		}
		
		$job = $this->Job->findById($id);
		
		if(!$job){
			throw new NotFoundException(__('Invalid job listing'));
		}
		
		//Title
		$this->set('title_for_layout', $job['Job']['title']);
		
		$this->set('job', $job);
	  }

	  /* 
	  * Add 
	  */

	  public function add(){
	  	//Get Categories for select list
		$options = array(
				'order' => array('Category.name' => 'asc')
		);
		//Get Categories
		$categories = $this->Job->Category->find('list', $options);
		//Set Categories
		$this->set('categories', $categories);
		
		//Get types for select list
		$types = $this->Job->Type->find('list');
		//Set Types
		$this->set('types', $types);

	  	if($this->request->is('post')){
	  		$this->Job->create();

	  		//Logged user id 
	  		$this->request->data['Job']['user_id'] = $this->Auth->user('id');

	  		if($this->Job->save($this->request->data)){
	  			$this->Session->setFlash(__('Your job has been added!'));
	  			return $this->redirect(array('action' => 'index'));
	  		}

	  		$this->Session->setFlash(__('Jobs not add!'));

	  	}
	  }

	 /*
	 * Edit 
	 */
	 public function edit($id){
		//Select list
		$options = array(
				'order' => array('Category.name' => 'asc')
		);
		//Categories
		$categories = $this->Job->Category->find('list', $options);
		//Set Categories
		$this->set('categories', $categories);
		
		//Types for select list
		$types = $this->Job->Type->find('list');
		$this->set('types', $types);
		
		if(!$id){
			throw new NotFoundException(__('Invalid job listing'));
		}
		
		$job = $this->Job->findById($id);
		
		if(!$job){
			throw new NotFoundException(__('Invalid job listing'));
		}
	   
		if($this->request->is(array('job', 'put'))){
			$this->Job->id = $id;

			if($this->Job->save($this->request->data)){
				$this->Session->setFlash(__('Your job has been update'));
				return $this->redirect(array('action' => 'index'));
			}
			
			$this->Session->setFlash(__('Jobs not update!'));
		}
		
		if(!$this->request->data){
			$this->request->data = $job;
		}
	}

	/*
	 * Delete
	 */

	 public function delete($id){
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}
	
		if ($this->Job->delete($id)) {
			$this->Session->setFlash(
					__('The job with id: %s has been deleted.', h($id))
			);
			return $this->redirect(array('action' => 'index'));

		}
	}
}