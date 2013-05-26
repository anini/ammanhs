<?php

/**
 * Performs commands for the search engine.
 * @author Mohammad Anini
 * @copyright Copyright (c) 2013
 */
class SearchCommand extends CConsoleCommand {

    private static $lock = null;
    private static $lock_fn = null;
    private static $lock_fl = null;
    private static $dataSolr = 0;

    /**
     * getDBConnection is a function that connect with read only DB if exist
     * @return CDbConnection
     */
    protected static function getDbConnection() {
        // Returns the application components.
        /*$component = Yii::app()->getComponents(false);
        if (!isset($component['readonlydb']))
            return Yii::app()->db;
        if (!Yii::app()->readonlydb instanceof CDbConnection)
            return Yii::app()->db;
        return Yii::app()->readonlydb;*/
        return Yii::app()->db;
    }

    /**
     * lock_aquire is a function that prevent other commands run if any commands is running
     * @param <type> $t
     * @return <type>
     */
    private static function lock_aquire($t=null) {
        if ($t === null)
            $t = LOCK_EX | LOCK_NB;
        self::$lock_fn = dirname(__FILE__) . "/../runtime/search.lock";
        // Opens file.
        $fh = fopen(self::$lock_fn, 'w+');
        // Changes file mode
        @chmod(self::$lock_fn, 0777);
        if (!flock($fh, $t))
            return null;
        self::$lock = $fh;
        return $fh;
    }

    /**
     * lock_release is a function that remove the lock.
     * @return <type>
     */
    private static function lock_release() {
        if (!self::$lock_fn)
            return -1;
        // Portable advisory file locking
        flock(self::$lock, LOCK_UN);
        // Closes an open file pointer
        fclose(self::$lock);
        // Deletes a file
        @unlink(self::$lock_fn);
        return 0;
    }

    /**
     * mark_action
     * @param <type> $actionType
     * @return <type>
     */
    private static function mark_action($actionType=null) {
        self::$lock_fl = dirname(__FILE__) . "/../runtime/" . $actionType . ".lock";
        // Open file
        $fh = fopen(self::$lock_fl, 'w+');
        // Change mode
        @chmod(self::$lock_fl, 0777);
        return $fh;
    }

    /**
     * Delete marks
     * @return <type>
     */
    private static function delete_mark_action() {
        if (!self::$lock_fn)
            return -1;
        // Closes an open file pointer
        fclose(self::$lock_fl);
        // Deletes a file
        @unlink(self::$lock_fl);
        return 0;
    }

    /**
     * Create file
     */
    private static function create_unavailable_file() {
        $filename = Yii::app()->basePath . "/runtime/search_engine_down.txt";
        @touch($filename);
    }

    /**
     * Delete file
     */
    private static function delete_unavailable_file() {
        $filename = Yii::app()->basePath . "/runtime/search_engine_down.txt";
        unlink($filename);
    }

    private static function feedRow($object, $replies_by_thread_id, $limit) {
        $host = Yii::app()->params["host"];
            foreach ($object as $obj) {
                if($obj['first_name'] || $obj['last_name'])
                    $user_name = $obj['first_name'].' '.$obj['last_name'];
                else
                    $user_name = $obj['username'];
                $result = array(
                    "id" => 't/' . $obj['thread_id'],
                    "type" => "t",
                    "thread_id" => $obj['thread_id'],
                    "user_id" => $obj['user_id'],
                    "indexed_at" => time(),
                    "created_at" => $obj['created_at'],
                    "updated_at" => $obj['updated_at'],
                    "title" => $obj['title'],
                    "content" => strip_tags($obj['content']),
                    "replies" => $replies_by_thread_id[$obj['thread_id']],
                    "user_name" => $user_name,
                    "user_avatar" => $obj['user_avatar'],
                    "stat_views" => $obj['stat_views'],
                    "stat_votes" => $obj['stat_votes'],
                    "stat_replies" => $obj['stat_replies'],
                    );
                $tags = explode(',', $obj['tags']);
                foreach ($tags as $tag) {
                    $result["tags"][] = $tag;
                }
                if (sizeof($result) > 0)
                    Yii::app()->AmmanHSSearch->updateOneWithoutCommit($result);
                if (self::$dataSolr >= $limit) {
                    self::$dataSolr = 0;
                    Yii::app()->AmmanHSSearch->solrCommit();
                } else {
                    self::$dataSolr++;
                }
        }
    }

