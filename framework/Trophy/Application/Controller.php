<?php
namespace Trophy\Application;

use Trophy\Controller\BaseController;
use Trophy\Utils\Template;
use Trophy\Export\Export;
use NoCSRF;
use Trophy\Utils\Login;

/**
 * Main Controller
 *
 * Includes the core screens needed for a contest
 */
class Controller extends BaseController
{
    protected $template;

    public function __construct()
    {
        session_start();
        $this->template = new Template;
        parent::__construct();
    }

    /**
     * Default home/landing page
     * Will output page based on config setting (splash, closed or enter)
     */
    public function index()
    {
        $this->template->setVar('title', $this->config->title);
        $this->template->setVar('token', NoCSRF::generate('csrf_token'));
        $html = $this->template->process($this->config->theme, $this->config->index);
        $this->template->output($html);
    }

    /**
     * Enter/Form page
     *
     * @param array $messages
     */
    public function enter($messages = array())
    {
        $template = 'enter';
        $this->template->setVar('title', $this->config->title);

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $form = new Form;
            $response = $form->save($_POST);

            if (!empty($response)) {
                $this->template->setVar('token', NoCSRF::generate('csrf_token'));
                $this->template->setVar('messages', $response);
            } else {
                $template = 'thanks';
            }
        } else {
            $this->template->setVar('token', NoCSRF::generate('csrf_token'));
        }

        $html = $html = $this->template->process($this->config->theme, $template);
        $this->template->output($html);
    }

    /**
     * Terms and Conditions Page
     */
    public function terms()
    {
        // TODO: Add title to config for standard pages
        $this->template->setVar('title', $this->config->title);
        $html = $this->template->process($this->config->theme, 'terms');
        $this->template->output($html);
    }

    /**
     * Privacy Page
     */
    public function privacy()
    {
        $this->template->setVar('title', $this->config->title);
        $html = $this->template->process($this->config->theme, 'privacy');
        $this->template->output($html);
    }

    /**
     * CSV Download page
     *
     * @param string $format    Output to screen or CSV download
     */
    public function export($format = 'CSV')
    {
        // HTTP Authentication
        $login = new Login;
        $login->authenticate();

        // Get the data and fields
        $form = new Form;
        $data = $form->export();
        $fields = $form->fields();

        // Get the format object and print out the result
        $export = new Export;
        $formatObject = $export->getObject('Format' . ucfirst($format));

        if (!empty($formatObject)) {
            $formatObject->export($fields, $data);
        }
    }

    /* -----------------------------------------------------------
     * Add any custom pages/controller actions/methods below
     * ----------------------------------------------------------- */
}
