<?php
namespace Trophy\Application;

use Trophy\Controller\BaseController;
use Trophy\Utils\Template;
use Trophy\Export\Export;
use Trophy\Utils\NoCSRF;
use Trophy\Utils\Login;

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
    function index()
    {
        $this->template->set_var('title', $this->config->title);
        $this->template->set_var('token', NoCSRF::generate('csrf_token'));
        $html = $this->template->process($this->config->theme, $this->config->index);
        $this->template->output($html);
    }

    /**
     * Enter/Form page
     */
    function enter($messages = array())
    {
        $template = 'enter';
        $this->template->set_var('title', $this->config->title);

        if($_SERVER['REQUEST_METHOD'] == "POST") {
            $form = new Form;
            $response = $form->save($_POST, $this->config->db_table, $this->config->form_exclude_fields);
    
            if(!empty($response))
            {
                $this->template->set_var('token', NoCSRF::generate('csrf_token'));
                $this->template->set_var('messages', $response);
            }
            else
            {
                $template = 'thanks';
            }
        } else {
            $this->template->set_var('token', NoCSRF::generate('csrf_token'));
        }
        
        $html = $html = $this->template->process($this->config->theme, $template);
        $this->template->output($html);
    }

    /**
     * Terms and Conditions Page
     */
    function terms()
    {
        // TODO: Add title to config for standard pages
        $this->template->set_var('title', $this->config->title);
        $html = $this->template->process($this->config->theme, 'terms');
        $this->template->output($html); 
    }

    /**
     * Privacy Page
     */
    function privacy()
    {
        $this->template->set_var('title', $this->config->title);
        $html = $this->template->process($this->config->theme, 'privacy');
        $this->template->output($html); 
    }

    /**
     * Secure CSV Download page
     * @param string $format Out put to screen or CSV download
     */
    function secure($format = 'Csv')
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

        if(!empty($formatObject))
        {
            $formatObject->export($fields, $data);
        }
    }


    /* -----------------------------------------------------------
     * Add any custom pages/controller actions/methods below
     * ----------------------------------------------------------- */

}