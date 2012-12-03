<?php

define("URI_LOG_FILE", "uri.log"); 

log_message(URI_LOG_FILE, "included uri.php.");
/**
 * URI
 * Helper class to work with delimiter-separated uri's 
 **/
class URI{
	private $index = 0;
	private $delimiter;
	private $uri;
	
	public function __construct($uri_string, $delimiter = "/"){
		$this->delimiter = $delimiter;
		$this->uri = $this->make_uniform(explode($delimiter, $uri_string));
	}

	// make sure all uri's are of form:
	// /firstElem/secondElem/../lastElem
	private function make_uniform($ar){
		if($ar[0] == "") array_shift($ar);
		if($ar[sizeof($ar)-1] == "") array_pop($ar);
		return $ar;
	}
	
	/**
	 * valid()
	 * @return bool
	 * Returns true if uri is a
	 * valid delimiter-separated uri
	 **/
	public function valid(){
	   log_message(URI_LOG_FILE, "check uri [".$this."]");
	   return count($this->uri) > 0;
	}

	/**
	 * reset()
	 * Resets the current element
	 **/
	public function reset(){
		$this->index = 0;
	}

	/**
	 * end()
	 * @return bool
	 * Returns true if all elements
	 * were retrieved
	 **/
	public function end(){
		return $this->index == sizeof($this->uri);
	}
	
	/**
	 * begin()
	 * @return bool
	 * Returns true if no elements
	 * were retrieved yet
	 **/
	public function begin(){
		return $this->index == 0;
	}

	/**
	 * current()
	 * @return mixed
	 * Returns the current element
	 **/
	public function current(){
		if( ! $this->begin() )
			return $this->uri[($this->index-1)];
		else
			return $this->uri[$this->index];
	}

	/**
	 * next()
	 * @return mixed
	 * Returns the next element or 
	 * false if the last element has 
	 * been reached.
	 * It also increases the internal
	 * counter, causing the next call
	 * to next() to return the element
	 * after this element.
	 **/
	public function next(){
		if( ! $this->end() )
			return $this->uri[$this->index++];
		else
			return false;
	}
	
	/**
	 * peek()
	 * @return mixed
	 * Returns the next element or 
	 * false if the last element has 
	 * been reached.
	 * Does not increase the internal
	 * counter like next().
	 **/
	public function peek(){
		if( ! $this->end() )
			return $this->uri[$this->index];
		else
			return false;
		
	}
	
	public function nextInt(){
		$peek = $this->peek();
		if($peek == "0" || intval($peek) > 0)
			return intval($this->next());
		else
			return false;
	}

	public function __toString(){
		return implode($this->delimiter, $this->uri);
	}

	public function toArray(){
		return $this->uri;
	}
}
?>