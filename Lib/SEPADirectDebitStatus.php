<?php

namespace devilcius\SDDGeneratorBundle\Lib;

use devilcius\SDDGeneratorBundle\Entity\DebitTransaction;
use \SimpleXMLElement as SimpleXMLElement;
use Symfony\Component\Translation\Translator;

/**
 * Description of SEPADirectDebitStatus
 *
 * @author Marcos Peña
 */
class SEPADirectDebitStatus
{

    private $xmlDocument;
    private $transactions = array();
    private $translator;

    /**
     *
     * @param string $xmlContent
     */
    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function loadFile($xmlContent)
    {
        $this->xmlDocument = new SimpleXMLElement($xmlContent);
        //register namespace to perform xqueries
        foreach ($this->xmlDocument->getDocNamespaces() as $strPrefix => $strNamespace) {
            if (strlen($strPrefix) == 0) {
                $strPrefix = "a"; //Assign an arbitrary namespace prefix.
            }
            $this->xmlDocument->registerXPathNamespace($strPrefix, $strNamespace);
        }
    }

    public function getTransactions()
    {
        if ($this->xmlDocument === null) {
            throw new Exception("XML file not loaded");
        }
        $transactions = $this->xmlDocument->xpath('//a:TxInfAndSts');

        foreach ($transactions as $transaction) {
            $debitTransaction = new DebitTransaction();
            $debitTransaction->setOriginalIdentification($transaction->OrgnlInstrId);
            $debitTransaction->setStatus($transaction->TxSts);
            $reasons = array();
            foreach ($transaction->StsRsnInf->Rsn as $reason) {
                array_push($reasons, $this->translator->trans($reason->Cd, [], 'devilciusSDDGeneratorBundle', 'es'));
            }
            $debitTransaction->setReasons($reasons);
            array_push($this->transactions, $debitTransaction);
        }

        return $this->transactions;
    }

}
