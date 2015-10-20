<?php
namespace devilcius\SDDGeneratorBundle\Entity;

/**
 * Description of DebitTransaction
 *
 * @author Marcos Peña
 */
class DebitTransaction
{
    protected $originalIdentification;
    protected $status;
    protected $reasons = array();
    
    public function getOriginalIdentification()
    {
        return $this->originalIdentification;
    }
    
    public function setOriginalIdentification($originalIdentification)
    {
        $this->originalIdentification = $originalIdentification;
        
        return $this;
    }
    
    public function getStatus()
    {
        return $this->status;
    }
    
    public function setStatus($status)
    {
        $this->status = $status;
        
        return $this;
    }
    
    public function getReasons()
    {
        return $this->reasons;
    }
    
    public function setReasons($reasons)
    {
        $this->reasons = $reasons;
        
        return $this;
    }
}
