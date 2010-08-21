<?php

class Zend_View_Helper_Comments extends Zend_View_Helper_Abstract
{
    public function comments(Model_CommentCollection $comments)
    {
        $count = count($comments);
        
        if($count == 0)
        {
            return 'Be the first to comment.';
        }
        
        $service = new Service_Comment();
        $delete_rights = false;
        
        if($service->checkAcl('delete'))
        {
            $delete_rights = true;
        }
        
        $string = '';
        
        for($i = 0; $i < $count; $i++)
        {
            $comment = $comments->getItem($i);
            
            if(!$comment->parent_id)
            {
                $string .= $this->_printComment($comment, false, $delete_rights);
                
                for($j = 0; $j < $count; $j++)
                {
                    $reply = $comments->getItem($j);
                    
                    if($reply->parent_id == $comment->id)
                    {
                        $string .= $this->_printComment($reply, true, $delete_rights);
                    }
                }
            }
        }
        
        if($delete_rights)
        {
            $string .= $this->view->render('delete-comment-js.phtml');
        }
        
        return $string;
    }
    
    public function _printComment(Model_Comment $comment, $is_child = false, $delete_rights = false)
    { 
        $extra = ($comment->email == 'rkeplin@gmail.com') ? ' rob' : '';
        $extra .= ($is_child) ? ' reply' : '';
        
        if($comment->website)
        {
            $author = '<a title="'. $comment->name .'\'s website" href="'. $comment->website .'">'. $comment->name . '</a>';
        }
        else
        {
            $author = $comment->name;
        }
        
        if($delete_rights)
        {
            $del_link = ' | <a class="reply" title="delete comment" href="javascript:deleteComment(' . $comment->id . ')">delete</a>';
        }
        else
        {
            $del_link = '';
        }
        
        $string = '<div id="comment-'. $comment->id .'" class="comment-container'. $extra .'">';
            $string .= '<h2>'. $author .' - '. date("F jS, Y @ g:ia", strtotime($comment->date_added)) . ' <a class="reply" title="Reply to this comment" href="javascript:replyToComment(\''. $comment->id .'\')">reply</a> '. $del_link .'</h2>';
            $string .= '<div class="comment">';
                
                $gravatar = $this->view->gravatar($comment->email, array('imgSize' => 50), array('alt' => 'gravatar', 'title' => 'avatar' ));
                
                $string .= '<div class="photo">
                                <a title="Get a gravatar" href="http://www.gravatar.com">
                                    '. $gravatar .'
                                </a>
                            </div>';
            
                $string .= stripslashes($comment->comment);
                $string .= '<div class="clear"></div>';
            $string .= '</div>';
        $string .= '</div>';
        
        return $string;
    }
}