<?php

class JLPagination
{
    public int $page;
    public array $pageList;
    public int $pageTotal;
    public int $resultsLimit;
    public int $rayon;
    public int $resultsNb;

    public function __construct(int $rayon)
    {
        $this->page         = 1;
        $this->pageList     = [];
        $this->pageTotal    = 1;
        $this->resultsLimit = 1;
        $this->rayon        = $rayon;
        $this->resultsNb    = 0;
    }

    /**
     * Set active page
     */
    public function setPage(int $page): void
    {
        $this->page = $page < 1 ? 1 : $page;
    }

    /**
     * Calculate total number of pages
     */
    public function setPageTotal(int $resultsNb, int $resultsLimit): void
    {
        $this->resultsNb    = $resultsNb;
        $this->resultsLimit = max(1, $resultsLimit);
        $this->pageTotal    = (int) ceil($resultsNb / $this->resultsLimit);
    }

    /**
     * Get SQL LIMIT clause
     */
    public function getLimit(): string
    {
        return (($this->page - 1) * $this->resultsLimit) . ', ' . $this->resultsLimit;
    }

    /**
     * Build page navigation links
     */
    public function setPageList(string $debutTexte = 'Début', string $finTexte = 'Fin'): void
    {
        $this->pageList = []; // reset each time

        $debut = max(1, $this->page - $this->rayon);
        $fin   = min($this->page + $this->rayon, $this->pageTotal);

        // Add first page link if outside rayon
        if ($debut > 1) {
            $pageObj        = new stdClass();
            $pageObj->value = 1;
            $pageObj->text  = $debutTexte;
            $this->pageList[] = $pageObj;
        }

        // Add main pages
        for ($i = $debut; $i <= $fin; $i++) {
            $pageObj        = new stdClass();
            $pageObj->value = $i;
            $pageObj->text  = (string) $i;
            $this->pageList[] = $pageObj;
        }

        // Add last page link if outside rayon
        if ($fin < $this->pageTotal) {
            $pageObj        = new stdClass();
            $pageObj->value = $this->pageTotal;
            $pageObj->text  = $finTexte;
            $this->pageList[] = $pageObj;
        }
    }
}
