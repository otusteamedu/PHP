<?php

namespace Catalog;

class Company {
    public function __construct($f3) {
        $this->f3 = $f3;
        $this->db = $f3->get("DB");
    }

    public function companies($userId) {
        $sql = "SELECT c.id, c.name, c.address, c.instagram as company_url, (select count(*) from orders o where o.company_id = c.id and o.state = 0) as open_orders  FROM catalogercompany cc
                    LEFT JOIN companies c ON c.id = cc.company_id
                WHERE cataloger_id=:id";
        $companies = $this->db->exec($sql, ["id"=>$userId]);
        return $companies;
    }

    public function products($companyId) {
        $sql = "SELECT * from product where category in (
                    select id from category where company_id = :id);";

        $sql = "SELECT * FROM product WHERE company_id = :id ORDER BY id DESC;";
        $products = $this->db->exec($sql, ["id"=>$companyId]);

        $categories = $this->categoriesForProducts($companyId);
        foreach($products as &$product) {
            $product["categories"] = [];
            $images = [];
            $images[] = [
                "image"=>$product["image"],
                "thumbnail"=>$product["thumbnail"]
            ];
            if(isset($categories[$product["id"]])) {
                $product["categories"] = $categories[$product["id"]];
            }
        }
        return $products;
    }

    public function product($companyId, $productId) {
        $sql = "SELECT * from product where id = :id AND company_id = :company_id;";
        $products = $this->db->exec($sql, ["id"=>$productId, "company_id"=>$companyId]);
        if(isset($products) && count($products) == 1) {
            $product = $products[0];
            $product["categories"] = $this->categoriesByProduct($productId);
            $product["images"] = [];
            $product["images"][] = [
                "image"=>$product["image"],
                "thumbnail"=>$product["thumbnail"]
            ];
            return $product;
        } else {
            throw new \Exception("Продукт не найден");
        }
    }

}