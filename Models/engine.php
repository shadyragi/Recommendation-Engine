<?php

class ModelRecommendationEngine extends Model
{
	public function getRelatedBySearch()
	{
		$this->load->model("account/search");

	}
	public function getRelatedByView()
	{
		$this->load->model("catalog/view");

		$this->load->model("catalog/product");

		$data = [];
		
		if($this->customer->isLogged())
		{
			$id = $this->customer->getId();
		}

		$result = $this->model_catalog_view->getViewByCustomerId($id);

		if($result)
		{
			$data['product_viewed'] = $this->model_catalog_product->getProduct($result['product_id']);
		
			$data["relatedbyview"] = $this->model_catalog_product->getRelatedProducts($result['product_id']);
		
			return $data;
		}
		return false;

	}
	public function getRelatedByCart()
	{
		$data = [];
		
		$this->load->model("checkout/cart");
		
		$this->load->model("catalog/product");
		
		if($this->customer->isLogged())
		{
			$id = $this->customer->getId();
		}
		
		$product = $this->model_checkout_cart->getLatestItem($id);
		
		if($product)
		{
		
			$data['product_added'] = $this->model_catalog_product->getProduct($product['product_id']);

			$data["relatedbycart"] = $this->model_catalog_product->getRelatedProducts($product['product_id']);
		
			return $data;
		
		}
		return false;
		
	}
}

?>