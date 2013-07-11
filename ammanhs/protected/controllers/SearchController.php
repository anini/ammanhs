<?php

class SearchController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'search' action
                'actions' => array('search'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Search is a function to perform search
     * @param <type> $q
     * @param string $sort
     * @param int $page
     * @param <type> $resultsPerPage
     * @return <type> results
     */
    public function actionSearch($q=null, $sort='relevance', $page=1, $results_per_page=10)
    {
        if(!isset($q))
        {
            $this->render('index');
            exit();
        }
        
        $q=urldecode($q);

        $time=microtime();
        $results=Thread::model()->with(array('user'))->findAll(array('condition'=>"title LIKE '%{:q}%' OR tags LIKE '%{:q}%' OR content LIKE '%{:q}%'"), array(':q'=>$q));
        $num_of_results=COUNT($results);
        //$results = Search::find($q, $sort, $page, $results_per_page);
        $time=microtime()-$time;
        $time=sprintf("%.5f", $time);
        $this->render('db_search_results', array(
            'q'=>$q,
            'sort'=>$sort,
            'num_of_results'=>$num_of_results,
            'results'=>$results,
            'time'=>$time,
            ));
        Yii::app()->end();

        $pages=new CPagination();
        $pages->pageSize=$results_per_page;
        $pages->currentPage=$page-1;
        $pages->itemCount=$results['num_of_results'];

        $this->render('results', array(
            'q'=>$results['q'],
            'sort'=>$results['sort'],
            'num_of_results'=>$results['num_of_results'],
            'results_per_page'=>$results['num_of_results'],
            'page'=>$results['page'],
            'results'=>$results['results'],
            'pages'=>$pages,
            'time'=>$time,
            ));
    }
}