<?php namespace Sanatorium\Typehead\Controllers\Frontend;

use Cache;
use DB;
use Platform\Foundation\Controllers\Controller;
use Sanatorium\Shop\Repositories\Product\ProductRepositoryInterface;

class TypeheadController extends Controller {

	/**
	 * Constructor.
	 *
	 * @param  \Sanatorium\Shop\Repositories\Product\ProductRepositoryInterface  $products
	 * @return void
	 */
	public function __construct(ProductRepositoryInterface $products)
	{
		parent::__construct();

		$this->products = $products;
	}


	public function products($minutes = 60)
	{
		return Cache::remember('sanatorium.typehead.products', $minutes, function() 
		{
			return $this->getProducts();
		    
		});
		
	}

	public function productsLive()
	{
		return $this->getProducts();
	}

	public function getProducts($take = 10)
	{
		if ( request()->has( trans('sanatorium/shop::general.search.input') ) ) {
			// If search word is specified, narrow the selection
			$query = request()->get( trans('sanatorium/shop::general.search.input') );
			$data = $this->products->search($query)->take($take)->get();
		} else {
			// Else just return all
			$data = $this->products->all();
		}

		$results = [];

		foreach( $data as $element ) {
			$results[] = [
				'title' => $element->product_title,
				'subtitle' => $element->price_vat,
				'image' => $element->coverThumb(60,60),
				'url' => $element->url
			];
		}

		return $results;	
	}
}
