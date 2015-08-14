<?php

/**
 * Pagination Class for common Pagination needs
 *
 * @author hakre <http://hakre.wordpress.com/>
 * @link http://stackoverflow.com/a/15741465/367456
 * @link http://stackoverflow.com/a/14184729/367456
 */
class LimitPagination
{
    private $perPage, $page, $totalCount;

    /**
     * @param int $page
     * @param int $totalCount
     * @param int $perPage
     */
    public function __construct($page, $totalCount, $perPage = 10) {

        $this->setPerPage($perPage);
        $this->setTotalCount($totalCount);
        $this->setPage($page);
    }

    public function getPerPage() {

        return $this->perPage;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage($perPage) {

        $this->perPage = max(1, (int) $perPage);
    }

    /**
     * @return int
     */
    public function getTotalCount() {

        return $this->totalCount;
    }

    /**
     * @param int $totalCount
     */
    public function setTotalCount($totalCount) {

        $this->totalCount = max(0, (int) $totalCount);
    }

    /**
     * @return int
     */
    public function getPage() {

        return min($this->getTotalPages(), $this->page);
    }

    /**
     * @param int $page
     */
    public function setPage($page) {

        $this->page = min($this->getTotalPages(), max(1, (int) $page));
    }

    /**
     * @return int
     */
    public function getNextPage() {

        return min($this->getTotalPages(), $this->page + 1);
    }

    /**
     * @return int
     */
    public function getPreviousPage() {

        return max(1, $this->page - 1);
    }

    /**
     * @return int
     */
    public function getTotalPages() {

        return (int) ceil($this->totalCount / $this->perPage);
    }

    /**
     * @return bool
     */
    public function isFirstPage() {

        return $this->page === 1;
    }

    /**
     * @return bool
     */
    public function isLastPage() {

        return $this->page === $this->getTotalPages();
    }

    /**
     * @return int
     */
    public function getOffset() {

        return ($this->getPage() - 1) * $this->perPage;
    }

    /**
     * @return int
     */
    public function getCount() {

        return $this->perPage;
    }

    /**
     * @return string
     */
    public function getSqlLimit() {

        return sprintf("LIMIT %d, %d", $this->getOffset(), $this->getCount());
    }

    /**
     * @return LimitIterator
     */
    public function getLimitIterator(Traversable $it) {
       if (!$it instanceof Iterator) {
           $it = new IteratorIterator($it);
       }
       return new LimitIterator($it, $this->getOffset(), $this->getCount());
    }

    /**
     * @return array
     */
    public function getPageRange() {
        return $this->getTotalPages() ? range(1, $this->getTotalPages()) : array();
    }

    public function __toString() {

        return $this->getSqlLimit();
    }
}
