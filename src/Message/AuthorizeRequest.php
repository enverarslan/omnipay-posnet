<?php

namespace Omnipay\Posnet\Message;

class AuthorizeRequest extends PurchaseRequest {

    public function getData() {

        $this->validate('card');
        $this->getCard()->validate();
        $currency = $this->getCurrency();

        $data['orderID'] = $this->getOrderId();
        $data['currencyCode'] = $this->currencies[$currency];
        $data['installment'] = $this->getInstallment();
        
        $data['extraPoint'] = $this->getExtraPoint();
        $data['multiplePoint'] = $this->getMultiplePoint();
        
        $data['amount'] = $this->getAmountInteger();
        $data['ccno'] = $this->getCard()->getNumber();
        $data['expDate'] = $this->getCard()->getExpiryDate('ym');
        $data["cvc"] = $this->getCard()->getCvv();
 
        return $data;
    }

}
