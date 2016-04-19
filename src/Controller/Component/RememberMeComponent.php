<?php

namespace RememberMe\Controller\Component;

use Cake\Controller\Component;
use Cake\Utility\Security;

/**
 * RememberMe component
 */
class RememberMeComponent extends Component {

	/**
	 * Default configuration.
	 *
	 * - `cypherKey` - Random unuqie string to encrypt/decrypt data.
	 *   If not set, default salt value of the application will be used.
	 * - `cookieName` - Name of the cookie.
	 * 
	 * @var array
	 */
	protected $_defaultConfig = [
		'cypherKey' => "17485937564892755682047369192734583655920926",
		'cookieName' => "rememberme",
		'period' => '14 Days'
	];

	/**
	 * Other components
	 * 
	 * @var array
	 */
	public $components = ['Cookie'];

	/**
	 * Initialize config data and properties.
	 *
	 * @param array $config The config data.
	 * @return void
	 */
	public function initialize(array $config) {
		if (!$this->_config['cypherKey']) {
			$this->config('cypherKey', Security::salt());
		}
	}

	/**
	 * Stores data in cookie
	 * 
	 * @param mixes $data Data to store in cookie
	 * @return boolean
	 */
	public function rememberData($data = null) {
		if (empty($data)) {
			return false;
		}

		$encryptedData = Security::cipher($data, $this->config('cypherKey'));
		$this->Cookie->write($this->config('cookieName'), $encryptedData, true, $this->config('period'));
		return true;
	}

	/**
	 * Returns data stored in cookie
	 * 
	 * @return mixed Stored data otherwise false
	 */
	public function getRememberedData() {
		$cookieData = $this->Cookie->read($this->config('cookieName'));
		if (!empty($cookieData)) {
			$data = Security::cipher($cookieData, $this->config('cypherKey'));
			return $data;
		} else {
			return false;
		}
	}

	/**
	 * Removes data
	 * 
	 * @return void
	 */
	public function removeRememberedData() {
		$this->Cookie->delete($this->config('cookieName'));
	}

}
