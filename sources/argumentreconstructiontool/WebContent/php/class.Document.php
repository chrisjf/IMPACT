<?php
/**
  This is the document class
  @constructor
  @since 19 September 2012
*/
class Document extends DbItem{

  function __construct($data = false, $db = false){
    parent::__construct($data, $db);
  }

  /**
    Returns the unique identifier of objects of this type for storage in the storage mechanism. Is sort of a surrogate for a constant, that won't work in the superclass of this class.
    @retval string The storage ID
   */
  public static function getStorageID(){ 
    return "ART_documents";
  }

  /**
    There are three options when saving a document: creating a new one, saving a new version of an existing document or updating an existing version of a document.
   */
  public function save(){
    //if there is no first_id, there is apparently no version so we have to make a new document
    if(!isset($this->data['first_id'])){
      return $this->createNewDocument();
    } else if($this->isAnnotated()){ //Perform check at this point to have up-to-date information about annotation
      return $this->createNewVersion();
    } else {
      return $this->updateVersion();
    }
  }

  /**
    Checks whether this document is annotated or not.
    @retval boolean True when annotated, false otherwise
   */
   function isAnnotated(){
     //^$db = new Database();
     $arConditions = array(
         'document_id' => $this->getID()
         );
     $result = $this->db->select(textSection::getStorageID(), $arConditions);
     return (bool) count($result);
       //$annotationQuery = "SELECT * FROM ART_text_sections WHERE `document_id` = ".$only_row['id'];
   }

  /**
    Save a brand new document
    @retval int/boolean The ID of the just-saved element (especially useful when adding a new document, of which the ID is not known by definition), or false when the create failed.
  */
  protected function createNewDocument(){
    $arFieldValues = array();
    $arFieldValues['title'] = $this->data["title"];
    $arFieldValues['text'] = $this->data["text"];
    $arFieldValues['url'] = $this->data["url"];
    $arFieldValues['version'] = 1;
    //^$db = new Database();
    $document_id = $this->db->insert($this->getStorageID(), $arFieldValues);
		if(!$document_id || intval($document_id) < 1){
      show_error("Creating document failed");
    }
    //update first ID
    $arFieldValues['first_id'] = $document_id;
    $arConditions['id'] = $document_id;
    $document_id2 = $this->db->update($this->getStorageID(), $arFieldValues, $arConditions);
    if($document_id == $document_id2){
      return $document_id;
    } else {
      show_error("Creating document failed");
    }
  }

  /**
   * Save new version of the the document, and save the title in the document 
   * with first ID because that's the only title used.
   * @retval int/boolean The ID of the just-saved element. An error is shown 
   * when the document could not be saved.
   **/
  protected function createNewVersion(){
    $arFieldValues = array();
    $arFieldValues['title'] = $this->data["title"]; //not necessary for the current implementation, only title of doc with first ID is used
    $arFieldValues['text'] = $this->data["text"];
    $arFieldValues['url'] = $this->data["url"];
    $arFieldValues['version'] = $this->data["version"] + 1;
    $arFieldValues['first_id'] = $this->data["first_id"];
    //^$db = new Database();
    $document_id = $this->db->insert($this->getStorageID(), $arFieldValues);
    $first_id = $this->db->update($this->getStorageID(), 
      array('title' => $this->data['title']),
      array('first_id' => $this->data['first_id']));
		if($document_id && intval($document_id) > 0 && $first_id){
			return $document_id;
		} else {
      show_error("Creating new version of document failed");
    }
  }

  /**
    Update the document version, without making a new one.
    @retval boolean True if the save succeeded. Throws an error and returns
    false when something went wrong.
  */
  protected function updateVersion(){
    $arFieldValues = array();
    $arFieldValues['title'] = $this->data["title"];
    $arFieldValues['text'] = $this->data["text"];
    $arFieldValues['url'] = $this->data["url"];
    $arConditions = array('id' => $this->getID());
    //^$db = new Database();
    $success = $this->db->update($this->getStorageID(), $arFieldValues, $arConditions);
    if($success){
      return $this->getID();
    } else {
      show_error("Failed to update document");
      return false;
    }
  }
}