    /**
     * Index All threads and it's info
     * @param <type> $index_time
     * @param <type> $limit
     */
    private static function fillData($index_time, $limit, $actionType=null, $sleep=3) {
        print "locking ... \n";
        // locking the command
        if (!self::lock_aquire()) {
            die(" ** could not acuire lock!!\n");
        }
        // Sets access and modification time of file , If the file does not exist, it will be created. 
        if ($actionType == "fullReindex")
            self::create_unavailable_file();

        $last_id = -1;
        $last_thread_id = -1;

        // Get count of data that will be indexed .
        $sql = "SELECT count(*) as count FROM tbl_thread WHERE updated_at > $index_time";

        $count = self::getDbConnection()->createCommand($sql)->queryAll();

        // Print count of data.
        print "To be indexed (" . $count[0]["count"] . ") documents" . chr(10);

        // initialize variable .
        $done_count = 0;
        $size_of_data = 0;
        // Get data [Regions , Sub categories , Categories and Cities]from database.
        $done = false;
        while (!$done) {
            /* Choose the criteria depending on last review id
             * when the reviews of a place more than limit , in the next loop
             * the command will get the rest of these reviews only then complete .
             */
            $continue_point = "thread.id > $last_id";
            // Build Indexing Query 
            $sql = "SELECT
                        thread.id AS thread_id,
                        user.id AS user_id,
                        thread.created_at AS created_at,
                        thread.updated_at AS updated_at,
                        thread.title AS title,
                        thread.content AS content,
                        user.username AS username,
                        user.first_name AS first_name,
                        user.last_name AS last_name,
                        user.avatar_uri AS user_avatar,
                        thread.stat_views AS stat_views,
                        thread.stat_votes AS stat_votes,
                        thread.stat_replies AS stat_replies,
                        thread.tags AS tags
                        FROM tbl_thread AS thread
                        LEFT JOIN tbl_user AS user ON thread.user_id = user.id
                        WHERE $continue_point AND thread.updated_at > $index_time
                        ORDER BY thread.id
                        LIMIT $limit";
            // execute the indexing query
            $objects = self::getDbConnection()->createCommand($sql)->queryAll();
            // Get size of rows
            $size_of_data = sizeof($objects);
            
            // Get the thread ids
            $replies_by_thread_id = array();
            foreach ($objects as $object) {
                $replies_by_thread_id[$object['thread_id']] = array();
            }
            // Return all the keys or a subset of the keys of an array
            $thread_ids = array_keys($replies_by_thread_id);
            // Get all replies of the threads, if exist .
            if (!empty($thread_ids)) {
                $ids = implode(",", $thread_ids);
                // Build replies query
                $sql = "SELECT thread_id, GROUP_CONCAT(DISTINCT content) AS cont
                        FROM tbl_thread_reply AS reply 
                        WHERE thread_id IN ($ids) GROUP BY thread_id;";
                // Execute the query
                $replies = self::getDbConnection()->createCommand($sql)->queryAll();
                // Build replies array
                foreach ($replies as $reply) {
                    $reply['cont'] = strip_tags($reply['cont']);
                    $replies_by_thread_id[$reply['thread_id']] = explode(',', strip_tags($reply['cont']));
                }
            }       
            
            
            $done_count+=$size_of_data;


            self::feedRow($objects, $replies_by_thread_id, $limit);

            if ($count[0]["count"] > 0) {
                printf("** done  with %d records, overall %g %%\n", $size_of_data, 100.0 * $done_count / $count[0]["count"]);
            } else {
                print "No update";
            }

            $done = (sizeof($objects) < $limit);
            if ($done && $last_thread_id != -1) {
                $done = false;
                $last_thread_id = -1;
            }
        } // end while of objects

        // Execute optimize for Solr.
        Yii::app()->AmmanHSSearch->solrCommit();
       
        // execute sleep .
        sleep($sleep);

        self::lock_release();
        $time = time();

        $filename = Yii::app()->basePath . "/runtime/search.txt";
        @file_put_contents($filename, time());
        
        print "\n\n";

        // Delete the files.
        if ($actionType == "fullReindex")
            self::delete_unavailable_file();
    }


