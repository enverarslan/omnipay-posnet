<?php

namespace Omnipay\Posnet\Message;

class RefundRequest extends PurchaseRequest {

    public function getData() {

        $this->validate('transid', 'amount');
        $currency = $this->getCurrency();
 
        $data['hostLogKey'] = $this->getTransactionId();
        $data['currencyCode'] = $this->currencies[$currency];
        $data['amount'] = $this->getAmountInteger();

        return $data;
    }

}
