<?php

namespace Omnipay\Posnet\Message;

class CaptureRequest extends PurchaseRequest {

    public function getData() {

        $this->validate('transid', 'amount');
        $currency = $this->getCurrency();
 
        $data['hostLogKey'] = $this->getTransId();
        $data['currencyCode'] = $this->currencies[$currency];
        $data['amount'] = $this->getAmountInteger();
        $data['installment'] = $this->getInstallment();

        return $data;
    }

}
