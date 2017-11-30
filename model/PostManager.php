<?php 

namespace JeanForteroche\Blog\Model;
use \PDO;

require_once('model/Manager.php');
require_once('model/Post.php');

class PostManager extends DBManager{
    
    public function getAllPosts()
    {
        $req = $this->_db->query(' SELECT id, title, content, chapter,img, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr
                            FROM posts 
                            ORDER BY id 
                            ');
        $datas = $req->fetchAll();
        $req->closeCursor();
        $posts = [];
        foreach($datas as $data){
            $posts[] = new Post($data);
        }
        return $posts;
    }

    public function getLastPosts()
    {
        $req = $this->_db->query(' SELECT id, title, content, chapter, img, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr
                            FROM posts 
                            ORDER BY id 
                            DESC LIMIT 0, 6
                            ');
        $datas = $req->fetchAll();
        $req->closeCursor();
        $posts = [];
        foreach($datas as $data){
            $posts[] = new Post($data);
        }
        return $posts;
    }

    public function getPost($postId)
    {

        $req = $this->_db->prepare('SELECT */*id, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr*/
                                    FROM posts 
                                    WHERE id = ?
                                    ');

        $req->execute(array($postId));
        $datas = $req->fetch();
        
        $req->closeCursor();
        $post = new Post($datas);
        return $post;
    }

    public function updatePost($title,$content,$id)
    {
        $req = $this->_db->prepare('UPDATE posts 
                                    SET content= :newcontent, title= :newtitle
                                    WHERE id = :id                                    
                                ');
        $req->execute(array(
            'newcontent'=>$content,
            'newtitle'=>$title,
            
            'id'=>$id
        ));
        $req->closeCursor();
    }

    public function addPost($title,$content,$chapter, $img)
    {

        $req = $this->_db->prepare('   INSERT INTO posts(title, content, chapter, img) 
                                VALUES (:title,:content, :chapter, :img)                                  
                                ');
        $req->execute(array(
            'title'=>$title,
            'content'=>$content,
            'chapter'=>$chapter,
            'img'=>$img
        ));
        $req->closeCursor();
    }
    
    public function deletePost($id)
    {

        $req = $this->_db->prepare('   DELETE FROM posts 
                                WHERE id = :id                                  
                                ');
        $req->execute(array(
            'id'=>$id
        ));
        $req->closeCursor();
    }

}