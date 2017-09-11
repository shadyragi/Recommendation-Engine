<?php

class ControllerCommonRecommendation extends Controller
{
	public function index()
	{	
		$this->load->language("common/recommendation");

		$this->load->model("recommendation/engine");

		$this->load->model("tool/image");

		$data['footer'] 	   = 		  $this->load->controller('common/footer');

		$data['header'] 	   = 		  $this->load->controller('common/header');

		$result                =          $this->model_recommendation_engine->getRelatedByView();

		$data['product_viewed'] = $result['product_viewed'];
		
		$relatedbyview = [];

		foreach ($result['relatedbyview'] as $key => $value) {
			# code...
			$data["RelatedByView"][] = array(
				
				"image" => $this->model_tool_image->resize($value['image'], 100, 100),

				"name"  => $value['name'],
				
				"price" => $this->tax->calculate($value['price'], $value['tax_class_id']),
				
				"href"  => $this->url->link("product/product", "product_id=".$value['product_id'], true),
				
				"description" => utf8_substr(trim(strip_tags(html_entity_decode($value['description'], ENT_QUOTES, 'UTF-8'))), 0, $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..'
				);
			}
		



		$result2               = $this->model_recommendation_engine->getRelatedByCart();

		$data['product_added'] = $result2['product_added'];

			foreach ($result2['relatedbycart'] as $key => $value) {
			# code...
			$data["RelatedByCart"][] = array(

				"image" => $this->model_tool_image->resize($value['image'], 100, 100),

				"name"  => $value['name'],

				"price" => $this->tax->calculate($value['price'], $value['tax_class_id']),

				"href"  => $this->url->link("product/product", "product_id=".$value['product_id'], true),

				"description" => utf8_substr(trim(strip_tags(html_entity_decode($value['description'], ENT_QUOTES, 'UTF-8'))), 0,

				 $this->config->get('theme_' . $this->config->get('config_theme') . '_product_description_length')) . '..'
				);
			}


		$data['cart_heading'] = $this->language->get("cart_heading");

		$data['view_heading']   = $this->language->get("view_heading");

	

		$this->response->setOutput($this->load->view("common/recommendation", $data));

	}
}

?>