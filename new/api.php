<?php


class api extends SecureController {

    public function companies($f3) {
        $company = new Catalog\Company($f3);
        $companies = $company->companies($this->userId());
        $this->getResult(["companies"=>$companies]);
    }

    public function products($f3) {
        try {
            $companyId = $f3->get("POST.company_id");
            $company = new \Catalog\SecureCompany($f3, $companyId, $this->userId());
            $this->getResult(["products"=>$company->productList()]);
        } catch (Exception $e) {
            $this->getResult(["message"=>$e->getMessage()], 1);
        }
    }

    public function orders($f3) {
        $companyId = $f3->get("POST.company_id");
        $company = new \Catalog\SecureCompany($f3, $companyId, $this->userId());
        $this->getResult(["orders"=>$company->orders($companyId)]);
    }

    public function order($f3) {
        try {
            $companyId = $f3->get("POST.company_id");
            $order_id = $f3->get("POST.order_id");
            $company = new \Catalog\SecureCompany($f3, $companyId, $this->userId());
            $this->getResult(["order"=>$company->order($order_id), "company"=>$company->info($companyId)]);
        } catch (Exception $e) {
            $this->getResult(["message"=>$e->getMessage()], 1);
        }
    }


}