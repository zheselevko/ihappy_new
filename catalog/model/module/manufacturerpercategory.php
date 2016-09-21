<?php
class ModelModuleManufacturerpercategory extends Model {
	
	public function getManufacturersByCategory($category_id) {
		

			$sql = "	SELECT DISTINCT m.manufacturer_id, m.name, m.image FROM oc_manufacturer m LEFT JOIN oc_manufacturer_description md ON (m.manufacturer_id = md.manufacturer_id) LEFT JOIN `oc_product` p ON (m.manufacturer_id = p.manufacturer_id) LEFT JOIN `oc_product_to_category` p2c ON (p.product_id= p2c.product_id)";
			$sql .= "	LEFT JOIN oc_manufacturer_to_store m2s ON (m.manufacturer_id = m2s.manufacturer_id) WHERE m2s.store_id = '0' AND category_id = ". (int)$category_id . " AND md.language_id = '1' GROUP BY m.manufacturer_id ORDER BY m.name ASC";
			
		    
            $query = $this->db->query($sql);

			
			return $query->rows;
			
			
	
	}	
}
?>