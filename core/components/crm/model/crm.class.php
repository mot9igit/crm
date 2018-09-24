<?php 

/**
 * The base class for crm.
 */
class crm {
	/* @var modX $modx */
	public $modx;
	/* @var crmControllerRequest $request */
	protected $request;
	public $initialized = array();
	public $chunks = array();
	/**
	 * @param modX $modx
	 * @param array $config
	 */
	function __construct(modX &$modx, array $config = array()) {
		$this->modx =& $modx;
		$corePath = $this->modx->getOption('crm_core_path', $config, $this->modx->getOption('core_path') . 'components/crm/');
		$assetsUrl = $this->modx->getOption('crm_assets_url', $config, $this->modx->getOption('assets_url') . 'components/crm/');
		$connectorUrl = $assetsUrl . 'connector.php';
		$this->config = array_merge(array(
			'assetsUrl' => $assetsUrl,
			'cssUrl' => $assetsUrl . 'css/',
			'jsUrl' => $assetsUrl . 'js/',
			'imagesUrl' => $assetsUrl . 'images/',
			'connectorUrl' => $connectorUrl,
			'corePath' => $corePath,
			'modelPath' => $corePath . 'model/',
			'chunksPath' => $corePath . 'elements/chunks/',
			'templatesPath' => $corePath . 'elements/templates/',
			'chunkSuffix' => '.chunk.tpl',
			'snippetsPath' => $corePath . 'elements/snippets/',
			'processorsPath' => $corePath . 'processors/'
		), $config);
		$this->modx->addPackage('crm', $this->config['modelPath']);
		$this->modx->lexicon->load('crm:default');
	}
	/**
	 * Initializes crm into different contexts.
	 *
	 * @access public
	 *
	 * @param string $ctx The context to load. Defaults to web.
	 */
	public function initialize($ctx = 'web') {
		switch ($ctx) {
			case 'mgr':
				if (!$this->modx->loadClass('crm.request.crmControllerRequest', $this->config['modelPath'], true, true)) {
					return 'Could not load controller request handler.';
				}
				$this->request = new crmControllerRequest($this);
				return $this->request->handleRequest();
				break;
			case 'web':
				break;
			default:
				/* if you wanted to do any generic frontend stuff here.
				 * For example, if you have a lot of snippets but common code
				 * in them all at the beginning, you could put it here and just
				 * call $crm->initialize($modx->context->get('key'));
				 * which would run this.
				 */
				break;
		}
		return true;
	}
	/**
	 * Gets a Chunk and caches it; also falls back to file-based templates
	 * for easier debugging.
	 *
	 * @access public
	 *
	 * @param string $name The name of the Chunk
	 * @param array $properties The properties for the Chunk
	 *
	 * @return string The processed content of the Chunk
	 */
	public function getChunk($name, array $properties = array()) {
		$chunk = null;
		if (!isset($this->chunks[$name])) {
			$chunk = $this->modx->getObject('modChunk', array('name' => $name), true);
			if (empty($chunk)) {
				$chunk = $this->_getTplChunk($name, $this->config['chunkSuffix']);
				if ($chunk == false) {
					return false;
				}
			}
			$this->chunks[$name] = $chunk->getContent();
		}
		else {
			$o = $this->chunks[$name];
			$chunk = $this->modx->newObject('modChunk');
			$chunk->setContent($o);
		}
		$chunk->setCacheable(false);
		return $chunk->process($properties);
	}
	/**
	 * Returns a modChunk object from a template file.
	 *
	 * @access private
	 *
	 * @param string $name The name of the Chunk. Will parse to name.chunk.tpl by default.
	 * @param string $suffix The suffix to add to the chunk filename.
	 *
	 * @return modChunk/boolean Returns the modChunk object if found, otherwise
	 * false.
	 */
	private function _getTplChunk($name, $suffix = '.chunk.tpl') {
		$chunk = false;
		$f = $this->config['chunksPath'] . strtolower($name) . $suffix;
		if (file_exists($f)) {
			$o = file_get_contents($f);
			$chunk = $this->modx->newObject('modChunk');
			$chunk->set('name', $name);
			$chunk->setContent($o);
		}
		return $chunk;
	}

    /**
     * Function for sending email
     *
     * @param string $email
     * @param string $subject
     * @param string $body
     *
     * @return void
     */
    public function sendEmail($email, $subject, $body = '')
    {
        $this->modx->getParser()->processElementTags('', $body, true, false, '[[', ']]', array(), 10);
        $this->modx->getParser()->processElementTags('', $body, true, true, '[[', ']]', array(), 10);

        /** @var modPHPMailer $mail */
        $mail = $this->modx->getService('mail', 'mail.modPHPMailer');
        $mail->setHTML(true);

        $mail->address('to', trim($email));
        $mail->set(modMail::MAIL_SUBJECT, trim($subject));
        $mail->set(modMail::MAIL_BODY, $body);
        $mail->set(modMail::MAIL_FROM, $this->modx->getOption('emailsender'));
        $mail->set(modMail::MAIL_FROM_NAME, $this->modx->getOption('site_name'));
        if (!$mail->send()) {
            $this->modx->log(modX::LOG_LEVEL_ERROR,
                'An error occurred while trying to send the email: ' . $mail->mailer->ErrorInfo
            );
        }
        $mail->reset();
    }

    /**
     * Shorthand for the call of processor
     *
     * @access public
     *
     * @param string $action Path to processor
     * @param array $data Data to be transmitted to the processor
     *
     * @return mixed The result of the processor
     */
    public function runProcessor($action = '', $data = array())
    {
        if (empty($action)) {
            return false;
        }
        $this->modx->error->reset();
        $processorsPath = !empty($this->config['processorsPath'])
            ? $this->config['processorsPath']
            : MODX_CORE_PATH . 'components/crm/processors/';

        return $this->modx->runProcessor($action, $data, array(
            'processors_path' => $processorsPath,
        ));
    }
}