    /** This can be useful when (backwards compatible) changes have been made to solrconfig.xml or schema.xml files
     */
    public static function actionReload() {
        try {
            print "\nReloading...";
            shell_exec("wget -O - 'http://localhost:8983/solr/admin/cores?action=RELOAD&core=ammanhs'   1>/dev/null 2>/dev/null");
            print "\ndone\n";
        } catch (Exception $e) {
            print "Error : " . $e->getMessage();
        }
    }

    /**
     * actionUpdate indexing the new data
     * @param <type> $limit
     */
    public function actionUpdate($limit=500, $sleep=3) {
        $time = time();
        $index_time = 0;

        $filename = Yii::app()->basePath . "/runtime/search.txt";
        // Reads entire file into a string.
        $contents = @file_get_contents($filename);
        if ($contents == false) {
            $index_time = -1;
        } else {
            $index_time = (int) ($contents);
        }
        // buil information about this command.
        $info = array('actionType' => 'update');

        switch ($info['actionType']) {
            case 'reindex':
                $this->actionReindex($limit, $sleep);
                break;
            case 'fulReindex':
                $this->actionUpdate($limit, $sleep);
                break;
            case 'update':
                self::updateAfter($index_time, $limit, 'update', $sleep);
        }
    }

    /**
     * actionFullReindex rebuild schema after remove it and indexing the data
     * @param <type> $limit
     */
    public function actionFullReindex($limit=500, $sleep=3) {
        $q = "*:*";
        print 'AmmanHS Search Full Reindex...';
        print "\n\n";
        Yii::app()->AmmanHSSearch->rm($q);
        self::updateAfter(-1, $limit, 'fullReindex', $sleep);
    }

    /**
     * actionReindex re indexing the data
     * @param <type> $limit
     */
    public function actionReindex($limit=500, $sleep=3) {
        self::updateAfter(-1, $limit, 'reindex', $sleep);
    }

    /**
     *  updateAfter is a function that Re-index,Update and Full Re-index.
     * @param <type> $index_time
     * @param <type> $limit
     * @param <type> $actionType
     */
    public function updateAfter($index_time=-1, $limit=500, $actionType=null, $sleep=3) {
        /* if the action type is full re-index , we will create the file
          this approach for if the one of the cores has empty data , it redirect to
          another.
         */
        // Indexing the data.
        self::fillData($index_time, $limit, $actionType, $sleep);
        // remove the lock.
    }

    /**
     * actionClear action clears all data from solr by specific city
     * @param <type> $city
     */
    public function actionClear() {
        print "clearing ";
        $q = "*:*";
        Yii::app()->AmmanHSSearch->rm($q);
        print "Primary Solr ... \n";
        Yii::app()->AmmanHSSearch->rm($q);
        print "[Done]\n";
    }

    /**
     * MarkNow is a function that set time to primary keys.
     */
    public function actionMarkNow() {
        // for debugging
        Yii::app()->cache->set("keep.search.last_index_time", time());
    }

    public function actionIndex() {
        echo "--limit = Number \n\t use it if you want to increase/decrease the amount of data that will \n\t be withdrawn from the Database and stored in Solr at each loop until \n\t the end of all data, this is optional by default limit=500\n";
        echo $this->getHelp();
    }

    /**
     * Represents a response to a ping request to the server
     * @param <type> $search
     */
    public function actionPing() {
        print "AmmanHS Search \n";
        var_dump(Yii::app()->AmmanHSSearch->_solr->ping());
    }

    /**
     * Defragments the index
     * @param <type> $search
     */
    public function actionOptimize() {
        var_dump(Yii::app()->AmmanHSSearch->_solr->optimize());
    }

    public function actionFind($q='*:*', $sort='relevance', $page=1, $results_per_page=1){
        print "\n---------------------------------------\n\n";
        print "Query String: \t\t$q\n";
        print "Sort: \t\t\t$sort\n\n";

        $results = AmmanHSSearch::find($q, $sort, $page, $results_per_page);
        
        print "Number of Results: \t".$results['num_of_results']."\n";
        print "Page of Results: \t".$results['page']."\n";
        print "Results Per Page: \t".$results['results_per_page']."\n";

        print "\nResults:\n";
        foreach ($results['results'] as $result) {
            print "\tThread ID:\t".$result->thread_id."\n";
            print "\tThread Title:\t".$result->title."\n";
            print "\tUser Name:\t".$result->user_name."\n";
            print "\n";
        }
        //var_dump($results);
    }
}
