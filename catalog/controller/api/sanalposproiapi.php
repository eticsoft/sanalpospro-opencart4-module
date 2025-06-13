<?php

namespace Opencart\Catalog\Controller\Extension\Sanalpospro\Api;

include_once DIR_EXTENSION . 'sanalpospro/catalog/controller/vendor/include.php';

use Eticsoft\Paythor\Sanalpospro\InternalApi;
use Eticsoft\Paythor\Sanalpospro\EticTools;

class Sanalposproiapi extends \Opencart\System\Engine\Controller
{
    public function index()
    {
        $action = EticTools::getVal('action', false);
        if (isset($action) && $action == 'orderConfirmation') {
            $this->orderConfirmation();
            return;
        }
        if (!isset($_SERVER['HTTP_REFERER']) || parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST) !== $_SERVER['HTTP_HOST']) {
            header('Content-Type: application/json');
            header('HTTP/1.0 403 Forbidden');
            die(json_encode(['status' => 'error', 'message' => 'Access denied 2']));
        }
        $this->load->model('setting/setting');
        $settings = $this->model_setting_setting;
        $api = InternalApi::getInstance()->setSettings($settings)->setController($this)->run();
        header('Content-Type: application/json');
        die(json_encode($api->response));
    }

    private function orderConfirmation()
    {
        $nonce = EticTools::getVal('nonce', false);
        $p_id = EticTools::getVal('p_id', false);
        if (!$nonce || !$p_id) {
            header('Content-Type: application/json');
            header('HTTP/1.0 403 Forbidden');
            die(json_encode(['status' => 'error', 'message' => 'Access denied 1']));
        }
        $this->load->model('setting/setting');
        $settings = $this->model_setting_setting;
        $api = InternalApi::getInstance()->setSettings($settings)->setController($this);
        $api->action = 'confirmOrder';
        $api->xfvv = $nonce;
        $api->params['process_token'] = $p_id;
        $api->call();

        if (isset($api->response["status"]) && isset($api->response["data"]["redirect_url"])) {
            header('Location: ' . $api->response["data"]["redirect_url"]);
            exit;
        }

        header('Content-Type: application/json');
        die(json_encode($api->response));
    }
}
