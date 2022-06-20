/**
* Only show products in the same sub categories in the related products area
*
* @param $terms - Terms currently being passed through
* @param $product_id - Product ID of related products request
* @return $terms/$subcategories - Terms to be included in related products query
*/
function blz_filter_related_products_subcats_only($terms, $product_id) {
    // Check to see if this product has only one category ticked
	$prodterms = get_the_terms($product_id, 'product_cat');
	if (count($prodterms) === 1) {
		return $terms;
	}
    
    // Loop through the product categories and remove parent categories
	$subcategories = array();
	foreach ($prodterms as $k => $prodterm) {
		if ($prodterm->parent === 0) {
			unset($prodterms[$k]);
		} else {
			$subcategories[] = $prodterm->term_id;
		}
	}
	return $subcategories;
}
add_filter( 'woocommerce_get_related_product_cat_terms', 'blz_filter_related_products_subcats_only', 20, 2 );
