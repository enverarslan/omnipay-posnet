<?php

namespace Omnipay\Posnet\Message;

class VoidRequest extends PurchaseRequest {

    public function getData() {

        $this->validate('transid');
        
        $data['transaction'] = "sale";
        $data['hostLogKey'] = $this->getTrans();
        $data['authCode'] = $this->getAuthCode();

        return $data;
    }

}
