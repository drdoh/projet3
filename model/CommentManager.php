<?php 
namespace JeanForteroche\Blog\Model;

use JeanForteroche\Blog\Model\DBManager;
use \PDO;
require_once('model/Manager.php');

class CommentManager extends DBManager{



    public function addComment($postId, $author, $comment)
    { 
        $comments = $this->_db->prepare('  INSERT INTO comments(post_id, author, comment) 
                                    VALUES (:post_id, :author, :comment)
                                ');
        $affectedLines = $comments->execute(array(
            'post_id'=> $postId,
            'author'=> $author,
            'comment'=> $comment
        ));
    
        return $affectedLines;
    }

    public function getLastComments($postId)
    {
        $req = $this->_db->prepare('SELECT * /*DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr*/
                                    FROM comments 
                                    WHERE post_id = ? AND published = 1
                                    ORDER BY comment_date 
                                    DESC LIMIT 0, 7
                                    ');

        $req->execute(array($postId));
        $datas = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $datas;
    }

    public function getAllComments()
    {
        $req = $this->_db->query('  SELECT *
                                    FROM comments 
                                    ORDER BY comment_date DESC
                                    ');
        $datas = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $datas;
    }

    public function getPostComments($postId)
    {
        $req = $this->_db->prepare('SELECT id, author, comment, alert, post_id,DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr
                                    FROM comments 
                                    WHERE post_id = ? 
                                    ORDER BY comment_date DESC
                                    ');
        $req->execute(array($postId));
        $datas = $req->fetchAll(PDO::FETCH_OBJ);
        $req->closeCursor();
        return $datas;
    }

    public function getComment($commentId)
    {
        $req = $this->_db->prepare('   SELECT id, post_id, author, comment
                                FROM comments
                                WHERE id = ?
                                ');
        $req->execute(array($commentId));
        $comment = $req->fetch();
        return $comment;
    }
    
    public function saveComment($commentId,$author,$comment)
    {
        $req = $this->_db->prepare('   UPDATE comments 
                                SET author= :newauthor, comment= :newcomment
                                WHERE id = :id                                    
                                    ');
        $req->execute(array(
            'newauthor'=>$author,
            'newcomment'=>$comment,
            'id'=>$commentId
        ));
    }

    public function deleteComment($commentId)
    {
        $req = $this->_db->prepare('   DELETE FROM comments 
                                WHERE id = :id                                  
                                ');
        $req->execute(array(
            'id'=>$commentId
        ));
    }

    public function deletePostComment($postId)
    {
        $req = $this->_db->prepare('   DELETE FROM comments 
                                WHERE post_id = :post_id                                  
                                ');
        $req->execute(array(
            'post_id'=>$postId
        ));
    }

    public function alertComment($commentId)
    {
        $req = $this->_db->prepare('   UPDATE comments 
                                SET alert= alert+1
                                WHERE id = :id                                    
                                    ');
        $req->execute(array(
            'id'=>$commentId
        ));
    }

// a simplifier ...
    public function countComments()
    {
        
        $req = $this->_db->query('  SELECT COUNT(*) AS nbcomment
                                    FROM comments 
                                    ');
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;

        
    }

    public function countAlertComments()
    {
        $req = $this->_db->query('  SELECT COUNT(alert) AS nb_alert_comment
                                    FROM comments 
                                    WHERE alert >= 1
                                    ');
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;
    }

     public function countFilteredComments($filter)
    {
        $req = $this->_db->query('  SELECT COUNT('.$filter.') AS nb_'.$filter.'_comment
                                    FROM comments 
                                    WHERE '.$filter.' = TRUE
                                    ');
        $datas = $req->fetchAll(PDO::FETCH_ASSOC);
        $req->closeCursor();
        return $datas;
    }


        public function getPublishedComments()
        {
            $req = $this->_db->query('  SELECT *
                                        FROM comments 
                                        WHERE  published = TRUE
                                        ORDER BY comment_date DESC
                                        ');
            $datas = $req->fetchAll(PDO::FETCH_OBJ);
            
            $req->closeCursor();
            return $datas;
        }

        public function getRejectedComments()
        {
            $req = $this->_db->query('  SELECT *
                                        FROM comments 
                                        WHERE  rejected = TRUE
                                        ORDER BY comment_date DESC
                                        ');
            $datas = $req->fetchAll(PDO::FETCH_OBJ);
            
            $req->closeCursor();
            return $datas;
        }

        public function getAlertComments()
        {
            $req = $this->_db->query('  SELECT *
                                        FROM comments 
                                        WHERE  Alert >= 1
                                        ORDER BY comment_date DESC
                                        ');
            $datas = $req->fetchAll(PDO::FETCH_OBJ);
            
            $req->closeCursor();
            return $datas;
        }

        public function getStandByComments()
        {
            $req = $this->_db->query('  SELECT *
                                        FROM comments 
                                        WHERE stand_by = TRUE
                                        ORDER BY comment_date DESC
                                        ');
            $datas = $req->fetchAll(PDO::FETCH_OBJ);
            
            $req->closeCursor();
            return $datas;
        }

        public function acceptComment($commentId)
        {
            $req = $this->_db->prepare('   UPDATE comments 
                                    SET published= 1, stand_by= 0,rejected= 0, alert=0
                                    WHERE id = :id                                    
                                        ');
            $req->execute(array(
                'id'=>$commentId
            ));
        }

        public function rejetComment($commentId)
        {
            $req = $this->_db->prepare('   UPDATE comments 
                                    SET rejected= 1, stand_by= 0, published= 0
                                    WHERE id = :id                                    
                                        ');
            $req->execute(array(
                'id'=>$commentId
            ));
        }
}