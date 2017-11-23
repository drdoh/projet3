<?php

namespace JeanForteroche\Blog\Model;

class Comment {

    private $_id;
    private $_postId;
    private $_author;
    private $_comment;
    private $_commentDate;
    private $_alert;

    //Hydrate......

    // SETTER
    public function setId($id){
        if(!isint($id)){
            throw new Exception('Erreur : l\'id utilisé n\'est pas un entier');
            return;
        }
        if($id<1){
            throw new Exception('Erreur : l\'id utilisé doit etre positif');
            return;
        }

        $this->_id = $id ;
    }
    
    public function setPostId($postId){
        if(!isint($postId)){
            throw new Exception('Erreur : l\'id utilisé n\'est pas un entier');
            return;
        }
        if($postId<1){
            throw new Exception('Erreur : l\'id utilisé doit etre positif');
            return;
        }
        
        $this->_postId = $postId ;
    }
    
    public function setAuthor($author){
        if(!is_string($author)){
            throw new Exception('Erreur : le nom de l\'auteur utilisé n\'est pas du type string');
            return;
        }
        
        $this->_author = $author ;
    }
    
    public function setComment($comment){
        if(!is_string($comment)){
            throw new Exception('Erreur : le contenu utilisé n\'est pas du type string');
            return;
        }
        
        $this->_comment = $comment ;
    }
    
    public function setCommentDate($date){
        if(!is_string($date)){
            throw new Exception('Erreur : le titre utilisé n\'est pas du type string');
            return;
        }
        
        $this->_commentDate = $date ;
    }
    
    public function setAlert($alert){
        if(!isint($alert)){
            throw new Exception('Erreur : la valeur utilisé n\'est pas un entier');
            return;
        }
        if($alert<1){
            throw new Exception('Erreur : la valeur utilisé doit etre positif');
            return;
        }
        
        $this->_alert = $alert ;
    }
    

    // GETTER
    public function id(){
        return $this->_id;
    }
    public function postId(){
        return $this->_postId;
    }
    public function author(){
        return $this->_author;
    }
    public function comment(){
        return $this->_comment ;
    }
    public function commentDate(){
        return $this->_commentDate;
    }
    public function alert(){
        return $this->_alert;
    }

}