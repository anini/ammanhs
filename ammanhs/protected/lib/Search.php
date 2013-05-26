<?php
/**
 * Class Search performs many functions about search.
 * @author Mohammad Anini
 * @copyright Copyright (c) 2013
 * @version 1.0
 */
class Search {
	/**
	 * This function used to fix search url (fsu)
	 * @param <type> $options
	 * @return <type>
	 */
	protected static function searchFixUrl($options) {
		$fsu = Search::searchBaseUrl(array_keys($options));
		foreach ($options as $key => $value)
			$fsu.="&" . urlencode($key) . "=" . urlencode($value);
		$fsu = preg_replace('/&(&+)/', '&', $fsu);
		$fsu = preg_replace('/\?&/', '?', $fsu);
		$fsu = str_replace('&', '&amp;', $fsu);
		return $fsu;
	}

	/**
	 * This function get the url for search
	 * @param <type> $ommit
	 * @return <type>
	 */
	protected static function searchBaseUrl($ommit) {
		$r = $_SERVER["REQUEST_URI"];
		foreach ($ommit as $i)
			$r = preg_replace('/' . $i . '(=[^&]*)/', '', $r);
		$r = preg_replace('/&(&+)/', '&', $r);
		$r = preg_replace('/&$/', '&', $r);
		return $r;
	}

	/**
	 * @return boolean
	 */
	private static function isAvailabe() {
		return !file_exists(Yii::app()->basePath . "/runtime/search_engine_down.txt");
	}

	/**
     * api_find is a function that search for a query and return results
     * @param <type> $q is a query
     * @param string $sort  is a type of sort relevance, best and newest.
     * @param <type> $page
     * @param <type> $param
     * @return <type> results information
     */
    public static function find($q='*:*', $sort='relevance', $page=1, $results_per_page=10, $offset=false, $debug=false) {
    	if (!self::isAvailabe()) {
    		throw new CHttpException(500, 'Search is not available');
    	}

        if ($page < 1) $page = 1;
        if ($offset === false) $offset = ($page - 1) * $results_per_page;

        // Build all sort links
        $sorts = array(
            'relevance' => 'score desc,stat_replies desc,stat_votes desc',
            'best' => 'stat_votes desc,stat_replies desc,score desc',
            'newest' => 'created_at desc,score desc'
            );

        // Set default sort type
        if (!isset($sorts[$sort])) $sort = 'relevance';

        try {
            // Build Solr query
            $options = array(
                'indent' => 'true',
                'defType' => 'edismax',
                'wt' => 'json',
                'rows' => $results_per_page,
                'start' => $offset
                );

            // set sort type
            switch ($sort) {
                case 'best':
                    $options['qf'] = 'title^20 content^5 tags^20 replies^5';
                    $options['bf'] = 'product(atan(stat_replies),100)^10 product(stat_votes,10)^5 product(stat_views,10)^5 product(created_at,10)^5';
                    break;
                case 'newest':
                    $options['qf'] = 'title^10 content^5 tags^10 replies^5';
                    $options['bf'] = 'product(atan(stat_replies),100)^5 product(stat_votes,10)^5 product(stat_views,10)^5 product(created_at,10)^30';
                    break;
                default:
                    $options['qf'] = 'title^15 content^15 tags^15 replies^15';
                    $options['bf'] = 'product(atan(stat_replies),100)^5 product(stat_votes,10)^5 product(stat_views,10)^5 product(created_at,10)^5';
            }

            $options['sort'] = $sorts[$sort];

            // Get Results from Solr
            $results = Yii::app()->AmmanHSSearch->get($q, $offset, $results_per_page, $options);
        } catch (Exception $e) {
            throw new Exception('Search service is down!');
            return;
        }
  
        $results_info = array(
            'q' => ($q === '*:*') ? '' : $q,
            'sort' => $sort,
            'num_of_results' => $results->response->numFound,
            'results_per_page' => $results_per_page,
            'page' => $page,
            'results' => $results->response->docs,
            );

        return $results_info;
    }
}
