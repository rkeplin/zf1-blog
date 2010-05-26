<?php

class Zend_View_Helper_Comments extends Zend_View_Helper_Abstract
{
    public function comments(Model_CommentCollection $comments)
    {
        
        if(count($comments) == 0)
        {
            return 'Be the first to comment.';
        }
        
        $count = count($comments);
        
        $string = '';
        
        for($i = 0; $i < $count; $i++)
        {
            $comment = $comments->getItem($i);
            
            if(!$comment->parent_id)
            {
                $string .= $this->_printComment($comment);
                
                for($j = 0; $j < $count; $j++)
                {
                    $reply = $comments->getItem($j);
                    
                    if($reply->parent_id == $comment->id)
                    {
                        $string .= $this->_printComment($reply, true);
                    }
                }
            }
        }
        
        return $string;
    }
    
    public function _printComment(Model_Comment $comment, $is_child = false)
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
        
        $string = '<div id="comment-'. $comment->id .'" class="comment-container'. $extra .'">';
            $string .= '<h2>'. $author .' - '. date("F jS, Y @ g:ia", strtotime($comment->date_added)) . ' <a class="reply" title="Reply to this comment" href="javascript:replyToComment(\''. $comment->id .'\')">reply</a></h2>';
            $string .= '<div class="comment">';
                
                $gravatar = $this->view->gravatar($comment->email, array('imgSize' => 50), array('alt' => 'gravatar', 'title' => 'avatar' ));
                
                $string .= '<div class="photo">
                                <a title="Get a gravatar" href="http://www.gravatar.com">
                                    '. $gravatar .'
                                </a>
                            </div>';
            
                $string .= $comment->comment;
                $string .= '<div class="clear"></div>';
            $string .= '</div>';
        $string .= '</div>';
        
        return $string;
    }
}