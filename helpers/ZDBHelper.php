<?php 
class ZDBHelper{

	
	/**
	 * Initiates a transaction
	 * 
	 * @param db the database object
	 * @return true if success false otherwise 
	 */
	public static function initTransaction( $db ){
		  $query = "BEGIN";
	      $db->setQuery( $query ) ;
	      return  $db->query( $query );
	}
	
	/**
	 * Commit a transaction
	 * 
	 * @param db the database object
	 * @return true if success false otherwise 
	 */
	public static function commit( $db ){
		  $query = "COMMIT";
	      $db->setQuery( $query ) ;
	      return  $db->query( $query );
	}
	
	/**
	 * Rollback a transaction
	 * 
	 * @param db the database object
	 * @return true if success false otherwise 
	 */
	public static function rollBack( $db ){
		  $query = "ROLLBACK";
	      $db->setQuery( $query ) ;
	      return  $db->query( $query );
	}

	
}












