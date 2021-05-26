<?php
namespace AHT\Salesagents\Api;

interface SalesagentRepositoryInterface
{
   /**
     * Undocumented function
     *
     * @param \AHT\Salesagents\Api\Data\SalesagentInterface $salesagent
     * @return \AHT\Salesagents\Api\Data\SalesagentInterface
     */
    public function save(\AHT\Salesagents\Api\Data\SalesagentInterface $salesagent);
    

    /**
     * Undocumented function
     *
     * @param int $salesagentId
     * @return \AHT\Salesagents\Api\Data\SalesagentInterface
     */
    public function getById($salesagentId);

    /**
     * Undocumented function
     *
     * @param \AHT\Salesagents\Api\Data\SalesagentInterface $salesagents
     * @return \AHT\Salesagents\Api\Data\SalesagentInterface
     */
    public function delete(\AHT\Salesagents\Api\Data\SalesagentInterface $salesagent);
    
    /**
     * Undocumented function
     *
     * @param  int $salesagentsId
     * @return \AHT\Salesagents\Api\Data\SalesagentInterface
     */
    public function deleteById($salesagentId);
}
