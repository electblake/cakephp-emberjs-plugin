<?php
App::uses('Serializers','Emberjs.Lib');
class EmberBehavior extends ModelBehavior {





	/**
	 * SerializerBehavior::setup()
	 * 
	 * @param mixed $Model
	 * @param mixed $settings
	 * @return void
	 */
	public function setup(Model $Model, $settings = array()) {
	//	if (!isset($this->settings[$Model->alias])) {
			$this->settings[$Model->alias] = false;
		//}
	//	$this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings);
		
	}


	/**
	 * SerializerBehavior::serializer()
	 * 
	 * @param mixed $Model
	 * @param bool $status
	 * @return void
	 */
	public function serialized(Model $Model,$config = false) {
//		$args = func_get_args();
	//	$contain = call_user_func_array('am', array_slice($args, 1));
		$this->settings[$Model->alias]	 = $config;		
	
	}	
	
	/**
	 * SerializerBehavior::beforeFind()
	 * 
	 * @param mixed $Model
	 * @param mixed $query
	 * @return
	 */
	public function beforeFind(Model $Model, $query) {
	
		if (isset($query['serialized'])){

			$this->settings[$Model->alias] = $query['serialized'];
						

		}
		return $query;
	}	

	/**
	 * SerializerBehavior::afterFind()
	 * 
	 * @param mixed $Model
	 * @param mixed $results
	 * @param mixed $primary
	 * @return
	 */
	public function afterFind(Model $Model, $results, $primary) {
		if(is_array($this->settings[$Model->alias]) ){
			$this->settings[$Model->alias]['model'] = $Model->alias;
			$Serializers =  new Serializers($results,$this->settings[$Model->alias]);
				//return Hash::maxDimensions($results);
			$results = $Serializers->convert();
			
		}
		return $results;
	}	
	
	


}
