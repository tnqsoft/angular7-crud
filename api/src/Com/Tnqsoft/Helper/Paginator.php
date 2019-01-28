<?php

namespace Com\Tnqsoft\Helper;

use Com\Tnqsoft\Helper\Request;

class Paginator
{
    /**
     * @var integer
     */
    private $page;

    /**
     * @var integer
     */
    private $limit;

    /**
     * @var integer
     */
    private $maxPage;

    /**
     * @var integer
     */
    private $totalRecord;

    /**
     * @var integer
     */
    private $offset;

    public function __construct($totalRecord, $limit = 10)
    {
        $request = new Request();
        $this->page = intval($request->getQueryParam('page', 1));
        $this->limit = intval($request->getQueryParam('limit', $limit));

        $this->totalRecord = $totalRecord;
        $this->page = ($this->page > 0)?$this->page:1;
        $this->offset = ($this->page-1) * $this->limit;
        $this->maxPage = ceil($this->totalRecord/$this->limit);
    }

    public function getLimitSql()
    {
        return "LIMIT {$this->offset},{$this->limit}";
    }

    /**
     * Get the value of Page
     * @return integer
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Get the value of Max Page
     * @return integer
     */
    public function getMaxPage()
    {
        return $this->maxPage;
    }

    /**
     * Get the value of Total Record
     * @return integer
     */
    public function getTotalRecord()
    {
        return $this->totalRecord;
    }

    /**
     * Get the value of Offset
     * @return integer
     */
    public function getOffset()
    {
        return $this->offset;
    }

    public function getStartRecord()
    {
        return $this->offset + 1;
    }

    public function getEndRecord()
    {
        $end = $this->totalRecord - $this->offset;
        $end = ($end > $this->limit) ? $this->limit : $end;

        return $this->offset + $end;
    }

	/**
	 * Get the value of Limit
	 * @return integer
	 */
	public function getLimit() {
		return $this->limit;
	}

}
