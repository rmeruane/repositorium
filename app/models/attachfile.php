<?php
class Attachfile extends AppModel {
	var $name = 'Attachfile';
	var $displayField = 'filename';

	var $belongsTo = array(
		'Document' => array(
			'className' => 'Document',
			'foreignKey' => 'document_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function fallar(){
		print("fail");
	}
	
	function findDocumentsByFilename($repo_id = null, $words = array()){
		if(is_null($repo_id)) {
			return null;
		}
		$docs = array();
		foreach ($words as $word) {
			$tmp = $this->find('all', array(
			  		'conditions' => array(
						'Attachfile.filename LIKE ' => '%'.$word.'%',
						'Document.repository_id' => $repo_id
					),
			  		'fields' => array('Attachfile.document_id')
				)
			);
				
			$hola = array();
			foreach($tmp as $t) {
				$hola[] = $t['Attachfile']['document_id'];
			}
			$docs[] = $hola;
		}
		if(count($docs) > 0) {
			$res = $docs[0];
			for ($i = 1; $i < count($docs); $i++) {
				$res = array_intersect($res, $docs[$i]);
			}
		} else {
			/*$res = $this->find('all', array(
				'conditions' => array('Document.repository_id' => $repo_id),
		  		'fields' => 'DISTINCT Tag.document_id',
				)
			);*/
		}
	
		return $res;
	}
	
}
?>