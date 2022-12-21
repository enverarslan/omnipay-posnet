<?php

namespace Omnipay\Posnet\Message;

use DOMDocument;
use Omnipay\Common\Message\AbstractRequest;

class PurchaseRequest extends AbstractRequest {
    
    protected $endpoint = '';
    protected $endpoints = array(
        'test'       => 'https://setmpos.ykb.com/PosnetWebService/XML',
        'yapikredi'   => 'https://www.posnet.ykb.com/PosnetWebService/XML',
        //'3d'         => 'https://www.posnet.ykb.com/3DSWebService/YKBPaymentService'
    );

    public function getData() {

        $this->validate('card');
        $this->getCard()->validate();

        $data['orderID'] = $this->getOrderId();
        $data['currencyCode'] = $this->getCurrency();
        $data['installment'] = $this->getInstallment();
        
        $data['extraPoint'] = $this->getExtraPoint();
        $data['multiplePoint'] = $this->getMultiplePoint();
        
        $data['amount'] = $this->getAmountInteger();
        $data['ccno'] = $this->getCard()->getNumber();
        $data['expDate'] = $this->getCard()->getExpiryDate('ym');
        $data["cvc"] = $this->getCard()->getCvv();
 
        return $data;
    }

    public function sendData($data) {
        $document = new DOMDocument('1.0', 'UTF-8');
        $root = $document->createElement('posnetRequest');

        $root->appendChild($document->createElement('mid', $this->getMerchantId()));
        $root->appendChild($document->createElement('tid', $this->getTerminalId()));

        $ossRequest = $document->createElement($this->getType());
        foreach ($data as $id => $value) {
            $ossRequest->appendChild($document->createElement($id, $value));
        }

        $root->appendChild($ossRequest);

        $document->appendChild($root);

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        );

        $data = "xmldata=".$document->saveXML();

        $httpResponse = $this->httpClient->request('POST', $this->getEndPoint(), $headers, $data);

        return $this->response = new Response($this, $httpResponse->getBody());
    }
    
    public function getMerchantId() {
        return $this->getParameter('merchantId');
    }

    public function setMerchantId($value) {
        return $this->setParameter('merchantId', $value);
    }

    public function getTerminalId() {
        return $this->getParameter('terminalId');
    }

    public function setTerminalId($value) {
        return $this->setParameter('terminalId', $value);
    }

    public function getInstallment() {
        return $this->getParameter('installment');
    }

    public function setInstallment($value) {
        return $this->setParameter('installment', $value);
    }

    public function getType() {
        return $this->getParameter('type');
    }

    public function setType($value) {
        return $this->setParameter('type', $value);
    }

    public function getTransId() {
        return $this->getParameter('transId');
    }

    public function setTransId($value) {
        return $this->setParameter('transId', $value);
    }

    public function getOrderId() {
        return $this->getParameter('orderid');
    }

    public function setOrderId($value) {
        return $this->setParameter('orderid', $value);
    }

    public function getExtraPoint() {
        return $this->getParameter('extrapoint');
    }

    public function setExtraPoint($value) {
        return $this->setParameter('extrapoint', $value);
    }

    public function getMultiplePoint() {
        return $this->getParameter('multiplePoint');
    }

    public function setMultiplePoint($value) {
        return $this->setParameter('multiplePoint', $value);
    }

    public function getEndPoint(){
        return $this->endpoints[$this->getTestMode() ? 'test' : $this->getParameter('bank')];
    }

}
