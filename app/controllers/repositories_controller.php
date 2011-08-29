<?php
/**
 * 
 * This code NEEEEDS to be refactored (someday)
 * @author mquezada
 *
 */

class RepositoriesController extends AppController {
	/**
	 * SessionComponent
	 * @var SessionComponent
	 */
	var $Session;
	
	/**
	 * RepositoryModel
	 * @var Repository
	 */
	var $Repository;
	
	var $name = 'Repositories';
	
	function index($repo_url = null) {	
		if(is_null($repo_url)) {
			$this->redirect('/');
		}
		
		$result = $this->_set_repo($data = compact('repo_url'));
		if($result[0]) {
			$repository = $result[1];
			$this->set(compact('repository'));
		} else {
			$this->e404();
		}		
	}
	
	/**
	 * 
	 * set repository data in session, by id or url, if exists
	 * @param array $data
	 * @return array array( boolean: status, array: data | null)
	 */
	function _set_repo($data = array()) {
		if(empty($data)) {
			return array(false, null);
		}
		
		if(isset($data['repo_url'])) {
			$repo = $this->Repository->find('first', array(
				'conditions' => array(
					'Repository.url' => $data['repo_url']
				),
				'recursive' => -1,
			));
		} elseif(isset($data['repo_id'])) {
			$repo = $this->Repository->find('first', array(
				'conditions' => array(
					'Repository.id' => $data['repo_id']
				),
				'recursive' => -1,
			));
		}
		
		if(!empty($repo)) {
			$this->setRepositorySession($repo);			
			return array(true, $repo);
		} else {
			return array(false, null);
		}
					
	}
	
	function set_repository_by_url($repo_url = null) {
		if(is_null($repo_url)) {		
			$this->e404();
		}
		
		$result = $this->_set_repo($data = compact('repo_url'));		
		if($result[0]) {
			$this->redirect(array('action' => 'index', $result[1]['Repository']['url']));
		} else {
			$this->e404();
		}		
	}
	
	function set_repository_by_id($repo_id = null) {
		if(is_null($repo_id)) {
			$this->e404();
		}
		$result = $this->_set_repo(compact('repo_id'));		
		if($result[0]) {
			$this->redirect(array('action' => 'index', $result[1]['Repository']['url']));
		} else {
			$this->e404();
		}		
	}
	
	function create() {
		if($this->getConnectedUser() == $this->anonymous)
			$this->redirect(array('controller' => 'login'));
		
		if(!empty($this->data)) {
			$user = $this->getConnectedUser();
			$this->data['Repository']['user_id'] = $user['User']['id'];
			$this->Repository->set($this->data);
			
			if($this->Repository->validates()) {
				$repository = $this->Repository->createNewRepository($this->data, $user);
				if(is_null($repository)) {
					$this->Session->setFlash('An error occurred creating the repository. Please, blame the developer');
					$this->redirect('/');
				}
				
				$this->_make_user_expert();
				$this->set_repository_by_url($repository['Repository']['url']);				
			} else {
				$this->Session->setFlash($this->Repository->invalidFields(), 'flash_errors');
			}	
		}		
	}

	
	function _make_user_expert() {
		$this->Session->write('User.esExperto', true);
	}
}