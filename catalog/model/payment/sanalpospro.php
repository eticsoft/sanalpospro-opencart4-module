<?php
namespace Opencart\Catalog\Model\Extension\Sanalpospro\Payment;

class Sanalpospro extends \Opencart\System\Engine\Model
{
	public function getMethods()
	{
		$this->load->language('extension/sanalpospro/payment/sanalpospro');

		$method_data = array(
			'code'       => 'sanalpospro',
			'name'      => $this->language->get('text_title'),
			'option'      =>  [
				'sanalpospro' => [
					'code' => 'sanalpospro.sanalpospro',
					'name' => $this->language->get('text_title')
				]
			],
			'sort_order' => 1
		);
		return $method_data;
	}

	public function getMethod()
	{
		$this->load->language('extension/sanalpospro/payment/sanalpospro');

		$method_data = [
			'code'       => 'sanalpospro',
			'title'      => $this->language->get('heading_title'),
			'sort_order' => 1
		];

		return $method_data;
	}
}
